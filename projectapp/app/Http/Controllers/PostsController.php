<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Posts;
use Illuminate\Support\Facades\DB;


class PostsController extends Controller
{
     public function postAction(Request $request,$param = ''){
    	switch ($param) {
    		case 'save':
                $request->validate([
                    'dep_id' => ['required'],
					'name' => 'required'
                ]);
				
    			$response = $this->savePost($request);
                if(isset($request->id)){
                    return redirect()->back()->with('success', 'Post updated successfully.');
                }else{
                    return redirect()->back()->with('success', 'Post created successfully.');
                }
               
    			break;    		
			case 'add':
			   $departments = Department::all();
                return view('components.common.posts.create', compact('departments'));
    			break;
            case 'delete':
                $response = $this->deletePost($request->id);
                if($response === true){
                    return response()->json(['success'=>true,'message'=>'Record deleted successfully.'],200);
                }else{
                    return response()->json(['success'=>false,'message'=>'Something went wrong.'],200);
                }
                break;
            case 'edit':
                $post = Posts::find($_GET['id']);
                $departments = Department::all();
              
                if(empty($post)){
                    return redirect('/404');
                }
                return view('components.common.posts.create', compact('post','departments'));
                break;
    		case 'list':
			  $posts = DB::table('posts')
						->join('departments', 'posts.dep_id', '=', 'departments.id')
						->select('posts','departments.name as depname')
						->paginate(30)->withQueryString();
                return view('components.common.posts.list', compact('posts'));
                break;
    		default:
    			 $posts = DB::table('posts')
						->join('departments', 'posts.dep_id', '=', 'departments.id')
						->select('posts.*','departments.name as depname')
						->paginate(30)->withQueryString();
                return view('components.common.posts.list', compact('posts'));
                break;
    	}
    }

	public function savePost($data){
        $post = (!isset($data->id)) ? new Posts : Posts::find($data->id);
        $post->name = $data->name;
        $post->rank = $data->rank;
        $post->dep_id = $data->dep_id;
	
        if($post->save()){
            return true;
        }else{
            return false;
        }
    }

    private function deletePost($id){
		try{
           if(Posts::where('id', $id)->delete()){
				return true;
			}else{
				return false;
			}
        }
        catch(Exception $e) {
          return 'Post associcated with many records. Cannot delete it directly.';
        }
        
    }

}

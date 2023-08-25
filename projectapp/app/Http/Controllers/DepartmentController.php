<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
     public function departmentAction(Request $request,$param = null){
    	switch ($param) {
    		case 'save':
                $request->validate([
                    'name' => 'required'
                ]);
    			$response = $this->saveDepartment($request);
                if(isset($request->id)){
                    return redirect()->back()->with('success', 'Department updated successfully.');
                }else{
                    return redirect()->back()->with('success', 'Department created successfully.');
                }
                
    			break;
			case 'add':
    			return view('components.common.departments.create');
    			break;
    		case 'list':
                return view('components.common.departments.list', [
                    'departments' => (isset($_GET['search']))?DB::table('departments')->where('name','like','%'.$_GET['search'].'%')->paginate(30)->withQueryString() :DB::table('departments')->paginate(30)
                ]);
                break;
            case 'delete':
                $response = $this->deleteDepartment($request->id);
                if($response === true){
                    return response()->json(['success'=>true,'message'=>'Record deleted successfully.'],200);
                }else{
                    return response()->json(['success'=>false,'message'=>$response],200);
                }
                break;
            case 'edit':
                $department = Department::find($_GET['id']);
                if(empty($department)){
                    return redirect('/404');
                }
                return view('components.common.departments.create', compact('department'));
                break;
    		default:
    			return view('components.common.departments.list', [
                    'departments' => (isset($_GET['search']))?DB::table('departments')->where('name','like','%'.$_GET['search'].'%')->paginate(30)->withQueryString() :DB::table('departments')->paginate(30)
                ]);
                break;
    	}
    }


    public function saveDepartment($data){

        $department = (!isset($data->id)) ? new Department : Department::find($data->id);
        $department->name = $data->name;
		if(isset($data->questions)&&!empty($data->questions)){
			$questionArr=array();
			$i=0;
			foreach($data->questions as $item){
				$record=array();
				$record['question']=$item;
				$record['answer']=$data->answers[$i];
				$questionArr[]=$record;
				$i++;
			}
			$department->questions = serialize($questionArr);
		}
        if($department->save()){
            return true;
        }else{
            return false;
        }
    }

    private function deleteDepartment($id){
        try{
			if(DB::table('posts')->where('dep_id',$id)->exists()){
                return 'Department associcated with many posts. Cannot delete it directly.';
            }
            if(Department::where('id', $id)->delete()){
                return true;
            }else{
                return 'Something went wrong';
            }
        }
        catch(Exception $e) {
                return 'Department associcated with many posts. Cannot delete it directly.';
        }
		
    }
}

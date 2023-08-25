<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Models\Country;
use Illuminate\Support\Facades\DB;

class StateController extends Controller
{
     public function stateAction(Request $request,$param = ''){
    	switch ($param) {
    		case 'add':
                $countries = Country::all();
    			return view('components.common.states.create', compact('countries'));
    			break;
			case 'save':
                $request->validate([
                    'name' => 'required'
                ]);
    			$response = $this->saveState($request);
                if(isset($request->id)){
                    return redirect()->back()->with('success', 'State updated successfully.');
                }else{
                    return redirect()->back()->with('success', 'State created successfully.');
                }
               
    			break;
            case 'delete':
                $response = $this->deleteState($request->id);
                if($response === true){
                    return response()->json(['success'=>true,'message'=>'Record deleted successfully.'],200);
                }else{
                    return response()->json(['success'=>false,'message'=>'Something went wrong.'],200);
                }
                break;
            case 'edit':
                $state = State::find($_GET['id']);
                if(empty($state)){
                    return redirect('/404');
                }
				$countries = Country::all();
                return view('components.common.states.create', compact('countries','state'));
                break;
    		case 'list':
			    $countries = Country::all();

                return view('components.common.states.list', ['countries' => $countries,
                    'states' => (isset($_GET['search']))?DB::table('states')->where('name','like','%'.$_GET['search'].'%')->paginate(30)->withQueryString() :DB::table('states')->paginate(30)->withQueryString()
                ]);
                break;
    		default:
				$countries = Country::all();

                return view('components.common.states.list', ['countries' => $countries,
                    'states' => (isset($_GET['search']))?DB::table('states')->where('name','like','%'.$_GET['search'].'%')->paginate(30)->withQueryString() :DB::table('states')->paginate(30)->withQueryString()
                ]);
                break;
    	}
    }

	public function saveState($data){
        $state = (!isset($data->id)) ? new State : State::find($data->id);
        $state->country_id = $data->country;
        $state->name = $data->name;
        $state->slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $data->name));
        if($state->save()){
            return true;
        }else{
            return false;
        }
    }

    private function deleteState($id){
        
		try{
            if(DB::table('companies')->where('state_id',$id)->exists()){
                return 'State associcated with many companies and cities. Cannot delete it directly.';
            }
			if(DB::table('cities')->where('state_id',$id)->exists()){
                return 'State associcated with many companies and cities. Cannot delete it directly.';
            }
            if(State::where('id', $id)->delete()){
            return true;
			}else{
				return false;
			}
        }
        catch(Exception $e) {
          return 'State associcated with many records. Cannot delete it directly.';
        }
    }

}

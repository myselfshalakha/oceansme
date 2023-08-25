<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agency;
use App\Models\Country;
use Illuminate\Support\Facades\DB;
use Auth;

class AgencyController extends Controller
{
   public function agencyAction(Request $request,$param = ''){
    	switch ($param) {
    		case 'save':
                $request->validate([
                    'name' => 'required',
                    'email' => 'required',
                    'phone' => 'required',
                    'country_id' => 'required'
                ]);
    			$response = $this->saveAgency($request);
                if(isset($request->id)){
                    return redirect()->back()->with('success', 'Agency updated successfully.')->with('activeTab','agencies'); ;
                }else{
                    return redirect()->back()->with('success', 'Agency created successfully.')->with('activeTab','agencies'); ;
                }
               
    			break;    		
			case 'add':
			if(!Auth::user()->hasRole('super_admin')){
					  return redirect('/404');
				}
                return view('components.common.agencies.create');
    			break;
            case 'delete':
                $response = $this->deleteAgency($request->id);
                if($response === true){
                    return response()->json(['success'=>true,'message'=>'Record deleted successfully.'],200);
                }else{
                    return response()->json(['success'=>false,'message'=>'Something went wrong.'],200);
                }
                break;
            case 'edit':
			
			if(Auth::user()->hasRole('hr_manager')){
				$event = DB::table('events')->select('events.*')->join('event_teams', 'event_teams.event_id', '=', 'events.id')->where('event_teams.user_id','=', Auth::user()->id)->whereIn('status', ["1","2","3"])->first();
				$agency = Agency::where('id', $_GET['id'])->where('event_id', '=', $event->id)->first();
			}else{
				$agency = Agency::find($_GET['id']);
			}
                if(empty($agency)){
                    return redirect('/404');
                }
                $countries = Country::all();
                return view('components.common.agencies.create', compact('agency','countries'));
                break;
    		default:
			if(!Auth::user()->hasRole('super_admin')){
					  return redirect('/404');
				}
    			return view('components.common.agencies.list', [
                    'agencies' => (isset($_GET['search']))?DB::table('agencies')->where('name','like','%'.$_GET['search'].'%')->paginate(30)->withQueryString() :DB::table('agencies')->paginate(30)->withQueryString()
                ]);
                break;
    	}
    }

	public function saveAgency($data){
        $agency = (!isset($data->id)) ? new Agency : Agency::find($data->id);
        $agency->name = $data->name;
        $agency->email = $data->email;
        $agency->phone = $data->phone;
        $agency->event_id = $data->event_id;
        $agency->address = $data->address;
        $agency->country_id = (!empty($data->country_id))?serialize($data->country_id):null;;
        if($agency->save()){
            return true;
        }else{
            return false;
        }
    }

    private function deleteAgency($id){
		try{
            if(Agency::where('id', $id)->delete()){
				return true;
			}else{
				return false;
			}
        }
        catch(Exception $e) {
          return 'Agency associcated with many records. Cannot delete it directly.';
        }
        
    }

}

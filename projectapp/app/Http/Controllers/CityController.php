<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;
use App\Models\City;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    
    public function cityAction(Request $request,$param = ''){
    	switch ($param) {
    		case 'save':
                $request->validate([
                    'name' => 'required'
                ]);
    			$response = $this->saveCity($request);
                if(isset($request->id)){
                    return redirect()->back()->with('success', 'City updated successfully.');
                }else{
                    return redirect()->back()->with('success', 'City created successfully.');
                }
                
    			break;
			case 'add':
                $states = State::all();
    			return view('components.common.cities.create',compact('states'));
    			break;
    		case 'list':
                return view('components.common.cities.list', [
                    'cities' => (isset($_GET['search']))?DB::table('cities')->where('name','like','%'.$_GET['search'].'%')->paginate(30)->withQueryString() :DB::table('cities')->paginate(30)
                ]);
                break;
            case 'delete':
                $response = $this->deleteCity($request->id);
                if($response === true){
                    return response()->json(['success'=>true,'message'=>'Record deleted successfully.'],200);
                }else{
                    return response()->json(['success'=>false,'message'=>$response],200);
                }
                break;
            case 'edit':
                $city = City::find($_GET['id']);
                if(empty($city)){
                    return redirect('/404');
                }
                $states = State::all();
                return view('components.common.cities.create', compact('city','states'));
                break;
    		default:
    			return view('components.common.cities.list', [
                    'cities' => (isset($_GET['search']))?DB::table('cities')->where('name','like','%'.$_GET['search'].'%')->paginate(30)->withQueryString() :DB::table('cities')->paginate(30)
                ]);
                break;
    	}
    }


    public function saveCity($data){

        $city = (!isset($data->id)) ? new City : City::find($data->id);
        $city->name = $data->name;
        $city->state_id =  $data->state;
        $city->slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $data->name));
        if($city->save()){
            return true;
        }else{
            return false;
        }
    }

    private function deleteCity($id){
        try{
			if(DB::table('companies')->where('city_id',$id)->exists()){
                return 'City associcated with many companies. Cannot delete it directly.';
            }
            if(City::where('id', $id)->delete()){
                return true;
            }else{
                return 'Something went wrong';
            }
        }
        catch(Exception $e) {
          return 'City associcated with many records. Cannot delete it directly.';
        }
		
    }


}

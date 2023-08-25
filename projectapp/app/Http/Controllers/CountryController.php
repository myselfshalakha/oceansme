<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use Illuminate\Support\Facades\DB;

class CountryController extends Controller
{
   public function countryAction(Request $request,$param = ''){
    	switch ($param) {
    		case 'save':
                $request->validate([
                    'name' => 'required',
                    'sortname' => 'required',
                    'phonecode' => 'required'
                ]);
    			$response = $this->saveCountry($request);
                if(isset($request->id)){
                    return redirect()->back()->with('success', 'Country updated successfully.');
                }else{
                    return redirect()->back()->with('success', 'Country created successfully.');
                }
               
    			break;    		
			case 'add':
                return view('components.common.countries.create');
    			break;
            case 'delete':
                $response = $this->deleteCountry($request->id);
                if($response === true){
                    return response()->json(['success'=>true,'message'=>'Record deleted successfully.'],200);
                }else{
                    return response()->json(['success'=>false,'message'=>'Something went wrong.'],200);
                }
                break;
            case 'edit':
                $country = Country::find($_GET['id']);
                if(empty($country)){
                    return redirect('/404');
                }
                return view('components.common.countries.create', compact('country'));
                break;
    		case 'list':
                return view('components.common.countries.list', [
                    'countries' => (isset($_GET['search']))?DB::table('countries')->where('name','like','%'.$_GET['search'].'%')->paginate(30)->withQueryString() :DB::table('countries')->paginate(30)->withQueryString()
                ]);
                break;
    		default:
    			return view('components.common.countries.list', [
                    'countries' => (isset($_GET['search']))?DB::table('countries')->where('name','like','%'.$_GET['search'].'%')->paginate(30)->withQueryString() :DB::table('countries')->paginate(30)->withQueryString()
                ]);
                break;
    	}
    }

	public function saveCountry($data){
        $country = (!isset($data->id)) ? new Country : Country::find($data->id);
        $country->name = $data->name;
        $country->sortname = $data->sortname;
        $country->phonecode = $data->phonecode;
        $country->slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $data->name));
        if($country->save()){
            return true;
        }else{
            return false;
        }
    }

    private function deleteCountry($id){
		try{
            if(DB::table('companies')->where('country_id',$id)->exists()){
                return 'Country associcated with many companies and states. Cannot delete it directly.';
            }
			if(DB::table('states')->where('country_id',$id)->exists()){
                return 'Country associcated with many companies and states. Cannot delete it directly.';
            }
            if(Country::where('id', $id)->delete()){
				return true;
			}else{
				return false;
			}
        }
        catch(Exception $e) {
          return 'Country associcated with many records. Cannot delete it directly.';
        }
        
    }

}

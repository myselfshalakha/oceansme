<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\State;
use App\Models\Country;
use App\Models\Company;
use App\Models\Events;
use App\Models\Posts;
use App\Models\Department;
use App\Models\CompanySalarySystem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Rules\PhoneNumber;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CompanyController extends Controller
{
    //
	public function companyAction(Request $request,$param = null){
        switch ($param) {
            case 'save':
                 $this->validate($request,[
						'name' => ['string', 'max:255'],
						'email' => ['string', 'max:255'],
						'address' => ['required', 'string', 'max:255'],
						'logo' => ['nullable', 'mimes:png,jpg,jpeg', 'max:1024'],
						'website' => ['required','regex:/^(http:\/\/|https:\/\/)?([a-z0-9]+(-[a-z0-9]+)*\.)+[a-z]{2,}$/i'

],
						'phone' => ['string', new PhoneNumber]
                ]);
				
					$image_full_name="";
					if(!empty($request->logo)){
						$image_name = time();
						$image_ext = strtolower($request->logo->getClientOriginalExtension()); 
						$image_full_name = $image_name.'.'.$image_ext;
						$upload_path = 'assets/images/company/';    
						$image_url = $upload_path.$image_full_name;
						$successUpload = $request->logo->move($upload_path,$image_full_name);
					}
                    $response = $this->saveCompany($request,$image_full_name);
					if(isset($request->id)){
                    return redirect()->back()->with('success', 'Company updated successfully.');
					}else{
						return redirect()->back()->with('success', 'Comapny created successfully.');
					}
                break;
			case 'save_salary':
                 $this->validate($request,[
						'dep_id' => ['required'],
						'post_id' => ['required'],
						'company_id' => ['required'],
						'basic_wage' => ['nullable','numeric'],
						'other_contractual' => ['nullable','numeric'],
						'guaranteed_wage' => ['nullable','numeric'],
						'service_charge' => ['nullable','numeric'],
						'additional_bonus' => ['nullable','numeric'],
						'bonus_level' => ['nullable','string', 'max:255'],
						'bonus_personam' => ['nullable','string', 'max:255'],
						'total_salary' => ['nullable','numeric'],
						'incentive_type' => ['nullable','string', 'max:255'],
						'contract_length' => ['nullable','string', 'max:255'],
						'vacation_month' => ['nullable','string', 'max:255'],
						'status' => ['nullable','string', 'max:255']
                ]);
				  $checkpost = $this->checkCompanySalaryExist($request);
				  if($checkpost==false){
					  return redirect()->back()->with('error', 'Cannot make duplicate salary')->with('activeTab','salary_system'); 
				  }

                    $response = $this->saveCompanySalarySystem($request);
					if(isset($request->id)){
						return redirect()->back()->with('success', 'Salary System updated successfully.')->with('activeTab','salary_system'); 
					}else{
						return redirect()->back()->with('success', 'Salary System created successfully.')->with('activeTab','salary_system'); 
					}
                break;
			case 'delete':
                $response = $this->deleteCompany($request->id);
                if($response === true){
                    return response()->json(['success'=>true,'message'=>'Record deleted successfully.'],200);
                }else{
                    return response()->json(['success'=>false,'message'=>'Something went wrong.'],200);
                }
                break;	
			case 'delete_salary':
                $response = $this->deleteSalary($request->id);
                if($response === true){
                    return response()->json(['success'=>true,'message'=>'Record deleted successfully.'],200);
                }else{
                    return response()->json(['success'=>false,'message'=>'Something went wrong.'],200);
                }
                break;
			case 'add':
                $countries = Country::all();
                return view('super_admin.companies.create', compact('countries'));
                break;
			case 'getState':
                 $options = State::where('country_id', $request->id)->get();
                return view('components.getOptions', compact('options'));
                break;
			case 'getPost':
                 $options = Posts::where('dep_id', $request->id)->get();
                 $ispost = true;
                 $other = false;
                return view('components.getOptions', compact('options','other','ispost'));
                break;
			case 'getCity':
                 $options = City::where('state_id', $request->id)->get();
                return view('components.getOptions', compact('options'));
                break;
			case 'edit':
                $company = Company::find($_GET['id']);
                if(empty($company)){
                    return redirect('/404');
                }
                $countries = Country::all();
                $company_salary_system = CompanySalarySystem::where('company_id', $company->id)->get();
                $states = State::where('country_id', $company->country_id)->get();
                $cities = City::where('state_id', $company->state_id)->get();
				$departments = Department::all();
                return view('super_admin.companies.edit', compact('company','departments','company_salary_system','countries','cities','states'));
                break;	
			case 'salary_system':
                $company_salary_system = CompanySalarySystem::find($_GET['id']);
                if(empty($company_salary_system)){
                    return redirect('/404');
                }
                $departments = Department::all();
                $posts = Posts::where('dep_id', $company_salary_system->dep_id)->get();
                return view('super_admin.companies.salary_system', compact('departments','company_salary_system','posts'));
                break;				
			case 'list':
                return view('super_admin.companies.list', [
                    'companies' => (isset($_GET['search']))?DB::table('companies')->where('name','like','%'.$_GET['search'].'%')->paginate(30)->withQueryString() :DB::table('companies')->paginate(30)
                ]);
                break;
			default:
                 return view('super_admin.companies.list', [
                    'companies' => (isset($_GET['search']))?DB::table('companies')->where('name','like','%'.$_GET['search'].'%')->paginate(30)->withQueryString() :DB::table('companies')->paginate(30)
                ]);
                break;
        }
    }
	   public function saveCompany($data,$logo){
        $company = (!isset($data->id)) ? new Company : Company::find($data->id);
		$company->city_id  = $data->city ;
		$company->country_id = $data->country ;
		$company->state_id = $data->state;
		$company->evaluate_by_company =$data->evaluate_by_company ;
		$company->name =$data->name ;
		$company->address =$data->address ;
		$company->address2 =$data->landmark ;
		if(!empty($logo)){
			$company->logo =  $logo;
		}
		$company->phone =$data->phone ;
		$company->website_link =$data->website ;
		$company->email =$data->email ;
		$company->description = $data->description ;
		// $company->loi = $data->loi ;
        if($company->save()){
             
            return true;
        }else{
            return false;
        }
    }
	public function saveCompanySalarySystem($data){
        $salary = (!isset($data->id)) ? new CompanySalarySystem : CompanySalarySystem::find($data->id);
		$salary->dep_id  = $data->dep_id ;
		$salary->post_id = $data->post_id ;
		$salary->company_id = $data->company_id;
		/* $salary->basic_wage =$data->basic_wage ;
		$salary->other_contractual =$data->other_contractual ;
		$salary->guaranteed_wage =$data->guaranteed_wage ;
		$salary->service_charge =$data->service_charge ;
		$salary->additional_bonus =$data->additional_bonus ;
		$salary->bonus_level =$data->bonus_level ;
		$salary->bonus_personam = $data->bonus_personam ;
		$salary->incentive_type = $data->incentive_type ;
		$salary->status = $data->status ; */
		$salary->total_salary = $data->total_salary ;
		$salary->min_eng = $data->min_eng ;
		$salary->contract_length = $data->contract_length ;
		$salary->contract_length_loi = $data->contract_length_loi ;
		$salary->vacation_month = $data->vacation_month ;
		$salary->start_up = $data->start_up ;
		$salary->first_reliever = $data->first_reliever ;
		$salary->contract_currency = $data->contract_currency ;
		$salary->seniority = $data->seniority ;
		$salary->level_additional_comp = $data->level_additional_comp ;
		$salary->seniority_range = $data->seniority_range ;
	
        if($salary->save()){
             
            return true;
        }else{
            return false;
        }
    }
    private function deleteCompany($id){
		try{
			CompanySalarySystem::where('company_id', $id)->delete();
			Events::where('company_id', $id)->delete();
            if(Company::where('id', $id)->delete()){
                return true;
            }else{
                return 'Something went wrong';
            }
        }
        catch(Exception $e) {
          return 'Company associcated with many records. Cannot delete it directly.';
        }
		 catch(Error $e) {
          return 'Company associcated with many records. Cannot delete it directly.';
        }
		
    }  
	private function checkCompanySalaryExist($data){
	
		if(isset($data->id)){
			if(DB::table('company_salary_systems')->where('company_id',$data->company_id)->where('post_id',$data->post_id)->where('id',"!=",$data->id)->count()>0){
				return false;
			}
		}else{
			if(DB::table('company_salary_systems')->where('company_id',$data->company_id)->where('post_id',$data->post_id)->count()>0){
				return false;
			}

		}
	 
		return true;
    } 
	private function deleteSalary($id){
		try{
			
            if(CompanySalarySystem::where('id', $id)->delete()){
                return true;
            }else{
                return 'Something went wrong';
            }
        }
        catch(Exception $e) {
          return 'Company associcated with many records. Cannot delete it directly.';
        }
		
    }
  
}

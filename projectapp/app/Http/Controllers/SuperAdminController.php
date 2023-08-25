<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\RoleUser;
use Auth;
use Hash;
use Illuminate\Support\Facades\Validator;
use App\Rules\PhoneNumber;
use Illuminate\Support\Facades\DB;

class SuperAdminController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin');
    } 

	
    public function index() 
    {
        return view('super_admin.home');
    }
	
	public function userAction(Request $request,$param = null){

		switch ($param) {
    		case 'edit':
				$user = User::find($_GET['id']);
				$role_user = $this->getRoleid($user->id);
                return view('super_admin.profile.edit', compact('user','role_user'));
                break;
            case 'update':
                $this->validate($request,[
                     'firstname' => ['required', 'string', 'max:255'],
						'lastname' => ['string', 'max:255'],
						'gender' => ['required', 'string', 'max:255'],
						'contactno' => ['string', new PhoneNumber],
						'whatsapp' => ['string', new PhoneNumber],
                ]);
                $response = $this->changeProfile($request);

                return redirect()->back()->with('success', 'Profile change successfully.'); 
                break;
			case 'changepassword':
				$this->validate($request,[
				'password' =>'required|string|min:8',
				]);
				$response = $this->changepassword($request);
                 return redirect()->back()->with('success', 'Password change successfully.'); 
                break; 
			case 'changeprofileimage':
				$this->validate($request,[
					'profileimage' => 'required|mimes:png,jpg,jpeg|max:2048'
					]);
					 $image_name = time();
					$image_ext = strtolower($request->profileimage->getClientOriginalExtension()); // You can use also getClientOriginalName()
					$image_full_name = $image_name.'.'.$image_ext;
					$upload_path = 'assets/images/userprofile/';    //Creating Sub directory in Public folder to put image
					$image_url = $upload_path.$image_full_name;
					$success = $request->profileimage->move($upload_path,$image_full_name);
					$response = $this->changeprofileimage($request,$image_full_name);
					 return redirect()->back()->with('success', 'Profile Image change successfully.'); 
				break; 
    		default:
				$user = User::find(Auth::user()->id);
				$role_user = $this->getRoleid(Auth::user()->id);
                return view('super_admin.profile.edit', compact('user','role_user'));
			break;
    	}
	}
	 public function changeProfile($data){

        $user =  User::find($data->id);
        $user->firstname = $data->firstname;
        $user->lastname =  $data->lastname;
        $user->gender =  $data->gender;
        $user->contactno =  $data->contactno;
        $user->whatsapp =  $data->whatsapp;

        if($user->save()){
            return true;
        }else{
            return false;
        }
    }
	 public function changeProfileImage($data,$file__name){

        $user =  User::find($data->id);
        $user->profileimage = $file__name;

        if($user->save()){
            return true;
        }else{
            return false;
        }
    }
    public function changepassword($data){
        $user =  User::find($data->id);
        $user->password = Hash::make($data->password);

        if($user->save()){  
            return true;    
        }else{
            return false;
        }
    }
	 public function getRoleid($userid){
         
         $roldeid = DB::table('role_user')->select('role_user.role_id')->where('user_id', $userid)->first();

        return $roldeid;
          
     }
}



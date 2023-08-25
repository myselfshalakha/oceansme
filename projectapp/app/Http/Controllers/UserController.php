<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\eventEvaluators;
use App\Models\UserEvents;
use App\Models\Country;
use App\Models\Posts;
use App\Models\UserBio;
use App\Models\EventTeam;
use App\Models\Department;
use Auth;
use Hash;
use App\Rules\PhoneNumber;
use App\Notifications\NewUserActivity;
use Mail;

class UserController extends Controller
{
      /*  public function __construct()

    {
        $this->middleware('auth');
        $this->middleware('role:super_admin');
    } */

	
    public function index()
    {
        return view('home');
    }
	
	public function roleuserAction(Request $request,$role_name, $action= null){
	
		switch ($role_name) {
			case 'event_admin':
				return $this->event_adminAction($role_name, $action, $request);          
				break;
			case 'hr_manager':
				return $this->hr_managerAction($role_name, $action, $request);          
				break;
			case 'interviewer':
				return $this->interviewerAction($role_name, $action, $request);          
				break;
			case 'evaluator':
			
			 return $this->evaluatorAction($role_name, $action, $request);          
				break;
			case 'candidate':
			
			 return $this->candidateAction($role_name, $action, $request);          
				break;
			default:
				  return redirect('/404');     
				
			break;
		}
	}
	
	public function interviewerAction($role_name, $action=null,$data){
		switch ($action) {
			case 'add':
			  return redirect('/404');       
			break;
			case 'save':
			 $this->validate($data,[
                     'firstname' => ['required', 'string', 'max:255'],
						'lastname' => ['nullable', 'string', 'max:255'],
						'gender' => ['required', 'string', 'max:255'],
						'contactno' => ['nullable', 'string', new PhoneNumber],
						'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
						'password' => ['required', 'string', 'min:8'],
                ]);
			$getroleid = DB::table('roles')->select('id')->where('name', $role_name)->first();
		/* 	$event_Team=DB::table('event_teams')->select('id')->where('role_id',$getroleid->id)->where('event_id',$data->event_id)->first();
			   if(!empty($event_Team)){
				  return redirect()->back()->with('error', 'Sorry Only 1 Hr Manager allowed for each event.')->with('activeTab','interviewer');
			  }  */
			  $response = $this->saveUser($data, $getroleid->id);
			  if($response){
				  return redirect()->back()->with('success', 'Interviewer added successfully.')->with('activeTab','interviewer'); 
			  }else{
				  return redirect()->back()->with('error', 'Something went wrong.')->with('activeTab','interviewer'); 
			  }
			break;
			case 'update':
			 $this->validate($data,[
                     'firstname' => ['required', 'string', 'max:255'],
						'lastname' => ['nullable', 'string', 'max:255'],
						'gender' => ['required', 'string', 'max:255'],
						'contactno' => ['nullable', 'string', new PhoneNumber],
                ]);
			  $response = $this->updateUser($data);
			  if($response){
				  return redirect()->back()->with('success', 'User updated successfully.')->with('activeTab','profile'); 
			  }else{
				  return redirect()->back()->with('error', 'Something went wrong.')->with('activeTab','profile'); 
			  }
			break;
			case 'changeprofileimage':
			
				$this->validate($data,[
				     'profileimage' => ['required', 'mimes:png,jpg,jpeg', 'max:2048'],
					]);
					 $image_name = time();
					$image_ext = strtolower($data->profileimage->getClientOriginalExtension()); 
					$image_full_name = $image_name.'.'.$image_ext;
					$upload_path = 'assets/images/userprofile/';    
					$image_url = $upload_path.$image_full_name;
					$success = $data->profileimage->move($upload_path,$image_full_name);
					$response = $this->changeprofileimage($data,$image_full_name);
					 return redirect()->back()->with('success', 'Profile Image change successfully.')->with('activeTab','profileImage'); 
			break; 
			case 'changepassword':
			$this->validate($data,[
						'password' => ['required', 'string', 'min:8'],
				]);
			$response = $this->changepassword($data);
            return redirect()->back()->with('success', 'Password change successfully.')->with('activeTab','password'); 
            break;  
			case 'edit':
			$user = User::find($_GET['id']);
			$role_user = $this->getRoleid($user->id);
			$event = DB::table('events')
						->join('event_teams', 'event_teams.event_id', '=', 'events.id')
						->select('event_teams.id as evteam_id','event_teams.company_id as company_id', 'events.id as ev_id')
						->where('event_teams.user_id','=',$user->id)
						->first();
			return view('hr_manager.edit', compact('user','role_user','event'));
			break;
			case 'delete':
			$response = $this->deleteUser($data->id);
			if($response === true){
				return response()->json(['success'=>true,'message'=>'Record deleted successfully.'],200);
			}else{
				return response()->json(['success'=>false,'message'=>$response],200);
			}
			break;
			default:
				 $users = DB::table('users')->select('users.*','role_user.role_id')->leftjoin('role_user', 'users.id', '=', 'role_user.user_id')->where('role_user.role_id', '=', 3)->paginate(20);
				return view('event_admin.list', compact('users'));       
			break;
		}
	}	
		public function hr_managerAction($role_name, $action=null,$data){
			
		switch ($action) {
			case 'add':
				  return redirect('/404');          
			break;
			case 'save':
			 $this->validate($data,[
                     'firstname' => ['required', 'string', 'max:255'],
						'lastname' => ['nullable', 'string', 'max:255'],
						'gender' => ['required', 'string', 'max:255'],
						'contactno' => ['nullable', 'string', new PhoneNumber],
						'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
						'password' => ['required', 'string', 'min:8'],
                ]);
			$getroleid = DB::table('roles')->select('id')->where('name', $role_name)->first();
			$event_Team=DB::table('event_teams')->select('id')->where('role_id',$getroleid->id)->where('event_id',$data->event_id)->first();
			  if(!empty($event_Team)){
				  return redirect()->back()->with('error', 'Sorry Only 1 Hr Manager allowed for each event.')->with('activeTab','hr_manager');
			  }
			  $response = $this->saveUser($data, $getroleid->id);
			  if($response){
				  return redirect()->back()->with('success', 'Hr Manager added successfully.')->with('activeTab','hr_manager'); 
			  }else{
				  return redirect()->back()->with('error', 'Something went wrong.')->with('activeTab','hr_manager'); 
			  }
			break;
			case 'update':
			 $this->validate($data,[
                     'firstname' => ['required', 'string', 'max:255'],
						'lastname' => ['nullable', 'string', 'max:255'],
						'gender' => ['required', 'string', 'max:255'],
						'contactno' => ['nullable', 'string', new PhoneNumber],
                ]);
			  $response = $this->updateUser($data);
			  if($response){
				  return redirect()->back()->with('success', 'User updated successfully.')->with('activeTab','profile'); 
			  }else{
				  return redirect()->back()->with('error', 'Something went wrong.')->with('activeTab','profile'); 
			  }
			break;
			case 'changeprofileimage':
			
				$this->validate($data,[
				     'profileimage' => ['required', 'mimes:png,jpg,jpeg', 'max:2048'],
					]);
					 $image_name = time();
					$image_ext = strtolower($data->profileimage->getClientOriginalExtension()); 
					$image_full_name = $image_name.'.'.$image_ext;
					$upload_path = 'assets/images/userprofile/';    
					$image_url = $upload_path.$image_full_name;
					$success = $data->profileimage->move($upload_path,$image_full_name);
					$response = $this->changeprofileimage($data,$image_full_name);
					 return redirect()->back()->with('success', 'Profile Image change successfully.')->with('activeTab','profileImage'); 
			break; 
			case 'changepassword':
			$this->validate($data,[
						'password' => ['required', 'string', 'min:8'],
				]);
			$response = $this->changepassword($data);
            return redirect()->back()->with('success', 'Password change successfully.')->with('activeTab','password'); 
            break;  
			case 'edit':
			$user = User::find($_GET['id']);
			$role_user = $this->getRoleid($user->id);
			$event = DB::table('events')
						->join('event_teams', 'event_teams.event_id', '=', 'events.id')
						->select('event_teams.id as evteam_id','event_teams.company_id as company_id', 'events.id as ev_id')
						->where('event_teams.user_id','=',$user->id)
						->first();
			return view('hr_manager.edit', compact('user','role_user','event'));
			break;
			case 'delete':
			$response = $this->deleteUser($data->id);
			if($response === true){
				return response()->json(['success'=>true,'message'=>'Record deleted successfully.'],200);
			}else{
				return response()->json(['success'=>false,'message'=>$response],200);
			}
			break;
			default:
			
				 $users = DB::table('users')->select('users.*','role_user.role_id')->leftjoin('role_user', 'users.id', '=', 'role_user.user_id')->where('role_user.role_id', '=', 5)->paginate(20);
				return view('hr_manager.list', compact('users'));       
			break;
		}
	}	
		
		public function event_adminAction($role_name, $action=null,$data){
		switch ($action) {
			case 'add':
				return view($role_name.'.add');          
				break;
			case 'save':
			 $this->validate($data,[
                     'firstname' => ['required', 'string', 'max:255'],
						'lastname' => ['nullable', 'string', 'max:255'],
						'gender' => ['required', 'string', 'max:255'],
						'contactno' => ['nullable', 'string', new PhoneNumber],
						'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
						'password' => ['required', 'string', 'min:8'],
                ]);
			$getroleid = DB::table('roles')->select('id')->where('name', $role_name)->first();
			  $response = $this->saveUser($data, $getroleid->id);
			  if($response){
				  return redirect()->back()->with('success', 'User added successfully.');
			  }else{
				  return redirect()->back()->with('error', 'Something went wrong.');
			  }
			break;
			case 'update':
			 $this->validate($data,[
                     'firstname' => ['required', 'string', 'max:255'],
						'lastname' => ['nullable', 'string', 'max:255'],
						'gender' => ['required', 'string', 'max:255'],
						'contactno' => ['nullable', 'string', new PhoneNumber],
                ]);
			  $response = $this->updateUser($data);
			  if($response){
				  return redirect()->back()->with('success', 'User updated successfully.')->with('activeTab','profile'); 
			  }else{
				  return redirect()->back()->with('error', 'Something went wrong.')->with('activeTab','profile'); 
			  }
			break;
			case 'changeprofileimage':
			
				$this->validate($data,[
				     'profileimage' => ['required', 'mimes:png,jpg,jpeg', 'max:2048'],
					]);
					 $image_name = time();
					$image_ext = strtolower($data->profileimage->getClientOriginalExtension()); 
					$image_full_name = $image_name.'.'.$image_ext;
					$upload_path = 'assets/images/userprofile/';    
					$image_url = $upload_path.$image_full_name;
					$success = $data->profileimage->move($upload_path,$image_full_name);
					$response = $this->changeprofileimage($data,$image_full_name);
					 return redirect()->back()->with('success', 'Profile Image change successfully.')->with('activeTab','profileImage'); 
			break; 
			case 'changepassword':
			$this->validate($data,[
						'password' => ['required', 'string', 'min:8'],
				]);
			$response = $this->changepassword($data);
            return redirect()->back()->with('success', 'Password change successfully.')->with('activeTab','password'); 
            break;  
			case 'edit':
			$user = User::find($_GET['id']);
			$role_user = $this->getRoleid($user->id);
			return view('event_admin.edit', compact('user','role_user'));
			break;
			case 'delete':
			$response = $this->deleteUser($data->id);
			if($response === true){
				return response()->json(['success'=>true,'message'=>'Record deleted successfully.'],200);
			}else{
				return response()->json(['success'=>false,'message'=>$response],200);
			}
			break;
			default:
				 $users = DB::table('users')->select('users.*','role_user.role_id')->leftjoin('role_user', 'users.id', '=', 'role_user.user_id')->where('role_user.role_id', '=', 3)->paginate(20);
				return view('event_admin.list', compact('users'));       
			break;
		}
	}	
	
	public function evaluatorAction($role_name, $action=null,$data){
		switch ($action) {
			case 'add':
			$departments = Department::all();
				return view($role_name.'.add', compact('departments'));   
				break;
			case 'save':
			 $this->validate($data,[
                     'firstname' => ['required', 'string', 'max:255'],
						'lastname' => ['nullable', 'string', 'max:255'],
						'gender' => ['required', 'string', 'max:255'],
						'contactno' => ['nullable', 'string', new PhoneNumber],
						'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
						'password' => ['required', 'string', 'min:8'],
                ]);
			$getroleid = DB::table('roles')->select('id')->where('name', $role_name)->first();
			  $response = $this->saveUser($data, $getroleid->id);
			   if($response){
				  return redirect()->back()->with('success', 'User added successfully.')->with('activeTab','profile'); 
			  }else{
				  return redirect()->back()->with('error', 'Something went wrong.')->with('activeTab','profile'); 
			  }
			break;
			case 'edit':
			$user = User::find($_GET['id']);
			$role_user = $this->getRoleid($user->id);
			$departments = Department::all();
			return view('evaluator.edit', compact('user','role_user','departments'));
			break;
			case 'changeprofileimage':
				$this->validate($data,[
				     'profileimage' => ['required', 'mimes:png,jpg,jpeg', 'max:2048'],
					]);
					 $image_name = time();
					$image_ext = strtolower($data->profileimage->getClientOriginalExtension()); 
					$image_full_name = $image_name.'.'.$image_ext;
					$upload_path = 'assets/images/userprofile/';    
					$image_url = $upload_path.$image_full_name;
					$success = $data->profileimage->move($upload_path,$image_full_name);
					$response = $this->changeprofileimage($data,$image_full_name);
					 return redirect()->back()->with('success', 'Profile Image change successfully.')->with('activeTab','profileImage'); 
			break; 
			case 'changepassword':
			$this->validate($data,[
						'password' => ['required', 'string', 'min:8'],
				]);
			$response = $this->changepassword($data);
            return redirect()->back()->with('success', 'Password change successfully.')->with('activeTab','password'); 
            break;  
			case 'update':
			 $this->validate($data,[
                     'firstname' => ['required', 'string', 'max:255'],
						'lastname' => ['nullable', 'string', 'max:255'],
						'gender' => ['required', 'string', 'max:255'],
						'contactno' => ['nullable', 'string', new PhoneNumber],
                ]);
			  $response = $this->updateUser($data);
			  if($response){
				  return redirect()->back()->with('success', 'User updated successfully.');
			  }else{
				  return redirect()->back()->with('error', 'Something went wrong.');
			  }
			break;
			case 'delete':
			eventEvaluators::where('user_id', $data->id)->delete();
			$response = $this->deleteUser($data->id);
			if($response === true){
				return response()->json(['success'=>true,'message'=>'Record deleted successfully.'],200);
			}else{
				return response()->json(['success'=>false,'message'=>$response],200);
			}
			break;
			default:
				 $users = DB::table('users')->select('users.*','role_user.role_id')->leftjoin('role_user', 'users.id', '=', 'role_user.user_id')->where('role_user.role_id', '=', 4)->get();
			return view('evaluator.list', compact('users'));                   
			break;
		}
	}
	
	public function candidateAction($role_name, $action=null,$data){
		switch ($action) {
			case 'add':
				return redirect('/404');      
			break;
			case 'changeprofileimage':
				$this->validate($data,[
				     'profileimage' => ['required', 'mimes:png,jpg,jpeg', 'max:2048'],
					]);
					 $image_name = time();
					$image_ext = strtolower($data->profileimage->getClientOriginalExtension()); 
					$image_full_name = $image_name.'.'.$image_ext;
					$upload_path = 'assets/images/userprofile/';    
					$image_url = $upload_path.$image_full_name;
					$success = $data->profileimage->move($upload_path,$image_full_name);
					$response = $this->changeprofileimage($data,$image_full_name);
					 return redirect()->back()->with('success', 'Profile Image change successfully.')->with('activeTab','profileImage'); 
			break; 
			case 'changepassword':
			$this->validate($data,[
						'password' => ['required', 'string', 'min:8'],
				]);
			$response = $this->changepassword($data);
            return redirect()->back()->with('success', 'Password change successfully.')->with('activeTab','password'); 
            break; 
			case 'update':
			 $this->validate($data,[
                     'firstname' => ['required', 'string', 'max:255'],
						'lastname' => ['nullable', 'string', 'max:255'],
						'gender' => ['required', 'string', 'max:255'],
						'contactno' => ['nullable', 'string', new PhoneNumber],
                ]);
			  $response = $this->updateUser($data);
			  if($response){
				  return redirect()->back()->with('success', 'User updated successfully.')->with('activeTab','profile'); 
			  }else{
				  return redirect()->back()->with('error', 'Something went wrong.')->with('activeTab','profile'); 
			  }
			break;
			case 'edit':
			$user = User::find($_GET['id']);
			$role_user = $this->getRoleid($user->id);
			return view('candidate.edit', compact('user','role_user'));
			break;
			case 'delete':
			UserEvents::where('user_id', $data->id)->delete();
			UserBio::where('user_id', $data->id)->delete();
			$response = $this->deleteUser($data->id);
			if($response === true){
				return response()->json(['success'=>true,'message'=>'Record deleted successfully.'],200);
			}else{
				return response()->json(['success'=>false,'message'=>$response],200);
			}
			break;
			default:
				 $users = DB::table('users')->select('users.*','role_user.role_id')->leftjoin('role_user', 'users.id', '=', 'role_user.user_id')->where('role_user.role_id', '=', 1)->paginate(20);
			return view('candidate.list', compact('users'));          
			break;
		}
	}
	
	public function userlistAction(Request $request,$param = null){

		switch ($param) {
    		case 'event_admin':
				 $users = DB::table('users')->select('users.*','role_user.role_id')->leftjoin('role_user', 'users.id', '=', 'role_user.user_id')->where('role_user.role_id', '=', 3)->paginate(20);
				// dd($users);
				return view('event_admin.list', compact('users'));          
                break;
			case 'evaluator':
			 $users = DB::table('users')->select('users.*','role_user.role_id')->leftjoin('role_user', 'users.id', '=', 'role_user.user_id')->where('role_user.role_id', '=', 4)->paginate(20);
			return view('evaluator.list', compact('users'));          
			break;
			case 'hr_manager':
			 $users = DB::table('users')->select('users.*','role_user.role_id')->leftjoin('role_user', 'users.id', '=', 'role_user.user_id')->where('role_user.role_id', '=', 5)->paginate(20);
			return view('hr_manager.list', compact('users'));          
			break;
			case 'interviewer':
			 $users = DB::table('users')->select('users.*','role_user.role_id')->leftjoin('role_user', 'users.id', '=', 'role_user.user_id')->where('role_user.role_id', '=', 6)->paginate(20);
			return view('interviewer.list', compact('users'));          
			break;
			case 'candidate':
			 $users = DB::table('users')->select('users.*','role_user.role_id')->leftjoin('role_user', 'users.id', '=', 'role_user.user_id')->where('role_user.role_id', '=', 1)->paginate(20);
			return view('candidate.list', compact('users'));          
			break;
    		default:
				 $users = DB::table('users')->select('users.*','role_user.role_id')->leftjoin('role_user', 'users.id', '=', 'role_user.user_id')->where('users.id', '!=', Auth::user()->id)->paginate(20);
				 $roles = Role::all();
                return view('users.list', compact('roles','users'));          
                break;
			break;
    	}
	}
	  private function deleteUser($id){
        
            EventTeam::where('user_id', $id)->delete();
            UserBio::where('user_id', $id)->delete();
            eventEvaluators::where('user_id', $id)->delete();
            UserBio::where('user_id', $id)->delete();
            RoleUser::where('user_id', $id)->delete();
			User::where('id', $id)->delete();
                return true;
    } 
	/* private function deleteUser($id){
        try{
            if(RoleUser::where('user_id', $id)->delete()&& User::where('id', $id)->delete()){
				
                return true;
            }else{
                return 'Something went wrong';
            }
        }
        catch(Exception $e) {
          return 'User cannot be deleted';
        }
    } */
	
	 public function saveUser($data, $roleid){

        $user = new User;
        $user->name = trim($data->firstname." ".$data->lastname);
        $user->firstname = trim($data->firstname);
        $user->lastname = trim($data->lastname);
        $user->gender = $data->gender;
        $user->contactno = $data->contactno;
        $user->whatsapp = $data->whatsapp;
        $user->email = $data->email;
        $user->password = Hash::make($data->password);
        $user->email_verified_at = date('Y-m-d H:i:s');
		if(isset($data->dep_id)&&!empty($data->dep_id)){
			$user->dep_id = serialize($data->dep_id);
		}
		//save new user
        if($user->save()){
			 RoleUser::create([
                'role_id' => $roleid,
                'user_id' => $user->id,
            ]);
			// if hr_manager or interviewer save
			if(isset($data->event_id)){
				 $evTeam = new EventTeam;
				$evTeam->event_id=$data->event_id;
				$evTeam->company_id=$data->company_id;
				$evTeam->user_id=$user->id;
				$evTeam->role_id=$roleid;
				$evTeam->save();
			}
			
			//send email alert for new user
			$details=$this->getMailDetailsofNewUSer($roleid);
			$details["password"]=$data->password;
			Notification::send($user,new NewUserActivity($details));
			 

            return true;
        }else{
            return false;
        }
    }
	 public function getMailDetailsofNewUSer($roleid){
		 switch ($roleid) {
    		case 1:
				$details["subject"]="OceansMe Candidate Regsitration";
				$details["welcomeMesage"]="Welcome to Oceansme. You are registered as a Candidate in our website.";	
				return $details;          
			break;
			case 2:
				$details["subject"]="OceansMe Super Admin Regsitration";
				$details["welcomeMesage"]="Welcome to Oceansme. You are registered as a Super Admin in our website.";	
				return $details;          
			break;
    		case 3:
				$details["subject"]="OceansMe Event Admin Regsitration";
				$details["welcomeMesage"]="Welcome to Oceansme. You are registered as an Event Admin in our website.";	
				return $details;          
			break;
    		case 4:
				$details["subject"]="OceansMe Evaluator Regsitration";
				$details["welcomeMesage"]="Welcome to Oceansme. You are registered as an Evaluator in our website.";	
				return $details;          
			break;
			case 5:
				$details["subject"]="OceansMe Hr Manager Regsitration";
				$details["welcomeMesage"]="Welcome to Oceansme. You are registered as an Hr Manager in our website.";	
				return $details;          
			break;
			case 6:
				$details["subject"]="OceansMe Invigilator Regsitration";
				$details["welcomeMesage"]="Welcome to Oceansme. You are registered as an Invigilator in our website.";	
				return $details;          
			break;
    		default:
				$details["subject"]="OceansMe Subscriber Regsitration";
				$details["welcomeMesage"]="Welcome to Oceansme. You are registered as an Subscriber in our website.";	
				return $details;      
			break;
    	}
		
    } 
	public function updateUser($data){

        $user = User::find($data->id);
        $user->name = trim($data->firstname." ".$data->lastname);
        $user->firstname = trim($data->firstname);
        $user->lastname = trim($data->lastname);
        $user->gender = $data->gender;
        $user->contactno = $data->contactno;
        $user->whatsapp = $data->whatsapp;
		if(isset($data->dep_id)&&!empty($data->dep_id)){
			$user->dep_id = serialize($data->dep_id);
		}
        if($user->save()){
            return true;
        }else{
            return false;
        }
    }
	
	public function profileAction(Request $request,$param = null){

		switch ($param) {
    		case 'edit':
				$user = User::find($_GET['id']);
				$role_user = $this->getRoleid($user->id);
                return view('profile.edit', compact('user','role_user'));
                break;
            case 'update':
			
                $this->validate($request,[
                     'firstname' => ['required', 'string', 'max:255'],
						'lastname' => ['nullable', 'string', 'max:255'],
						'gender' => ['required', 'string', 'max:255'],
						'contactno' => ['nullable', 'string', new PhoneNumber],
                ]);
                $response = $this->changeProfile($request);

                return redirect()->back()->with('success', 'Profile change successfully.')->with('activeTab','profile'); 
                break; 
			case 'bioupdate':
			// dd($request);
			 $this->validate($request,[
						'resume' => ['nullable', 'mimes:docx,doc,pdf', 'max:3072']
                ]);
					$file_full_name="";
					if(!empty($request->resume)){
						$file_name = time();
						$file_ext = strtolower($request->resume->getClientOriginalExtension()); 
						$file_full_name = $file_name.'.'.$file_ext;
						$upload_path = 'assets/files/user/resume/';    
						$file_url = $upload_path.$file_full_name;
						$successUpload = $request->resume->move($upload_path,$file_full_name);
					}
                $response = $this->changeBio($request,$file_full_name);

                return redirect()->back()->with('success', 'Bio change successfully.')->with('activeTab','bio'); 
                break;
			case 'changepassword':
				$this->validate($request,[
				'password' =>'required|string|min:8',
				]);
				$response = $this->changepassword($request);
                 return redirect()->back()->with('success', 'Password change successfully.')->with('activeTab','password'); 
                break; 
			case 'changeprofileimage':
				$this->validate($request,[
					'profileimage' => 'required|mimes:png,jpg,jpeg|max:2048'
					]);
					 $image_name = time();
					$image_ext = strtolower($request->profileimage->getClientOriginalExtension()); 
					$image_full_name = $image_name.'.'.$image_ext;
					$upload_path = 'assets/images/userprofile/';    
					$image_url = $upload_path.$image_full_name;
					$success = $request->profileimage->move($upload_path,$image_full_name);
					$response = $this->changeprofileimage($request,$image_full_name);
					 return redirect()->back()->with('success', 'Profile Image change successfully.')->with('activeTab','profileImage'); 
				break; 
    		default:
				$user = User::find(Auth::user()->id);
				$role_user = $this->getRoleid(Auth::user()->id);
				 $user_bios = DB::table('user_bios')->where('user_id', '=', Auth::user()->id)->get();
				 $countries = Country::all();
				 $posts = Posts::all();
				$profilestatus = $this->getPercentageProfile($user_bios);
					
                return view('profile.edit', compact('user','role_user','profilestatus','user_bios','countries','posts'));
			break;
    	}
	}
	public function getPercentageProfile($user_bios){
			$profilestatus=0;
			$biopercentage = 50;
			 $mainProfile_percentage = 5;
			 $emailverify_percentage = 5;
			 $profileImage_percentage = 20;
			 
			 $profilestatus = $profilestatus+ $mainProfile_percentage;
			 if(Auth::user()->hasVerifiedEmail()){
				  $profilestatus = $profilestatus+ $emailverify_percentage;
			 }
			 if(!empty(Auth::user()->profileimage)){
				 $profilestatus = $profilestatus+ $profileImage_percentage;
			 }
			 $totalReqinfo=13;
			 $eachpercentage=20/$totalReqinfo;
			 foreach($user_bios as $bios){
				if(!empty($bios->passport)){
					$profilestatus = $profilestatus+ $eachpercentage;
				 }	
				 if(!empty($bios->visaStatus)){
					$profilestatus = $profilestatus+ $eachpercentage;
				 }	
				 if(!empty($bios->languages)){
					$profilestatus = $profilestatus+ $eachpercentage;
				 }	 
				 if(!empty($bios->hobbies)){
					$profilestatus = $profilestatus+ $eachpercentage;
				 }	
				if(!empty($bios->skills)){
					$profilestatus = $profilestatus+ $eachpercentage;						 
				 }					 
				 if(!empty($bios->address)){
					$profilestatus = $profilestatus+ $eachpercentage;
				 }
				  if(!empty($bios->second_address)){
					$profilestatus = $profilestatus+ $eachpercentage;
				 }
				  if(!empty($bios->country)){
					$profilestatus = $profilestatus+ $eachpercentage;
				 }
				  if(!empty($bios->nationality)){
					$profilestatus = $profilestatus+ $eachpercentage;
				 }
				  if(!empty($bios->birthdate)){
					$profilestatus = $profilestatus+ $eachpercentage;
				 }
				 if(!empty($bios->position)){
					$profilestatus = $profilestatus+ $eachpercentage;
				 }
				  if(!empty($bios->exp_years)||!empty($bios->exp_months)){
					$profilestatus = $profilestatus+ $eachpercentage;
				 }
				  
				  if(!empty($bios->qualification)){
					$profilestatus = $profilestatus+ $eachpercentage;
				 }
				  if(!empty($bios->resume)){
					$profilestatus = $profilestatus+ $biopercentage;
				 }
			 }
			 return $profilestatus;
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
	public function changeBio($data,$resumename){
		$updateData=array();
		$updateData['languages']= (!empty($data->languages))?serialize($data->languages):"";
		$updateData['hobbies']= (!empty($data->hobbies))?serialize($data->hobbies):"";
		$updateData['skills']=(!empty($data->skills))?serialize($data->skills):"";
		$updateData['visaStatus']=$data->visaStatus;
		$updateData['passport']=$data->passport;
		$updateData['address']=$data->address;
		$updateData['second_address']=$data->second_address;
		$updateData['country']=$data->country;
		$updateData['nationality']=$data->nationality;
		$updateData['position']=$data->position;
		$updateData['exp_years']=$data->exp_years;
		$updateData['exp_months']=$data->exp_months;
		$updateData['qualification']=$data->qualification;
		if(!empty($data->birthdate)){
				$updateData['birthdate']=date('Y-m-d h:i:s',strtotime($data->birthdate));
		}
		if(!empty($resumename)){
			$updateData['resume']=$resumename;
		}
		
        if(UserBio::where('user_id', $data->id)->update($updateData)){
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

<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Notification;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use App\Models\User;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\Events;
use App\Models\UserBio;
use App\Models\UserEvents;
use App\Models\Posts;
use Auth;
use Hash;
use Illuminate\Support\Facades\Validator;
use App\Rules\PhoneNumber;
use Illuminate\Support\Facades\DB;
use Mail;
use App\Notifications\AttendingEventActivity;

class AccountsController extends Controller
{
	 public function __construct()
    {
        $this->middleware('guest');
    } 

	
    public function index($param = null)
    {
		$event = Events::find($param);
		if(empty($event)){
			return redirect('/404');
		}
		
		return view('auth.event_register', compact('event'));
    }
	
	public function candidateRegister(Request $request)
    {
		
		 $this->validate($request,[
                     'firstname' => ['required', 'string', 'max:255'],
						'lastname' => ['nullable', 'string', 'max:255'],
						'gender' => ['required', 'string', 'max:255'],
						'contactno' => ['nullable', 'string', new PhoneNumber],
						'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
						'password' => ['required', 'string', 'min:8'],
                ]);
				//Create Candidate
				$user = new User;
				$user->name = trim($request->firstname." ".$request->lastname);
				$user->firstname = trim($request->firstname);
				$user->lastname = trim($request->lastname);
				$user->gender = $request->gender;
				$user->contactno = $request->contactno;
				$user->whatsapp = $request->whatsapp;
				$user->email = $request->email;
				$user->password = Hash::make($request->password);
		   
				if($user->save()){
					//Set Candidate Role
					   RoleUser::create([
							'role_id' => 1,
							'user_id' => $user->id,
						]);  
						$userbio= new UserBio;
						$userbio->user_id=$user->id;
							$userbio->save();
							$eventdata = $request;	
							$eventdata->userid = $user->id;	
							$this->applyEvent($eventdata);
						event(new Registered($user));
						 Auth::login($user);
					return redirect('/admin/dashboard');
				//	return redirect('/admin/events/apply?id='.$request->eventid);
				}
    }
		public function applyEvent($data){
        $userevents =  new UserEvents;
		$userevents->post_apply = $data->post;
		$userevents->post_assigned = $data->post;
		$userevents->dep_id = Posts::find($data->post)->dep_id;
		$userevents->event_id = $data->eventid;
		$userevents->user_id = $data->userid;
		$userevents->interviewcode = generateRandomString(11)+time();
		/* $event_info=array();
		$dataInput = $data->all();
		foreach( $dataInput as $key=>$item){
			if($key!="_token" && $key!="id"){
				$event_info[$key]=$item;
			}
		}
		$userevents->event_info = serialize($event_info); */
		$userevents->status =1 ;
        if($userevents->save()){
           $event= Events::find($data->eventid);
			$details["subject"]="OceansMe Event Updates Notification";
			$details["welcomeMesage"]="A candidate has applied this event.";	
			$details["event"]=$event;
			$details["type"]="adminalert";
			$users_list=array();
			$users_list[]=$event->eventadmin_id; //event admin
			$evaluators= DB::table('event_evaluators')
				->join('users', 'event_evaluators.user_id', '=', 'users.id')
				->select('users.id as uid','users.dep_id', 'event_evaluators.*')
				->where('event_evaluators.event_id','=',$event->id)
				->get();
			foreach($evaluators as $eval){
				$evltr_dept=unserialize($eval->dep_id);
				if(is_array($evltr_dept)&&in_array($userevents->dep_id,$evltr_dept)){
				$users_list[]=$eval->user_id; //evaluator
				}
			}
			$users = User::whereIn('id', $users_list)->get();
			$response=Notification::send($users,new AttendingEventActivity($details));
            return true;
        }else{
            return false;
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\Company;
use App\Models\Country;
use App\Models\Events;
use App\Models\EventAttending;
use Auth;
use Hash;
use App\Rules\PhoneNumber;

class AdminController extends Controller
{
    public function index()
    {
		
	
		if(Auth::user()->hasRole('super_admin')){
			 $companies = Company::count();
			 $events = Events::count();
			$event_admins = DB::table('users')->leftjoin('role_user', 'users.id', '=', 'role_user.user_id')->where('role_user.role_id', '=', 3)->count();  
			$evaluators = DB::table('users')->leftjoin('role_user', 'users.id', '=', 'role_user.user_id')->where('role_user.role_id', '=', 4)->count();  
			return view('super_admin.home', compact('events','companies','event_admins','evaluators'));
        }else if(Auth::user()->hasRole('event_admin')){
			 $events = DB::table('events')->where('eventadmin_id', '=', Auth::user()->id)->count();
			 $eventList = DB::table('events')->where('eventadmin_id', '=', Auth::user()->id)->get();
			return view('event_admin.home', compact('events','eventList'));
		} else if(Auth::user()->hasRole('interviewer')){
			
			return view('interviewer.home');
		}else if(Auth::user()->hasRole('hr_manager')){
			 $event = DB::table('events')->select('events.*')->join('event_teams', 'event_teams.event_id', '=', 'events.id')->where('event_teams.user_id','=', Auth::user()->id)->whereIn('status', ["1","2","3"])->first();
			 $company = DB::table('companies')->select('companies.*')->join('event_teams', 'event_teams.company_id', '=', 'companies.id')->where('event_teams.user_id','=', Auth::user()->id)->first();
			$agencies = DB::table('agencies')->select('agencies.*')->where('event_id','=',$event->id)->get();
			$event_team = DB::table('event_teams')->select('users.id','users.name','users.email','event_teams.role_id')->join('users', 'event_teams.user_id', '=', 'users.id')->where('event_id','=',$event->id)->get();
	
			$applicants = DB::table('user_events')
				->join('users', 'user_events.user_id', '=', 'users.id')
				->join('user_bios', 'user_events.user_id', '=', 'user_bios.user_id')
				->join('event_attendings', 'user_events.id', '=', 'event_attendings.uevent_id' )
				->select('user_events.id as uev_id','user_events.*','event_attendings.status as att_status','event_attendings.id as uevatt_id', 'event_attendings.*', 'users.id as u_id', 'users.*', 'user_bios.id as ubio_id', 'user_bios.*')
				->where('user_events.event_id','=',$event->id)
				->get();
				$countries = Country::all();
			return view('hr_manager.home', compact('event_team','applicants','agencies','countries','company','event'));
		} else if(Auth::user()->hasRole('evaluator')){
			 $events = DB::table('event_evaluators')->where('user_id', '=', Auth::user()->id)->count();
			 $eventList = DB::table('event_evaluators')->select('events.*')->join('events', 'event_evaluators.event_id', '=', 'events.id')->where('user_id','=', Auth::user()->id)->get();
			return view('evaluator.home', compact('events','eventList'));
		}else if(Auth::user()->hasRole('candidate')){
			$event = DB::table('user_events')
					->join('events', 'user_events.event_id', '=', 'events.id')
					->select('user_events.id as uev_id','user_events.status as uev_status', 'events.*')
					->where('user_events.user_id','=',Auth::user()->id)
					->first();
            $eventAttendings=array();
			if(!empty($event)){
			$eventAttendings = EventAttending::where("uevent_id",$event->uev_id)->first();
			}
			 $eventList = DB::table('events')->whereIn('status',[1,2])->where('end_date','>=',date("Y-m-d"))->get(); 
			 $user_events = DB::table('user_events')->join('events', 'user_events.event_id', '=', 'events.id')->select('events.id')->where('user_events.user_id','=',Auth::user()->id)->get();
			 $user_bios = DB::table('user_bios')->where('user_id', '=', Auth::user()->id)->get();
			 $profilestatus = $this->getPercentageProfile($user_bios);
			 
			return view('candidate.home', compact('event','eventAttendings','eventList','profilestatus','user_events'));
		}
        return view('candidate.home');
			
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
}

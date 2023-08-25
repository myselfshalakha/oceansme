<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\State;
use App\Models\Country;
use App\Models\Posts;
use App\Models\Department;
use App\Models\User;
use App\Models\Company;
use App\Models\Events;
use App\Models\EventTeam;
use App\Models\eventEvaluators;
use App\Models\UserEvents;
use App\Models\EventAttending;
use App\Models\EventSchedule;
use App\Models\Agency;
use Auth;
use Hash;
use App\Rules\PhoneNumber;
use Mail;
use App\Notifications\AttendingEventActivity;
use App\Notifications\CandidateEventActivity;
use App\Notifications\EventActivity;
use App\Models\CompanySalarySystem;
use Shortcode;
use App\Jobs\SendSheetAgencyJob;


class EventController extends Controller
{
	/* Event Actions */
   public function eventsAction(Request $request,$param = null){
	   $thiAction="eventsAction";
	    
        switch ($param) {
            case 'save':
				    /* dd($request);  */

				$this->validateSaveEvent($request);  
					$image_full_name="";
					if(!empty($request->featured_image)){
						$image_name = time();
						$image_ext = strtolower($request->featured_image->getClientOriginalExtension()); 
						$image_full_name = $image_name.'.'.$image_ext;
						$upload_path = 'assets/images/events/';    
						$image_url = $upload_path.$image_full_name;
						$successUpload = $request->featured_image->move($upload_path,$image_full_name);
					}
                    $response = $this->saveEvent($request,$image_full_name);
					if($response){
						if(isset($request->id)){
							return redirect()->back()->with('success', get_after_action_response("eventsAction","save","updated"))->with('activeTab','details'); 
						}else{
							  
							return redirect()->back()->with('success', get_after_action_response("eventsAction","save","saved"))->with('activeTab','details'); 
						}
					}else{
						return redirect()->back()->with('error', get_after_action_response("commonMessage","errors","err_500"))->with('activeTab','details'); 
					}
                break;  
			case 'applyevent':
				$response = $this->applyEvent($request);

				 if($response){
						return redirect()->back()->with('success', 'Event Applied successfully.');
				}else{
					return redirect()->back()->with('error', get_after_action_response("commonMessage","errors","err_500"));
				} 
                   
             break;
			 case 'search_applicant':
			 
				if(!isset($_GET['id']) || empty($_GET['id'])){
                    return redirect('/404');
                }
				$showview="interviewer.events.search_applicant";
				if(Auth::user()->hasRole('interviewer')){
					$showview="interviewer.events.search_applicant";
				}else{
					  return redirect('/404');
				}
				$applicant = DB::table('user_events')
						->join('users', 'user_events.user_id', '=', 'users.id')
						->join('user_bios', 'user_events.user_id', '=', 'user_bios.user_id')
						->join('event_attendings', 'user_events.id', '=', 'event_attendings.uevent_id')
						->select('user_events.id as uev_id','user_events.status as uev_status','user_events.dep_id as uev_dep_id','user_events.*','event_attendings.id as uevatt_id','event_attendings.event_info as att_event_info','event_attendings.status as att_status', 'event_attendings.*', 'users.id as u_id', 'users.*', 'user_bios.id as ubio_id', 'user_bios.*')
						->where('user_events.id','=',$_GET['id'])
						->first();
				//dd($applicant);
				if(empty($applicant)){
					$showview="interviewer.events.search_no_applicant";
                    return view($showview);
                }
                $companies = Company::all();
				$event_admins = DB::table('users')->select('users.id','users.name')->leftjoin('role_user', 'users.id', '=', 'role_user.user_id')->where('role_user.role_id', '=', 3)->get();
				$evaluators = DB::table('users')->select('users.id','users.name')->leftjoin('role_user', 'users.id', '=', 'role_user.user_id')->where('role_user.role_id', '=', 4)->get();
                $event = Events::find($applicant->event_id);
				$posts=Posts::find($applicant->post_assigned);
				$department=Department::find($posts->dep_id); 
				$current_company=CompanySalarySystem::where("post_id",$applicant->post_assigned)->where("company_id",$event->company_id)->first();
				$applicant_salary =get_company_salaryBy_Id($current_company->id); 
                return view($showview, compact('event','companies','event_admins','evaluators','applicant','department','applicant_salary'));
                break;
				
			
			case 'saveCustomEventForm':
                    $response = $this->saveCustomEventForm($request);
					 if($response === true){
						return response()->json(['success'=>true,'message'=>'Event form changes successfully.'],200);
					}else{
						return response()->json(['success'=>false,'message'=>get_after_action_response("commonMessage","errors","err_500")],200);
					}
                break;
			case 'delete':
               
                $response = $this->deleteEvent($request->id);
                if($response === true){
                    return response()->json(['success'=>true,'message'=>get_after_action_response("commonMessage","delete","msg")],200);
                }else{
                    return response()->json(['success'=>false,'message'=>get_after_action_response("commonMessage","errors","err_500")],200);
                }
                break;
			case 'checkuserevent':
                $event = Events::find($request->id);
				$user_bios = DB::table('user_bios')->where('user_bios.user_id','=',Auth::user()->id)->get();
				$success=['success'=>true,'message'=>[]];
				$profilestatus = $this->getPercentageProfile($user_bios);
				if($profilestatus<100){
					$success['success']=false;
					$success['message'][]='You cannot apply this event. You profile is not completed 100%.';
				}
                $response = $this->checkuserEvent($request->id);
                if($response != true){
					$success['success']=false;
					$success['message'][]='You cannot apply this event. You have already applied on an event.';
				}
				
				/*
				if(!empty($event) && (!empty($event->minAge) || !empty($event->maxAge)))
				{
					 $response = $this->checkRestrictedAge($event->minAge,$event->maxAge,$user_bios);
					if($response != true){
							$success['success']=false;
						if(!empty($event->minAge) && !empty($event->maxAge)){
							$success['message'][]='Your Age should be in between '.$event->minAge.' - '.$event->maxAge.' years';
						}elseif(!empty($event->minAge)){
							$success['message'][]='Your Age should be minimum '.$event->minAge.' years';
						}elseif(!empty($event->maxAge)){
							$success['message'][]='Your Age should not be maximum '.$event->maxAge.' years';
						}
					}
				}
				if(!empty($event) && (!empty($event->minExp) || !empty($event->maxExp)))
				{
					 $response = $this->checkRestrictedExperience($event->minExp,$event->maxExp,$user_bios);
					if($response != true){
							$success['success']=false;
						if(!empty($event->minExp) && !empty($event->maxExp)){
					$success['message'][]='Experience should be in between '.$event->minExp.' - '.$event->maxExp.' years';
						}elseif(!empty($event->minExp)){
					$success['message'][]='Experience should be minimum '.$event->minExp.' years';

						}elseif(!empty($event->maxExp)){
					$success['message'][]='Experience should not be maximum '.$event->maxExp.' years';
						}
					}
				}
				 if(!empty($event) && !empty($event->restrictedCountries))
				{
					 $response = $this->checkRestrictedCountry(unserialize($event->restrictedCountries),$user_bios);
					if($response != true){
						$success['success']=false;
					$success['message'][]='Your Country is not applicable for this event.';
					}
				} 
				*/
                return response()->json($success,200);
                break;
			case 'change_attending_status':
                $response = $this->change_attending_statusAttending($request);
                if($response === true){
                    return response()->json(['success'=>true,'message'=>'Status changed successfully.'],200);
                }else{
                    return response()->json(['success'=>false,'message'=>get_after_action_response("commonMessage","errors","err_500")],200);
                }
                break;
			case 'change_status':
                $response = $this->change_statusEvent($request);
				 
				$event = DB::table('user_events')
						->join('events', 'user_events.event_id', '=', 'events.id')
						->select('user_events.id as uev_id','user_events.status as uev_status', 'user_events.*', 'events.status as ev_status', 'events.id as ev_id', 'events.*')
						->where('user_events.id','=',$request->id)
						->first(); 
				//	resume here	
                if($response === true){
					 $details["subject"]="OceansMe Event Updates Notification";
					$details["welcomeMesage"]="Your event status has changed.";	
					$details["welcomeContent"]=$request->content;	
					$details["event"]=$event;

					
					$user = User::find($event->user_id);
					Notification::send($user,new CandidateEventActivity($details)); 
                    return response()->json(['success'=>true,'message'=>'Status changed successfully.'],200);
                }else{
                    return response()->json(['success'=>false,'message'=>get_after_action_response("commonMessage","errors","err_500")],200);
                }
                break;
			case 'send_applicant_notify':
				if(!isset($request->uev_id)){
                    return response()->json(['success'=>false,'message'=>get_after_action_response("commonMessage","errors","err_500")],200);
				}
				foreach($request->uev_id as $uevid){
						$data = (object)array("id"=>$uevid,"status"=>$request->att_status); 
				 $event = DB::table('user_events')
						->join('events', 'user_events.event_id', '=', 'events.id')
						->join('event_attendings', 'user_events.id', '=', 'event_attendings.uevent_id')
						->select('user_events.id as uev_id','user_events.status as uev_status', 'user_events.*', 'events.status as ev_status', 'events.id as ev_id', 'events.*','event_attendings.status as att_status', 'event_attendings.*')
						->where('user_events.id','=',$uevid)
						->where('event_attendings.uevent_id','=',$uevid)
						->first();
				if(empty($event)){
                    return response()->json(['success'=>false,'message'=>get_after_action_response("commonMessage","errors","err_500")],200);
                }
				
				//$pdfContent = Shortcode::compile(\App\Models\Company::find($event->company_id)->loi);
				$user = User::find($event->user_id);
				$company=Company::find($event->company_id);
				$companySalarySystem = CompanySalarySystem::where('company_id', $event->company_id)->where('post_id', $event->post_assigned)->first();

				$pdfContent = get_company_loi_html($event,$company,$companySalarySystem,$user);

				$details["subject"]="OceansMe Event Updates Notification check attachment";
				$details["event"]=$event;
				$details["company"]=$company;
				$details["pdfContent"]=$pdfContent;
				$details["schedule"]=EventSchedule::where('id', $event->schedule)->first();
				$response=Notification::send($user,new AttendingEventActivity($details)); 
				}
                return response()->json(['success'=>true,'message'=>"LOI sent successfully"],200);
                break;
			case 'save__salary':
                $response = $this->save__salaryUserEvent($request);
                if($response === true){
                    return response()->json(['success'=>true,'message'=>'Status changed successfully.'],200);
                }else{
                    return response()->json(['success'=>false,'message'=>get_after_action_response("commonMessage","errors","err_500")],200);
                }
                break;
			case 'change_interviewer':
                $response = $this->change_interviewerApplicant($request);
                if($response === true){
                    return response()->json(['success'=>true,'message'=>'Interviewer changed successfully.'],200);
                }else{
                    return response()->json(['success'=>false,'message'=>get_after_action_response("commonMessage","errors","err_500")],200);
                }
                break;
			case 'get_applied_user':
					if(!isset($_GET['id'])&&!empty($_GET['id'])){
							return redirect('/404');
					}
                    return $this->exportCSV($_GET['id']);
                break;
			case 'send_csv_agency':
				$response= $this->sendCSVAgency($request->id);
				
                 if($response == 1){
					return response()->json(['success'=>true,'message'=>'Report Sent successfully.'],200);
                }elseif($response == 2){
                    return response()->json(['success'=>false,'message'=>'Agency has 0 selected Applicant successfully.'],200);
                }else{
                    return response()->json(['success'=>false,'message'=>get_after_action_response("commonMessage","errors","err_500")],200);
                }
                break;
			case 'request_to_recheck':
                $response = $this->request_to_recheck($request);
                
                
                if($response === true){
                    return response()->json(['success'=>true,'message'=>'Request Submitted successfully.'],200);
                }else{
                    return response()->json(['success'=>false,'message'=>get_after_action_response("commonMessage","errors","err_500")],200);
                }
                break;
			case 'getpost_and_evls':
				$departments=$request->departments;
				$postHtml="";
				$evlHtml="";
				$evaluators=DB::table('users')->select('users.*','role_user.role_id')->leftjoin('role_user', 'users.id', '=', 'role_user.user_id')->where('role_user.role_id', '=', 4)->get();

				$event_evaluators = (!isset($request->evaluators)) ? array() : $request->evaluators;
				ob_start();
				echo view('components.getevaluatorsOptions', compact('event_evaluators','departments','evaluators'));
				$evlHtml = ob_get_contents();
				ob_end_clean();
				
				$postname= (!isset($request->posts)) ? array() : $request->posts;

                $posts = Posts::whereIn('dep_id', $departments)->get();
                ob_start();
				echo view('components.getPostsOptions', compact('postname','posts'));
				$postHtml = ob_get_contents();
				ob_end_clean();
                return response()->json(['success'=>true,'post'=>$postHtml, 'evaluator'=>$evlHtml],200);
               
                break;
			case 'userResponse':
				if(!Auth::user()->hasRole('candidate')){
					  return redirect('/404');
				}
				if(!isset($_GET['uev_id']) || empty($_GET['uev_id'])||!isset($_GET['status']) || empty($_GET['status']) || !in_array($_GET['status'],get_user_response_status())){
                    return redirect('/404');
                }
					
				$applicantDetail = DB::table('user_events')
						->select('user_events.id as uev_id','user_events.*')
						->where('user_events.id','=',$_GET['uev_id'])
						->first();
				if(empty($applicantDetail)){
                    return redirect('/404');
                }
				
				$applicantStatusCheck = DB::table('user_events')
						->select('user_events.id as uev_id','user_events.*')
						->where('user_events.id','=',$_GET['uev_id'])
						->whereIn('user_events.status',get_user_response_status(3))
						->first();
				$urlRedirect='/admin/events/apply?id='.$applicantDetail->event_id;
				if(!empty($applicantStatusCheck)){
                  return redirect($urlRedirect)->with('info', 'You have already submitted your response.');
                }
				$data = (object)array("id"=>$_GET['uev_id'],"event_id"=>$applicantDetail->event_id,"status"=>$_GET['status']);	
                $response = $this->change_statusEvent($data);
				$event = Events::find($applicantDetail->event_id);
				
			 	if($_GET['status']==9){
					$details["subject"]="OceansMe Event Updates Notification";
					$details["welcomeMesage"]="A candidate is attending this event.";	
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
						if(is_array($evltr_dept)&&in_array($applicantDetail->dep_id,$evltr_dept)){
						$users_list[]=$eval->user_id; //evaluator
						}
					}
					$eventHr= DB::table('event_teams')
						->join('users', 'event_teams.user_id', '=', 'users.id')
						->select('users.id as uid', 'event_teams.*')
						->where('event_teams.role_id','=',5)
						->where('event_teams.event_id','=',$event->id)
						->get();
						
					foreach($eventHr as $uval){
						$users_list[]=$uval->uid; 
						
					}
					$users = User::whereIn('id', $users_list)->get();
					
					$response=Notification::send($users,new AttendingEventActivity($details));  
				}
				return redirect($urlRedirect)->with('success', 'Thanks for your response.');
               
                break;
			case 'attendResponse':
				if(!Auth::user()->hasRole('candidate')){
					  return redirect('/404');
				}
				if(!isset($_GET['uev_id']) || empty($_GET['uev_id'])||!isset($_GET['status']) || empty($_GET['status']) || !in_array($_GET['status'],get_user_attendresponse_status())){
                    return redirect('/404');
                }
					
				$applicantDetail = DB::table('user_events')
						->select('user_events.id as uev_id','user_events.*')
						->where('user_events.id','=',$_GET['uev_id'])
						->first();
				if(empty($applicantDetail)){
                    return redirect('/404');
                }
				
				$applicantStatusCheck = DB::table('event_attendings')
						->select('event_attendings.*')
						->where('event_attendings.uevent_id','=',$_GET['uev_id'])
						->where('event_attendings.status',3)
						->first();
						
				$urlRedirect='/admin/events/apply?id='.$applicantDetail->event_id;
				if(empty($applicantStatusCheck)){
                  return redirect($urlRedirect)->with('error', 'Unauthorized access!');
                }
				/* PENDING */
				 EventAttending::where('uevent_id',$_GET['uev_id'])->update(['status' => $_GET['status']]); 
				$event = Events::find($applicantDetail->event_id);
					$details["subject"]="OceansMe Event Updates Notification";
					$details["welcomeMesage"]="A candidate has accepted the LOI.";	
					if($_GET['status']==2){
						$details["welcomeMesage"]="A candidate has declined the LOI.";	
					}
					$details["event"]=$event;
					$details["visitUrl"]="/admin/dashboard";
					$users_list=array();
					$users_list[]=$event->eventadmin_id; //event admin
					$eventHr= DB::table('event_teams')
						->join('users', 'event_teams.user_id', '=', 'users.id')
						->select('users.id as uid', 'event_teams.*')
						->where('event_teams.event_id','=',$event->id)
						->where('event_teams.role_id','=',5)
						->get();
						
					foreach($eventHr as $uval){
						$users_list[]=$uval->uid; 
						
					}
					$users = User::whereIn('id', $users_list)->get();
					
					$response=Notification::send($users,new AttendingEventActivity($details));  
			
				$urlRedirect='/admin/events/my-events';
				return redirect($urlRedirect)->with('success', 'Thanks for your response.');
               
                break;
			case 'send_event_notify':
                $event = DB::table('user_events')
						->join('events', 'user_events.event_id', '=', 'events.id')
						->select('user_events.id as uev_id','user_events.status as uev_status', 'user_events.*', 'events.status as ev_status', 'events.id as ev_id', 'events.*')
						->where('user_events.id','=',$request->id)
						->first();
						//dd($event);
				if(empty($event)){
                    return response()->json(['success'=>false,'message'=>get_after_action_response("commonMessage","errors","err_500")],200);
                }
				if($event->uev_status=="7" && empty($event->schedule)){
					  return response()->json(['success'=>false,'message'=>'Please choose anyone schedule.'],200);
				}
				$details["subject"]="OceansMe Event Updates Notification";
				$details["welcomeMesage"]=$request->message;	
				$details["event"]=$event;
				$details["schedule"]=EventSchedule::where('id', $event->schedule)->first();

				
				$user = User::find($event->user_id);
				$response=Notification::send($user,new CandidateEventActivity($details));
				
                return response()->json(['success'=>true,'message'=>'Notification Send successfully.', 'details'=>$details],200);
               
                break;
			case 'add':
                $companies = Company::all();
                $countries = Country::all();
                $departments = Department::all();
                $posts = Posts::all();
				$event_admins = DB::table('users')->select('users.id','users.name')->leftjoin('role_user', 'users.id', '=', 'role_user.user_id')->where('role_user.role_id', '=', 3)->get();
				$evaluators = DB::table('users')->select('users.id','users.name')->leftjoin('role_user', 'users.id', '=', 'role_user.user_id')->where('role_user.role_id', '=', 4)->get();
              
                return view('super_admin.events.create', compact('departments','companies','countries','posts','event_admins','evaluators'));
                break;
			case 'edit':
				if(!isset($_GET['id']) || empty($_GET['id'])){
                    return redirect('/404');
                }
				$showview="super_admin.events.edit";
				if(Auth::user()->hasRole('super_admin')){
					$showview="super_admin.events.edit";
				}elseif(Auth::user()->hasRole('event_admin')){
					$showview="event_admin.events.edit";
				}elseif(Auth::user()->hasRole('hr_manager')){
					$showview="hr_manager.events.edit";
				}else{
					  return redirect('/404');
				}
				 $countries = Country::all();
			   $departments = Department::all();
				
                $schedules = EventSchedule::where('event_id',$_GET['id'])->get();
                $event = Events::find($_GET['id']);
				
				$depname=array();
				if(isset($event->dep_id)&&!empty($event->dep_id)){
					$depname= unserialize($event->dep_id);
				}
				
				$posts = array();
				if(!empty($depname)){
					 $posts = Posts::whereIn('dep_id',$depname)->get();
				}
				
				$event_evaluators = DB::table('event_evaluators')->select('users.id','users.name','users.dep_id')->join('users', 'event_evaluators.user_id', '=', 'users.id')->where('event_id','=',$_GET['id'])->get();
				$event_team = DB::table('event_teams')->select('users.id','users.name','users.email','event_teams.role_id')->join('users', 'event_teams.user_id', '=', 'users.id')->where('event_id','=',$_GET['id'])->get();
                if(empty($event)){
                    return redirect('/404');
                }
                 $companies = Company::all();
				$event_admins = DB::table('users')->select('users.id','users.name')->leftjoin('role_user', 'users.id', '=', 'role_user.user_id')->where('role_user.role_id', '=', 3)->get();
				$evaluators = DB::table('users')->select('users.id','users.name')->leftjoin('role_user', 'users.id', '=', 'role_user.user_id')->where('role_user.role_id', '=', 4)->get();
                return view($showview, compact('schedules','depname','departments','event','event_team','countries','posts','companies','event_admins','evaluators','event_evaluators'));
                break;
			case 'applicants':
				if(!isset($_GET['id']) || empty($_GET['id'])){
                    return redirect('/404');
                }
				$showview="super_admin.events.applicant";
				if(Auth::user()->hasRole('super_admin')){
					$showview="super_admin.events.applicant";
				}elseif(Auth::user()->hasRole('evaluator')){
					$showview="evaluator.events.applicant";
				}elseif(Auth::user()->hasRole('event_admin')){
					$showview="event_admin.events.applicant";
				}else{
					  return redirect('/404');
				}
			   $posts = Posts::all();
                $event = Events::find($_GET['id']);
                if(empty($event)){
                    return redirect('/404');
                }
                 $companies = Company::all();
				$event_admins = DB::table('users')->select('users.id','users.name')->leftjoin('role_user', 'users.id', '=', 'role_user.user_id')->where('role_user.role_id', '=', 3)->get();
				$evaluators = DB::table('users')->select('users.id','users.name')->leftjoin('role_user', 'users.id', '=', 'role_user.user_id')->where('role_user.role_id', '=', 4)->get();
				$eventStatusCountData = DB::table('user_events')->select('status', DB::raw('count(*) as total'))->where('user_events.event_id', '=', $_GET['id'])->groupBy('status')->get();
				 $schedules = EventSchedule::where('event_id',$_GET['id'])->get();
				/* $eventStatusCountData = UserEvents::select('status', \DB::raw("count(status) as total"))->groupBy('status')->get(); */
				$departments=DB::table('user_events')->select('dep_id')->where('user_events.event_id','=',$_GET['id'])->distinct()->get();
				if(isset($_GET['status'])){
					
					 $applicants = DB::table('user_events')
						->join('users', 'user_events.user_id', '=', 'users.id')
						->join('user_bios', 'users.id', '=', 'user_bios.user_id')
						->select('user_events.id as uev_id', 'user_events.*', 'users.id as u_id', 'users.name','users.email', 'user_bios.*')
						->where('user_events.event_id','=',$_GET['id']);
						
						if($_GET['status']==6){  // if selected user fetch
							$applicants->whereIn('user_events.status',[5,6,7,9]);
						}else{
							$applicants->where('user_events.status','=',$_GET['status']); // if user fetch by status only
						}
						
					if(Auth::user()->hasRole('evaluator')){
						$depids=unserialize(Auth::user()->dep_id);
						if(is_array($depids)){
							$applicants->whereIn('user_events.dep_id',$depids);
						}
					}
					$applicants=$applicants->get();
				}else{
					$applicants = DB::table('user_events')
						->join('users', 'user_events.user_id', '=', 'users.id')
						->join('user_bios', 'users.id', '=', 'user_bios.user_id')
						->select('user_events.id as uev_id', 'user_events.*', 'users.id as u_id', 'users.name','users.email', 'user_bios.*')
						->where('user_events.event_id','=',$_GET['id']);
						if(Auth::user()->hasRole('evaluator')){
							$depids=unserialize(Auth::user()->dep_id);
							if(is_array($depids)){
								$applicants->whereIn('user_events.dep_id',$depids);
							}
						}
					$applicants=$applicants->get();
				}
                return view($showview, compact('event','departments','schedules','posts','companies','event_admins','evaluators','applicants','eventStatusCountData'));
                break;
			case 'applicant-info':
				if(!isset($_GET['id']) || empty($_GET['id'])){
                    return redirect('/404');
                }
				$showview="super_admin.events.applicant-info";
				if(Auth::user()->hasRole('super_admin')){
					$showview="super_admin.events.applicant-info";
				}elseif(Auth::user()->hasRole('evaluator')){
					$showview="evaluator.events.applicant-info";
				}elseif(Auth::user()->hasRole('event_admin')){
					$showview="event_admin.events.applicant-info";
				}elseif(Auth::user()->hasRole('hr_manager')){
					$showview="hr_manager.events.applicant-info";
				}else{
					  return redirect('/404');
				}
				$posts=null;
				$department=null;
				$current_company=null;
				$applicant_salary =null;
				if(Auth::user()->hasRole('hr_manager')){
					$applicant = DB::table('user_events')
						->join('users', 'user_events.user_id', '=', 'users.id')
						->join('user_bios', 'user_events.user_id', '=', 'user_bios.user_id')
						->join('event_attendings', 'user_events.id', '=', 'event_attendings.uevent_id')
						->select('user_events.id as uev_id','user_events.status as uev_status','user_events.dep_id as uev_dep_id','user_events.*','event_attendings.id as uevatt_id','event_attendings.event_info as att_event_info','event_attendings.status as att_status', 'event_attendings.*', 'users.id as u_id', 'users.*', 'user_bios.id as ubio_id', 'user_bios.*')
						->where('user_events.id','=',$_GET['id'])
						->first();
					$event = Events::find($applicant->event_id);	
					$posts=Posts::find($applicant->post_assigned);
					$department=Department::find($posts->dep_id); 
					$current_company=CompanySalarySystem::where("post_id",$applicant->post_assigned)->where("company_id",$event->company_id)->first();
					$applicant_salary =get_company_salaryBy_Id($current_company->id); 
				}else{
					$applicant = DB::table('user_events')
						->join('users', 'user_events.user_id', '=', 'users.id')
						->join('user_bios', 'user_events.user_id', '=', 'user_bios.user_id')
						->join('event_attendings', 'user_events.id', '=', 'event_attendings.uevent_id')
						->select('user_events.id as uev_id','user_events.status as uev_status','user_events.dep_id as uev_dep_id','user_events.*','event_attendings.id as uevatt_id','event_attendings.event_info as att_event_info','event_attendings.status as att_status', 'event_attendings.*', 'users.id as u_id', 'users.*', 'user_bios.id as ubio_id', 'user_bios.*')
						->where('user_events.id','=',$_GET['id'])
						->first();
					if(empty($applicant)){
						$applicant = DB::table('user_events')
							->join('users', 'user_events.user_id', '=', 'users.id')
							->join('user_bios', 'user_events.user_id', '=', 'user_bios.user_id')
							->select('user_events.id as uev_id','user_events.status as uev_status','user_events.dep_id as uev_dep_id', 'user_events.*', 'users.id as u_id', 'users.*', 'user_bios.*')
							->where('user_events.id','=',$_GET['id'])
							->first();	
					}	
					
				}
				//dd($applicant);
				if(empty($applicant)){
                    return redirect('/404');
                }
                $companies = Company::all();
				$event_admins = DB::table('users')->select('users.id','users.name')->leftjoin('role_user', 'users.id', '=', 'role_user.user_id')->where('role_user.role_id', '=', 3)->get();
				$evaluators = DB::table('users')->select('users.id','users.name')->leftjoin('role_user', 'users.id', '=', 'role_user.user_id')->where('role_user.role_id', '=', 4)->get();
				$posts = Posts::all();
                $event = Events::find($applicant->event_id);
				
				$eventRestrictions=array();
				$user_bios = DB::table('user_bios')->where('user_bios.user_id','=',$applicant->user_id)->get();
				$profilestatus = $this->getPercentageProfile($user_bios);
				if($profilestatus<100){
					$eventRestrictions[]=['success'=>false,'message'=>'Profile has not competed 100%.'];
				}
				$response = $this->checkuserEvent($event->id);
                if($response != true){
					$eventRestrictions[]=['success'=>false,'message'=>'Already applied on an event.'];
				}
				if(!empty($event) && (!empty($event->minAge) || !empty($event->maxAge)))
					{
						 $response = $this->checkRestrictedAge($event->minAge,$event->maxAge,$user_bios);
						if($response != true){
								$success['success']=false;
							if(!empty($event->minAge) && !empty($event->maxAge)){
								$success['message']='Age should be in between '.$event->minAge.' - '.$event->maxAge.' years';
							}elseif(!empty($event->minAge)){
								$success['message']='Age should be minimum '.$event->minAge.' years';
							}elseif(!empty($event->maxAge)){
								$success['message']='Age should not be maximum '.$event->maxAge.' years';
							}
							$eventRestrictions[]=$success;
						}
					}
					if(!empty($event) && (!empty($event->minExp) || !empty($event->maxExp)))
					{
						 $response = $this->checkRestrictedExperience($event->minExp,$event->maxExp,$user_bios);
						if($response != true){
								$success['success']=false;
							if(!empty($event->minExp) && !empty($event->maxExp)){
						$success['message']='Experience should be in between '.$event->minExp.' - '.$event->maxExp.' years';
							}elseif(!empty($event->minExp)){
						$success['message']='Experience should be minimum '.$event->minExp.' years';

							}elseif(!empty($event->maxExp)){
						$success['message']='Experience should not be maximum '.$event->maxExp.' years';
							}
							$eventRestrictions[]=$success;
						}
					}
					 if(!empty($event) && !empty($event->restrictedCountries))
					{
						 $response = $this->checkRestrictedCountry(unserialize($event->restrictedCountries),$user_bios);
						if($response != true){
							$success['success']=false;
						$success['message']="Applicant's Country is not applicable for this event.";
						$eventRestrictions[]=$success;
						}
					} 
					
                return view($showview, compact('eventRestrictions','event','posts','companies','event_admins','evaluators','applicant','department','applicant_salary'));
                break;
			case 'apply': 
			if(!isset($_GET['id']) || empty($_GET['id'])){
                    return redirect('/404');
                }
			  
                $event = Events::find($_GET['id']);
                if(empty($event)){
                    return redirect('/404');
                }
				 $posts = Posts::all();
				//check restrictions
				$eventRestrictions=array();
				$user_bios = DB::table('user_bios')->where('user_bios.user_id','=',Auth::user()->id)->get();
				$profilestatus = $this->getPercentageProfile($user_bios);
				if($profilestatus<100){
					$eventRestrictions[]=['success'=>false,'message'=>'You cannot apply this event. You need to make sure that your profile completion percentage is 100%'];
				}
				$response = $this->checkuserEvent($_GET['id']);
                if($response != true){
					$eventRestrictions[]=['success'=>false,'message'=>'You cannot apply this event. You have already applied on an event.'];
				}
			
                 $companies = Company::all();
				$event_admins = DB::table('users')->select('users.id','users.name')->leftjoin('role_user', 'users.id', '=', 'role_user.user_id')->where('role_user.role_id', '=', 3)->get();
					$applicant = DB::table('user_events')
					->join('users', 'user_events.user_id', '=', 'users.id')
					->join('user_bios', 'user_events.user_id', '=', 'user_bios.user_id')
					->join('event_attendings', 'user_events.id', '=', 'event_attendings.uevent_id')
					->select('user_events.id as uev_id','user_events.status as uev_status','user_events.dep_id as uev_dep_id','user_events.*','event_attendings.id as uevatt_id','event_attendings.event_info as att_event_info','event_attendings.status as att_status', 'event_attendings.*', 'users.id as u_id', 'users.*', 'user_bios.id as ubio_id', 'user_bios.*')
					->where('user_events.event_id','=',$_GET['id'])
					->where('user_events.user_id','=',Auth::user()->id)
					->first();
					
				if(empty($applicant)){
					$applicant = DB::table('user_events')
						->join('users', 'user_events.user_id', '=', 'users.id')
						->join('user_bios', 'user_events.user_id', '=', 'user_bios.user_id')
						->select('user_events.id as uev_id','user_events.dep_id as uev_dep_id', 'user_events.*', 'users.id as u_id', 'users.*', 'user_bios.*')
						->where('user_events.event_id','=',$_GET['id'])
						->where('user_events.user_id','=',Auth::user()->id)
						->first();	
				}
				$user_events = DB::table('user_events')->select('user_events.*')->where('user_events.event_id', '=', $_GET['id'])->where('user_events.user_id','=',Auth::user()->id)->get();
				$evaluators = DB::table('users')->select('users.id','users.name')->leftjoin('role_user', 'users.id', '=', 'role_user.user_id')->where('role_user.role_id', '=', 4)->get();
                return view('candidate.events.apply', compact('eventRestrictions','event','posts','companies','event_admins','evaluators','user_events','applicant'));
                break;	
			case 'custom_form':
				$event = Events::find($_GET['id']);
				if(empty($event)){
					return redirect('/404');
				}
				$showview="components.common.events.custom_form";
				if(!Auth::user()->hasRole('super_admin')&&!Auth::user()->hasRole('event_admin')){
						return redirect('/404');
				}
                return view($showview, compact('event'));
                break;	
			case 'interview_questions':
				if(!isset($_GET['id'])){
					return redirect('/404');
				}
				$event = Events::find($_GET['id']);
				if(empty($event)){
					return redirect('/404');
				}
				$showview="components.common.events.interview_questions";
				if(!Auth::user()->hasRole('super_admin')&&!Auth::user()->hasRole('event_admin')){
						return redirect('/404');
				}
				return view($showview, compact('event'));
				break;				
			case 'my-events':
				$event = DB::table('user_events')
					->join('events', 'user_events.event_id', '=', 'events.id')
					->select('user_events.id as uev_id','user_events.status as uev_status', 'events.*')
					->where('user_events.user_id','=',Auth::user()->id)
					->first();
                if(empty($event)){
                   return view('candidate.events.my-events', compact('event'));
                }
				 $posts = Posts::all();
				//check restrictions
				$eventRestrictions=array();
				$user_bios = DB::table('user_bios')->where('user_bios.user_id','=',Auth::user()->id)->get();
				$profilestatus = $this->getPercentageProfile($user_bios);
                 $companies = Company::all();
				$event_admins = DB::table('users')->select('users.id','users.name')->leftjoin('role_user', 'users.id', '=', 'role_user.user_id')->where('role_user.role_id', '=', 3)->get();
				
				$applicant = DB::table('user_events')
					->join('users', 'user_events.user_id', '=', 'users.id')
					->join('user_bios', 'user_events.user_id', '=', 'user_bios.user_id')
					->join('event_attendings', 'user_events.id', '=', 'event_attendings.uevent_id')
					->select('user_events.id as uev_id','user_events.status as uev_status','user_events.dep_id as uev_dep_id','user_events.*','event_attendings.id as uevatt_id','event_attendings.event_info as att_event_info','event_attendings.status as att_status', 'event_attendings.*', 'users.id as u_id', 'users.*', 'user_bios.id as ubio_id', 'user_bios.*')
					->where('user_events.event_id','=',$event->id)
					->where('user_events.user_id','=',Auth::user()->id)
					->first();
					
				if(empty($applicant)){
					$applicant = DB::table('user_events')
						->join('users', 'user_events.user_id', '=', 'users.id')
						->join('user_bios', 'user_events.user_id', '=', 'user_bios.user_id')
						->select('user_events.id as uev_id','user_events.dep_id as uev_dep_id','user_events.status as uev_status', 'user_events.*', 'users.id as u_id', 'users.*', 'user_bios.*')
						->where('user_events.event_id','=',$event->id)
						->where('user_events.user_id','=',Auth::user()->id)
						->first();	
				}
				
				$user_events = DB::table('user_events')->select('user_events.*')->where('user_events.event_id', '=', $event->id)->where('user_events.user_id','=',Auth::user()->id)->get();
				$evaluators = DB::table('users')->select('users.id','users.name')->leftjoin('role_user', 'users.id', '=', 'role_user.user_id')->where('role_user.role_id', '=', 4)->get();
				$eventAttendings=array();
			if(!empty($event)){
			$eventAttendings = EventAttending::where("uevent_id",$event->uev_id)->first();
			}
                return view('candidate.events.my-events', compact('eventAttendings','applicant','profilestatus','event','posts','companies','event_admins','evaluators','user_events'));
                break;
			case 'save_interview_questions':
			
				$response = $this->saveInterviewQuestions($request);
				if($response){
						return redirect()->back()->with('success', 'Question Saved successfully.')->with('activeTab','interview_questions'); 
				}else{
					return redirect()->back()->with('error', get_after_action_response("commonMessage","errors","err_500"))->with('activeTab','interview_questions'); 
				} 
			break;
			case 'saveApplicantSalary':
			
				$response = $this->saveApplicantSalary($request);
				
				
				$event = Events::find($request->event_id);
				 $userEvents = UserEvents::find($request->uev_id);
				 
				// notify event admin and hr
				$details["subject"]="OceansMe Event Updates Notification";
					if($request->status==3){
						$details["welcomeMesage"]="A candidate has selected.";	
					}else{
						$details["welcomeMesage"]="A candidate has rejected.";	
					}
					$details["event"]=$event;
					$details["visitUrl"]="/admin/dashboard";
					$users_list=array();
					$users_list[]=$event->eventadmin_id; //event admin
					$eventHr= DB::table('event_teams')
						->join('users', 'event_teams.user_id', '=', 'users.id')
						->select('users.id as uid', 'event_teams.*')
						->where('event_teams.event_id','=',$event->id)
						->where('event_teams.role_id','=',5)
						->get();
						
					foreach($eventHr as $uval){
						$users_list[]=$uval->uid; 
						
					}
					$users = User::whereIn('id', $users_list)->get();
					
					Notification::send($users,new AttendingEventActivity($details));  
				
				
				// notify candidate
				$details=array();
					 $details["subject"]="OceansMe Event Updates Notification";
					$details["welcomeMesage"]="Your event status has changed.";	
					$details["event"]=$event;

					
					$user = User::find($userEvents->user_id);
					Notification::send($user,new CandidateEventActivity($details)); 			
				
				if($response){
						return redirect()->back()->with('success', 'Question Saved successfully.')->with('activeTab','interview_questions'); 
				}else{
					return redirect()->back()->with('error', get_after_action_response("commonMessage","errors","err_500"))->with('activeTab','interview_questions'); 
				} 
			break;
			case 'salary_details_applicant':
			if(!isset($request->id) || !isset($request->postid) ){
				return redirect('/404');
			}
                 $data = CompanySalarySystem::where('company_id', $request->id)->where('post_id', $request->postid)->first();
				$salary=make_table_with_salary_info($data);
				if(isset($data->dep_id)){
				$department=\App\Models\Department::find($data->dep_id);
				$questions=getDepartmentQuestionsHtmlShuffle($department);
				}else{
					$questions="n/a";
				}
				return response()->json(['success'=>true,'message'=>'Result Fetched successfully.', 'questions'=>$questions, 'salary'=>$salary],200);

             break;
			 case 'page_locked':
				$id = $request->id;
				$page = UserEvents::find($id);
				$date1 = date("Y-m-d h:i:s");
				$date2 = date("Y-m-d h:i:s",strtotime($page->lock_date));
				$lock_date = date("Y-m-d h:i:s", strtotime('+10 seconds', strtotime($date1)));

				$page->lock_date = $lock_date;
				$page->edited_by = Auth::user()->id;
				$page->save();

				return response()->json(['success'=>true,'message'=>'Page locked successfully.'],200);
                break;	
			case 'list':
			if(!Auth::user()->hasRole('super_admin')){
					  return redirect('/404');
				}
                return view('super_admin.events.list', [
                    'events' => (isset($_GET['search']))?DB::table('events')->where('name','like','%'.$_GET['search'].'%')->get()->withQueryString() :DB::table('events')->get()
                ]);
                break;				
			default:
				if(!Auth::user()->hasRole('super_admin')){
					  return redirect('/404');
				}
                 return view('super_admin.events.list', [
                    'events' => (isset($_GET['search']))?DB::table('events')->where('name','like','%'.$_GET['search'].'%')->get()->withQueryString() :DB::table('events')->get()
                ]);
                break;
        }
    }
	
	   public function exportCSV($eventId)
	{
		$user_response_status=get_user_response_status();
			$fileName = 'applicant.csv';
		 $event = Events::find($eventId);
		 $applicants = DB::table('user_events')
				->join('users', 'user_events.user_id', '=', 'users.id')
				->join('user_bios', 'user_events.user_id', '=', 'user_bios.user_id')
				->join('event_attendings', 'user_events.id', '=', 'event_attendings.uevent_id' )
				->select('user_events.id as uev_id','user_events.status as uev_status','user_events.dep_id as uev_dep_id','user_events.*','event_attendings.id as uevatt_id','event_attendings.event_info as att_event_info','event_attendings.status as att_status', 'event_attendings.*', 'users.id as u_id', 'users.*', 'user_bios.id as ubio_id', 'user_bios.*')
				->where('user_events.event_id','=',$eventId)
				->where('event_attendings.status','!=',1)
				->get();
			$headers = array(
				"Content-type"        => "text/csv",
				"Content-Disposition" => "attachment; filename=$fileName",
				"Pragma"              => "no-cache",
				"Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
				"Expires"             => "0"
			);
			$questions=array();
			foreach(unserialize($event->interview_questions) as $question){
				$questions[]=$question['question'];
			}
			$columns = array('RegNo','Name', 'Email', 'Country', 'Nationality', 'Current Position','Position Applying','Position Assigned','Experience','Schedule','Basic Wage','Other Contractual','Guaranteed Wage','Service Charge','Additional Bonus','Bonus Level','Bonus Personam','Total Salary','Incentive Type','Contract Length','Vacation Month','Interview Status');
				$columns=	array_merge($columns,$questions);				

			$callback = function() use($applicants, $columns) {
				$file = fopen('php://output', 'w');
				fputcsv($file, $columns);

				foreach ($applicants as $applicant) {
					$row['RegNo']  = $applicant->uev_id;
					$row['Name']  = $applicant->name;
					$row['Email']    = $applicant->email;
					$row['Country']    = \App\Models\Country::find($applicant->country)->name;
					$row['Nationality']    = \App\Models\Country::find($applicant->nationality)->name;
					$row['Current Position']    = $applicant->position;
					$row['Position Applying']    = \App\Models\Department::find($applicant->uev_dep_id)->name." - ".\App\Models\Posts::find($applicant->post_apply)->name;
					$row['Position Assigned']    = \App\Models\Department::find($applicant->uev_dep_id)->name." - ".\App\Models\Posts::find($applicant->post_assigned)->name;
					$row['Experience']    = getExperienceText($applicant->exp_years,$applicant->exp_months);
					$schedule= \App\Models\EventSchedule::find($applicant->schedule);
					$row['Schedule'] = "n/a";
					if(!empty($schedule)){
					$row['Schedule'] =	date("d-m-Y h:i a" , strtotime($schedule->schedule)).", ".$schedule->location;
					}
					$row["status"]="";
					
					
					   if($applicant->att_status=="3"){
						  
							$row["status"]="Selected";
						 
					   }else if($applicant->att_status=="2"){
					  
						 $row["status"]="Declined";
						 }else if($applicant->att_status=="4"){
					  
							$row["status"]="Attending";
						 }
					  
					
					$applicant_salary =get_company_salaryBy_Id($applicant->salary_final); 
					$row["Basic Wage"]=$applicant_salary->basic_wage;
					$row["Other Contractual"]=$applicant_salary->other_contractual;
					$row["Guaranteed Wage"]=$applicant_salary->guaranteed_wage;
					$row["Service Charge"]=$applicant_salary->service_charge;
					$row["Additional Bonus"]=$applicant_salary->additional_bonus;
					$row["Bonus Level"]=$applicant_salary->bonus_level;
					$row["Bonus Personam"]=$applicant_salary->bonus_personam;
					$row["Total Salary"]=$applicant_salary->total_salary;
					$row["Incentive Type"]=$applicant_salary->incentive_type;
					$row["Contract Length"]=$applicant_salary->contract_length;
					$row["Vacation Month"]=$applicant_salary->vacation_month;
					$answers=array();
					foreach(unserialize($applicant->att_event_info) as $question){
						$answers[]=$question['answer'];
					}
					$detailsArr=array($row['RegNo'],$row['Name'],$row['Email'],$row['Country'],$row['Nationality'],$row['Current Position'],$row['Position Assigned'],$row['Position Applying'],$row['Experience'], $row['Schedule'],$row["Basic Wage"],$row["Other Contractual"],$row["Guaranteed Wage"],$row["Service Charge"],$row["Additional Bonus"],$row["Bonus Level"],$row["Bonus Personam"],$row["Total Salary"],$row["Incentive Type"],$row["Contract Length"],$row["Vacation Month"],$row["status"]);
					$detailsArr=array_merge($detailsArr,$answers);		
					fputcsv($file,$detailsArr );
				}
				fclose($file);
			};

			return response()->stream($callback, 200, $headers);
	
	} 
	public function sendCSVAgency($agencyID)
	{
		$agency = Agency::where('id', $agencyID)->first();
		$event = DB::table('events')->select('events.*')->join('event_teams', 'event_teams.event_id', '=', 'events.id')->where('event_teams.user_id','=', Auth::user()->id)->whereIn('status', ["1","2","3"])->first();
		$country_idArr=array();
		if(!empty($agency->country_id)){
			$country_idArr= unserialize($agency->country_id);
		}
		$applicants = getAgenciesUsers(true,$country_idArr, $event->id,true); 
		
		if($applicants==0){
			return 2;
		}
		$applicants = getAgenciesUsers(false,$country_idArr, $event->id); // get selected applicant by country id of agencies
		//dd($applicants);
		
		$csvFile = fopen('php://temp', 'w');
		$questions=array();
		foreach(unserialize($event->interview_questions) as $question){
			$questions[]=$question['question'];
		}
			$csvcolumns = array('RegNo','Name', 'Email', 'Country', 'Nationality', 'Current Position','Position Applying','Position Assigned','Experience','Schedule','Basic Wage','Other Contractual','Guaranteed Wage','Service Charge','Additional Bonus','Bonus Level','Bonus Personam','Total Salary','Incentive Type','Contract Length','Vacation Month','Interview Status');
				$csvcolumns=	array_merge($csvcolumns,$questions);	
				// Write the CSV header
				fputcsv($csvFile, $csvcolumns);

				// Write user data to the CSV file
				foreach ($applicants as $applicant) {
					$row['RegNo']  = $applicant->uev_id;
					$row['Name']  = $applicant->name;
					$row['Email']    = $applicant->email;
					$row['Country']    = \App\Models\Country::find($applicant->country)->name;
					$row['Nationality']    = \App\Models\Country::find($applicant->nationality)->name;
					$row['Current Position']    = $applicant->position;
					$row['Position Applying']    = \App\Models\Department::find($applicant->uev_dep_id)->name." - ".\App\Models\Posts::find($applicant->post_apply)->name;
					$row['Position Assigned']    = \App\Models\Department::find($applicant->uev_dep_id)->name." - ".\App\Models\Posts::find($applicant->post_assigned)->name;
					$row['Experience']    = getExperienceText($applicant->exp_years,$applicant->exp_months);
					$schedule= \App\Models\EventSchedule::find($applicant->schedule);
					$row['Schedule'] = "n/a";
					if(!empty($schedule)){
					$row['Schedule'] =	date("d-m-Y h:i a" , strtotime($schedule->schedule)).", ".$schedule->location;
					}
					$row["status"]="";
					
					
					   if($applicant->att_status=="3"){
						  
							$row["status"]="Selected";
						 
					   }else if($applicant->att_status=="2"){
					  
						 $row["status"]="Declined";
						 }else if($applicant->att_status=="4"){
					  
							$row["status"]="Attending";
						 }
					  
					
					$applicant_salary =get_company_salaryBy_Id($applicant->salary_final); 
					$row["Basic Wage"]=$applicant_salary->basic_wage;
					$row["Other Contractual"]=$applicant_salary->other_contractual;
					$row["Guaranteed Wage"]=$applicant_salary->guaranteed_wage;
					$row["Service Charge"]=$applicant_salary->service_charge;
					$row["Additional Bonus"]=$applicant_salary->additional_bonus;
					$row["Bonus Level"]=$applicant_salary->bonus_level;
					$row["Bonus Personam"]=$applicant_salary->bonus_personam;
					$row["Total Salary"]=$applicant_salary->total_salary;
					$row["Incentive Type"]=$applicant_salary->incentive_type;
					$row["Contract Length"]=$applicant_salary->contract_length;
					$row["Vacation Month"]=$applicant_salary->vacation_month;
					$answers=array();
					if(!empty($applicant->att_event_info)){
						foreach(unserialize($applicant->att_event_info) as $question){
							$answers[]=$question['answer'];
						}
					}
					$detailsArr=array($row['RegNo'],$row['Name'],$row['Email'],$row['Country'],$row['Nationality'],$row['Current Position'],$row['Position Assigned'],$row['Position Applying'],$row['Experience'], $row['Schedule'],$row["Basic Wage"],$row["Other Contractual"],$row["Guaranteed Wage"],$row["Service Charge"],$row["Additional Bonus"],$row["Bonus Level"],$row["Bonus Personam"],$row["Total Salary"],$row["Incentive Type"],$row["Contract Length"],$row["Vacation Month"],$row["status"]);
					$detailsArr=array_merge($detailsArr,$answers);		
					fputcsv($csvFile,$detailsArr );
				}

				rewind($csvFile);
				$csvData = stream_get_contents($csvFile);

				// Close the CSV file
				fclose($csvFile);
				
				$details =[];
				$details['email'] = $agency->email;
				$details['event'] = $event;
				$details['agency'] = $agency;
                $details['csvData'] = $csvData;
				
				SendSheetAgencyJob::dispatch($details);
				return 1;
	
	}
   public function eventsScheduleAction(Request $request,$param = null){
		  switch ($param) {
            case 'save':
			
				$this->validateSaveSchedule($request);  
					
                    $response = $this->saveSchedule($request);
					if($response){
						if(isset($request->id)){
							return redirect()->back()->with('success', 'Event updated successfully.')->with('activeTab','schedule'); 
						}else{
							  
							return redirect()->back()->with('success', 'Event created successfully.')->with('activeTab','schedule'); 
						}
					}else{
						return redirect()->back()->with('error', get_after_action_response("commonMessage","errors","err_500"))->with('activeTab','schedule'); 
					} 
                break; 
			case 'delete':
               
                $response = $this->deleteSchedule($request->id);
                if($response === true){
                    return response()->json(['success'=>true,'message'=>get_after_action_response("commonMessage","delete","msg")],200);
                }else{
                    return response()->json(['success'=>false,'message'=>get_after_action_response("commonMessage","errors","err_500")],200);
                }
                break;
			case 'change_schedule':
					foreach($request->id as $uevid){
						$data = (object)array("id"=>$uevid,"schedule"=>$request->schedule);
							$response = $this->changeSchedule($data);
							if($response === true){
								 $event = DB::table('user_events')
									->join('events', 'user_events.event_id', '=', 'events.id')
									->select('user_events.id as uev_id','user_events.status as uev_status', 'user_events.*', 'events.status as ev_status', 'events.id as ev_id', 'events.*')
									->where('user_events.id','=',$uevid)
									->first();
									//dd($event);
									if(empty($event)){
										//return response()->json(['success'=>false,'message'=>get_after_action_response("commonMessage","errors","err_500")],200);
									}
									if($event->uev_status=="7" && empty($event->schedule)){
										  //return response()->json(['success'=>false,'message'=>'Please choose anyone schedule.'],200);
									}
									$details["subject"]="OceansMe Event Updates Notification";
									$details["welcomeMesage"]="Please check this schedule and location for your interview";	
									$details["event"]=$event;
									$details["schedule"]=EventSchedule::where('id', $event->schedule)->first();

									$user = User::find($event->user_id);
									Notification::send($user,new CandidateEventActivity($details));
							}
					}
				     	return response()->json(['success'=>true,'message'=>'Schedule sent successfully.'],200);

              
                break;
			case 'edit':
				if(!isset($_GET['id']) || empty($_GET['id'])){
                    return redirect('/404');
                }
				$showview="components.common.events.schedule.edit";
				if(!Auth::user()->hasRole('event_admin') && !Auth::user()->hasRole('super_admin')){
					  return redirect('/404');
				}
                $schedule = EventSchedule::find($_GET['id']);
                if(empty($schedule)){
                    return redirect('/404');
                }
				$event = Events::find($schedule->event_id);
                return view($showview, compact('schedule','event'));
                break;				
			default:
                   return redirect('/404');
                break;
        }
   }
 public function getMailDetailsofNewEvent($roleid){
		 switch ($roleid) {
    		case 3:
				$details["subject"]="OceansMe New Event Notification";
				$details["welcomeMesage"]="A New event is Registered. The event information is given below:";	
				return $details;          
			break;
    		default:
				$details["subject"]="OceansMe New Event Notification";
				$details["welcomeMesage"]="Welcome to Oceansme. You are registered as an Subscriber in our website.";	
				return $details;      
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
			 $user = User::find($user_bios[0]->user_id);

			 if ($user->hasVerifiedEmail()) {
				  $profilestatus = $profilestatus+ $emailverify_percentage;
			 }
			 if(!empty($user->profileimage)){
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
	public function validateSaveEvent($data){
		if(Auth::user()->hasRole('super_admin')){
			 $this->validate($data,[
							'name' => ['string', 'max:255'],
							'eventadmin' => ['required'],
							'minExp' => ['nullable','numeric'],
							'maxExp' => ['nullable','numeric'],
							'minAge' => ['nullable','numeric'],
							'maxAge' => ['nullable','numeric'],
							'start_date' => ['required', 'max:255'],
							'end_date' => ['required', 'max:255'],
							'featured_image' => ['nullable', 'mimes:png,jpg,jpeg', 'max:1024'],
			 ]);
		}elseif(Auth::user()->hasRole('event_admin')){
			 $this->validate($data,[
							'name' => ['string', 'max:255'],
							'minExp' => ['nullable','numeric'],
							'maxExp' => ['nullable','numeric'],
							'minAge' => ['nullable','numeric'],
							'maxAge' => ['nullable','numeric'],
							'featured_image' => ['nullable', 'mimes:png,jpg,jpeg', 'max:1024'],
			 ]);
		}
		return;
	}
	public function validateSaveSchedule($data){
		if(Auth::user()->hasRole('super_admin')){
			 $this->validate($data,[
				'schedule' => ['nullable', 'string', 'max:255'],
				'location' => ['required', 'string']
			 ]);
		}elseif(Auth::user()->hasRole('event_admin')){
			 $this->validate($data,[
				'schedule' => ['nullable', 'string', 'max:255'],
				'location' => ['required', 'string']
			 ]);
		}
		return;
	}
	   public function saveEvent($data,$featured_image){
        $event = (!isset($data->id)) ? new Events : Events::find($data->id);
		$event->company_id = $data->company ;
		if(Auth::user()->hasRole('super_admin')){
			$event->eventadmin_id = $data->eventadmin;
		}
		$event->name =$data->name ;
		$event->minAge =$data->minAge ;
		$event->maxAge =$data->maxAge ;
		$event->minExp =$data->minExp ;
		$event->maxExp =$data->maxExp ;
		if(Auth::user()->hasRole('super_admin')){
		$event->start_date =date('Y-m-d H:i:s',strtotime($data->start_date));
		$event->end_date =date('Y-m-d H:i:s',strtotime($data->end_date));
		}
		$event->dep_id = (!empty($data->departments))?serialize($data->departments):null;
		$event->post_id = (!empty($data->post))?serialize($data->post):null;
		
		if(!empty($data->restrictedCountries)){
			$event->restrictedCountries = serialize($data->restrictedCountries);
		}
		if(!empty($featured_image)){
			$event->featured_image =  $featured_image;
		}
		$event->description = $data->description ;
		$event->status = $data->status ;
		
        if($event->save()){
				$details["subject"]="OceansMe New Event Notification";
				$details["welcomeMesage"]="A New event is Registered. The event information is given below:";	
				$details["event"]=$event;
				if(!isset($data->id)){
					$user = User::find($data->eventadmin);
					Notification::send($user,new EventActivity($details));
					if(!empty($data->evaluator))
					{
						$users = User::whereIn('id', $data->evaluator)->get();
						Notification::send($users,new EventActivity($details));
					}
				}elseif(isset($data->id)){
					$evaluatorsCount=eventEvaluators::where('event_id', $event->id)->count();
					if($evaluatorsCount==0 && !empty($data->evaluator)){
						$users = User::whereIn('id', $data->evaluator)->get();
						Notification::send($users,new EventActivity($details));
					}
				}
				eventEvaluators::where('event_id', $event->id)->delete();
			if(!empty($data->evaluator)){
				//$event_evaluators = DB::table('event_evaluators')->select('id','user_id','event_id')->where('event_id','=',$event->id)->get();
				$newevaluator=[];
				foreach($data->evaluator as $value){
					$newevaluator[] = array('user_id'=>$value, 'event_id'=> $event->id);
				}
				eventEvaluators::insert($newevaluator);
				
			}
            return true;
        }else{
            return false;
        }
    }	  
	  public function saveSchedule($data){
        $schedule = (!isset($data->id)) ? new EventSchedule : EventSchedule::find($data->id);
		$schedule->event_id = $data->event_id ;
		$schedule->location =$data->location ;
		$schedule->location_link =$data->location_link ;
		$dateschedule= $data->schedule." ".$data->schedule_time;
		$schedule->schedule = date('Y-m-d H:i:s',strtotime($dateschedule));
        if($schedule->save()){
            return true;
        }else{
            return false;
        }
    }	  
	
	public function applyEvent($data){
        $userevents =  new UserEvents;
		$userevents->post_apply = $data->post;
		$userevents->post_assigned = $data->post;
		$userevents->dep_id = Posts::find($data->post)->dep_id;
		$userevents->salary_required = $data->salary_required;
		$userevents->event_id = $data->id;
		$userevents->user_id = Auth::user()->id ;
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
			$event= Events::find($data->id);
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
			
			foreach($evaluators as $uval){
				$evltr_dept=unserialize($uval->dep_id);
				if(is_array($evltr_dept)&&in_array($userevents->dep_id,$evltr_dept)){
				$users_list[]=$uval->user_id; //evaluator
				}
			}
			$users = User::whereIn('id', $users_list)->get();
			$response=Notification::send($users,new AttendingEventActivity($details));
            return true;
        }else{
            return false;
        }
    }	
	   
	public function saveInterviewQuestions($data){
        $eventform = Events::find($data->id);
		if(isset($data->interview_questions)&&!empty($data->interview_questions)){
			$questionArr=array();
			$i=0;
			foreach($data->interview_questions as $item){
				$record=array();
				$record['question']=$item;
				$questionArr[]=$record;
				$i++;
			}
			$eventform->interview_questions = serialize($questionArr);
			if($eventform->save()){
				
				return true;
			}else{
				return false;
			}
		}
		return true;
      
    }
	public function saveApplicantSalary($data){
		$response=true;
        $event = Events::find($data->event_id);
        $interview_questions = $event->interview_questions;
		$i=0;
		$answers=array();
		$dataInput = $data->all();
		$questionArr=array();
		foreach(unserialize($interview_questions) as $question){
			$record=array();
			$record['question']=$question["question"];
			$keyanswer="answer_".$i;
			foreach( $dataInput as $key=>$item){
				if($key==$keyanswer){
					$record['answer']=$item;
				}
			}
			if(!isset($record['answer'])){
				$record['answer']="";
			}
			$questionArr[]=$record;
			
			$i++;
		}
        $eventAttending = EventAttending::find($data->uevatt_id);
		$eventAttending->status = $data->status;
		$eventAttending->event_info = (!empty($questionArr))?serialize($questionArr):"";
		if(!$eventAttending->save()){
			return false;
		}
		
	 $companySalarySystem = CompanySalarySystem::where('company_id', $event->company_id)->where('post_id', $data->post_assigned)->first();
	  $userEvents = UserEvents::find($data->uev_id);
		$userEvents->post_assigned = $data->post_assigned;
		$userEvents->salary_final = isset($companySalarySystem->id)?$companySalarySystem->id:0;
		if(!$userEvents->save()){
			return false;
		}
		
		return $response;
      
    }
	public function saveCustomEventForm($data){
        $eventform = Events::find($data->id);
		$eventform->form_elements = serialize(json_decode(($data->frmcontent)));
		if($eventform->save()){
			
            return true;
        }else{
            return false;
        }
      
    }
    private function deleteEvent($id){
        EventSchedule::where('event_id', $id)->delete();
        EventAttending::where('event_id', $id)->delete();
        EventTeam::where('event_id', $id)->delete();
        UserEvents::where('event_id', $id)->delete();
        eventEvaluators::where('event_id', $id)->delete();
        if(Events::where('id', $id)->delete()){
            return true;
        }else{
            return false;
        }
    }
	 private function deleteSchedule($id){
        if(EventSchedule::where('id', $id)->delete()){
            return true;
        }else{
            return false;
        }
    } 
	private function changeSchedule($data){
        $userEvents = UserEvents::find($data->id);
		  if($userEvents->status==9){
			$userEvents->schedule = $data->schedule ;
			if($userEvents->save()){
				return true;
			}else{
				return false;
			}
		 }else{
			  return false; 
		 }
    }
	 private function checkuserEvent($eventId){
		
       $eventList = DB::table('user_events')
						->select("user_events.id")
						->where('user_events.user_id','=',Auth::user()->id)
						->where('user_events.event_id','!=',$eventId)
						->whereNotIn('user_events.status', [3])
						->get();
						
        if(count($eventList)==0){
            return true;
			
        }else{
            return false;
        }
    }  
	private function checkRestrictedCountry($countryId,$user_bios){
					
        if(count($user_bios)!=0 && in_array($user_bios[0]->country,$countryId) ){
            return false;
			
        }else{
            return true;
        }
    } 
	private function checkRestrictedExperience($minexp,$maxexp,$user_bios){
			$userExperience=$user_bios[0]->exp_years;	
			if(!empty($user_bios[0]->exp_months)){
				$userExperience=$userExperience+($user_bios[0]->exp_months/12);	
			}
			if(!empty($minexp) && !empty($maxexp)){
				if($userExperience>=$minexp && $userExperience<=$maxexp){
					
				return true;
				}else{
					
				return false;
				}
			}elseif(!empty($minexp) && $userExperience>=$minexp){
				return true;
				
				
			}elseif(!empty($maxexp)  && $userExperience<=$maxexp){
				return true;
				
				
			}else{
				return false;
			}
    } 

	private function checkRestrictedAge($minage,$maxage,$user_bios){
			$userAge=date('Y') - date('Y',strtotime($user_bios[0]->birthdate));
			
			if(!empty($minage) && !empty($maxage)){
				if($userAge>=$minage && $userAge<=$maxage){
					
				return true;
				}else{
					
				return false;
				}
			}elseif(!empty($minage) && $userAge>=$minage){
				return true;
				
				
			}elseif(!empty($maxage)  && $userAge<=$maxage){
				return true;
				
				
			}else{
				return false;
			}
    } 
	
	
	 private function save__salaryUserEvent($data){
		$userevents = UserEvents::find($data->id);
		$userevents->salary_final =$data->salary ;
        if($userevents->save()){
            return true;
        }else{
            return false;
        }
    }
	 private function change_statusEvent($data){
		$userevents = UserEvents::find($data->id);
		if(empty($userevents)){
			 return false;
		}
		$userevents->status =($data->status=="6")?"7":$data->status;
        if($userevents->save()){
			EventAttending::where('uevent_id', $data->id)->delete();
			if($data->status=="9"){
				$eventAttending = new EventAttending;
				$eventAttending->status = "1" ;
				$eventAttending->uevent_id = $data->id ;
				$eventAttending->event_id = $data->event_id ;
				$eventAttending->save();
			}			
            return true;
        }else{
            return false;
        }
    }
	private function change_attending_statusAttending($data){
		$eventAttending = EventAttending::find($data->id);
		if(empty($eventAttending)){
			 return false;
		}
		$eventAttending->status = $data->status ;
        if($eventAttending->save()){
            return true;
        }else{
            return false;
        }
    }	
	private function change_interviewerApplicant($data){
		$eventAttending = EventAttending::find($data->id);
		if(empty($eventAttending)){
			 return false;
		}
		$eventAttending->interviewer_id =$data->interviewer ;
        if($eventAttending->save()){
            return true;
        }else{
            return false;
        }
    }
	 private function request_to_recheck($data){
		$userevents = UserEvents::find($data->id);
		
		$userevents->request= $data->requestStatus;
        if($userevents->save()){
            return true;
        }else{
            return false;
        }
    }
	
	
}

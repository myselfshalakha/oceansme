<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

use Carbon\Carbon;
use App\Models\Events;
use App\Models\UserBio;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Notifications\CandidateProfileAlert;
use Mail;

class ApiOmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function eventAction(Request $request,$param = null)
    {
         switch ($param) {
            case 'update_event_status':
			$events=DB::table('events')->where('status','=','1')->where('start_date','<=',date("Y-m-d"))->where('end_date','>=',date("Y-m-d"))->get();
			 foreach($events as $data){
				$event = Events::find($data->id);
				$event->status = 2 ;
				$event->save();
			 }
			 $events=DB::table('events')->whereIn('status',['1','2'])->where('end_date','<',date("Y-m-d"))->get();
			 foreach($events as $data){
				$event = Events::find($data->id);
				$event->status = 3 ;
				$event->save();
			 }
			 return [
            "status" => 1,
            "message" => "Event Status Updated"
        ];
			default:
			return [
				"status" => 1,
				"message" => "This api is working fine"
			];
			break;
        }
    }
 public function candidateAction(Request $request,$param = null)
    {
         switch ($param) {
            case 'check_profile_complete':
			 $date = Carbon::now()->subDays(30);
			
			
			//$users = User::where('created_at', '<', $date)->get();
			//profile_complete_notify
			$users = User::whereHas(
				'roles', function($q){
					$q->where('name', 'candidate');
				}
			)->where("profile_complete_notify","=",null)
			->orWhere("profile_complete_notify", '<', $date)
			->get();
			foreach($users as $user){
				$user_bios = UserBio::where('user_id',$user->id)->get();
				 $profilestatus=$this->checkPercentageProfile($user_bios,$user);
				 if($profilestatus<100){
					$details["subject"]="OceansMe Profile Complete Alert";
					$details["welcomeMesage"]="Your Profile is incomplete. Please visit the website and complete your profile.";
					Notification::send($user,new CandidateProfileAlert($details)); 
					$user->profile_complete_notify = date('Y-m-d H:i:s');
					$user->save();
				 }
			 }
			 return [
            "status" => 1,
            "message" => "Profile complete has checked successfully."
        ];
			default:
			return [
				"status" => 1,
				"message" => "This api is working fine."
			];
			break;
        }
    }



public function checkPercentageProfile($user_bios,$user){
			$profilestatus=0;
			$biopercentage = 50;
			 $mainProfile_percentage = 5;
			 $emailverify_percentage = 5;
			 $profileImage_percentage = 20;
			 
			 $profilestatus = $profilestatus+ $mainProfile_percentage;
			 if($user->hasVerifiedEmail()){
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
 
}


//email_verified_at
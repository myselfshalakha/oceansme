<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Department;
use App\Models\Posts;
use App\Models\Company;
use App\Models\EventAttending;
use App\Models\CompanySalarySystem;
use Illuminate\Support\Facades\File;



if (!function_exists('generateGoogleMapURL'))
{
  function generateGoogleMapURL($location) {
    $url = 'https://www.google.com/maps/search/?api=1';
    $url .= '&query=' . urlencode($location);

    return $url;
}
}

if (!function_exists('setactive_custom'))
{
    function setactive_custom(string $path, string $class_name = "active", string $class_name2 = "")
    {
        return Request::path().str_replace(Request::url(), '', Request::fullUrl()) === $path ? $class_name : $class_name2;
    }
}

if (!function_exists('get_eval_dept'))
{
    function get_eval_dept($deptids = [])
    {
		
        return Department::whereIn("id",$deptids)->get();
    }
}

if (!function_exists('getEvalauatorName'))
{
    function getEvalauatorName($eventID)
    {
		$event_evaluators = DB::table('event_evaluators')->select('users.id','users.name')->join('users', 'event_evaluators.user_id', '=', 'users.id')->where('event_id','=',$eventID)->get();
		$evaluatorsName="";
		foreach($event_evaluators as $item){
				$evaluatorsName.=$item->name.", ";
		}
		$evaluatorsName=rtrim($evaluatorsName,", ");
        return !empty($evaluatorsName)?$evaluatorsName:"-";
    }
}

if (!function_exists('get_event_status'))
{
    function get_event_status()
    {
		$status=array("1"=>"Upcoming", "5"=>"Staging","2"=>"Live", "3"=>"Expired", "4"=>"Cancelled");
        return $status;
    }
}

if (!function_exists('get_visa_Status'))
{
    function get_visa_Status()
    {
		$status=array("1"=>"Employment", "2"=>"Family", "3"=>"Visa / Tourist", "4"=>"Not Applicable");
        return $status;
    }
}

if (!function_exists('get_user_status'))
{
    function get_user_status($dropDown=false)
    {
		$status=array("1"=>"New", "2"=>"Incomplete", "3"=>"Rejected", "4"=>"Duplicate", "5"=>"Declined", "6"=>"Selected", "7"=>"No Response", "8"=>"Hold", "9"=>"Attending", "10"=>"Walkin");
		if($dropDown==true){
			$status=array("1"=>"New", "2"=>"Incomplete", "3"=>"Rejected", "4"=>"Duplicate", "6"=>"Selected", "8"=>"Hold");
		}
        return $status;
    }
}

if (!function_exists('get_user_attending_status'))
{
    function get_user_attending_status($dropDown=false)
    {
		$status=array("1"=>"New",  "2"=>"Declined", "3"=>"Selected",  "4"=>"Attending",  "5"=>"Rejected", "7"=>"No Response", "8"=>"Pending", "9"=>"Skip");
		if($dropDown==true){
			$status=array("1"=>"New", "3"=>"Selected",  "5"=>"Rejected", "8"=>"Pending", "9"=>"Skip");
		}
        return $status;
    }
}



if (!function_exists('upload_assets_dynamic'))
{
    function upload_assets_dynamic($data,$upload_path)
    {
		$the_file_name="";
		if(!empty($data)){
			$file_unq_name = time();
			$file_ext = strtolower($data->getClientOriginalExtension()); 
			$the_file_name = $file_unq_name.'.'.$file_ext;
			$successUpload = $data->move($upload_path,$the_file_name);
		}
        return $the_file_name;
    }
}


if (!function_exists('get_after_action_response'))
{
    function get_after_action_response($action,$param,$msgtype=null)
    {
		$message="";
		$filepath = base_path()."/../assets/messages/response.json"; 
		$messages = json_decode(file_get_contents($filepath), true);
		 if(isset($messages['messages'][$action][$param][$msgtype])){
			return $messages['messages'][$action][$param][$msgtype];
		}
        return "something went wrong."; 
		
    }
}

if (!function_exists('get_user_response_status'))
{
    function get_user_response_status($step=1)
    {
		$status=array("5", "7", "9");
		if($step==2){
			$status=array("2", "4", "7");
		}elseif($step==3){
			$status=array("5", "9");
		}
        return $status;
    }
}

if (!function_exists('getHiddenUserEventStatus'))
{
    function getHiddenUserEventStatus()
    {
		$status=["5","7","9","10"];
        return $status;
    }
}



if (!function_exists('getNonEventInput'))
{
    function getNonEventInput()
    {
		$data=array("hidden","button","submit");
        return $data;
    }
}

if (!function_exists('getExperienceText'))
{
    function getExperienceText($years,$months)
    {
		$experience="";
		if(!empty($years)){
			$experience.=$years." yrs ";
		}
		if(!empty($months)){
			$experience.=$months." months ";
		}
		if(empty($experience)){
			$experience="-";
		}
        return $experience;
    }
}

if (!function_exists('hello__world'))
{
    function hello__world()
    {
        return "hello__world";
    }
}

if (!function_exists('generateRandomString'))
{
    function generateRandomString($requiredstring=7)
    {
        //$letters = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $letters = '1234567890987654321';
        $randomString = '';
        for ($i = 0;$i < $requiredstring;$i++)
        {
            $randomString .= $letters[rand(0, strlen($letters) - 1) ];
        }
        return $randomString;
    }
}


if (!function_exists('get_user_attendresponse_status'))
{
    function get_user_attendresponse_status($step=null)
    {
        $status=array("4", "2");
		
        return $status;
    }
}


if (!function_exists('get_event_status_badge'))
{
    function get_event_status_badge($evstatus=null)
    {
		$content="";
		$allstatus=get_event_status();
		ob_start();
		
		if($evstatus=="1" || $evstatus=="5"){?>
			<span class="card-description badge badge-primary"><?php echo $allstatus[$evstatus] ?></span>
		<?php }elseif($evstatus=="2"){ ?> 
			<span class="card-description badge badge-success"><?php echo $allstatus[$evstatus] ?></span>
		<?php }elseif($evstatus=="3"){ ?>  
			<span class="card-description badge badge-danger"><?php echo $allstatus[$evstatus] ?></span>
		<?php }elseif($evstatus=="4"){ ?> 
			<span class="card-description badge badge-danger"><?php echo $allstatus[$evstatus] ?></span>
		<?php }
		$content = ob_get_contents();
		ob_end_clean();
		
        return $content;
    }
}


if (!function_exists('get_applicant_status_badge'))
{
    function get_applicant_status_badge($ap_status=null,$user_response_status=array())
    {
		$content="";
		$allstatus=get_user_status();
		ob_start();
		 if($ap_status=="6" || in_array($ap_status,$user_response_status)){ ?>
		  <span class="badge badge-info"><?php echo $allstatus['6'] ?></span>
		 <?php }
		 if($ap_status!='6'){  ?>
		  <span class="badge badge-info"><?php echo $allstatus[$ap_status]  ?></span>
		<?php } 
		$content = ob_get_contents();
		ob_end_clean();
		
        return $content;
    }
}


if (!function_exists('get_applicantCountbyStatus'))
{
    function get_applicantCountbyStatus($status=0,$eventId=0)
    {
		if($status!=6){
			return 0;
		}
        return DB::table('user_events')->where('user_events.event_id', '=', $eventId)->whereIn('user_events.status', [5,6,7,9])->count();
    }
}

if (!function_exists('get_company_infoby_Id'))
{
    function get_company_infoby_Id($id=0)
    {
        return Company::find($id);
    }
}

if (!function_exists('get_company_salaryBy_Id'))
{
    function get_company_salaryBy_Id($id=0)
    {
        return CompanySalarySystem::find($id);
    }
}
if (!function_exists('get_hr_By_eventId'))
{
	
    function get_hr_By_eventId($id=0)
    {
        return DB::table('event_teams')->select('users.id','users.name','users.email','event_teams.role_id')->join('users', 'event_teams.user_id', '=', 'users.id')->where('event_id','=',$id)->where('event_teams.role_id','=',5)->first();
    }
}


if (!function_exists('make_table_with_salary_info'))
{
    function make_table_with_salary_info($item=null)
    {
		if($item!=null){
			$content="";
			ob_start();
		if($item->company_id==26){
						?>				
						
                                    <div class="table-responsive">
                                       <table class="table table-striped company_salary_list">
                                          <thead>
                                             <tr>
                                                <th>Department</th>
                                                <th>Job Title</th>
                                                <th>Position Code</th>
                                                <th>Contract Length LOI</th>
                                                <th>Total Salary</th>
                                                <th>Min Eng</th>
                                                <th>Contract Length</th>
                                                <th>Vacation Month</th>
                                                <th>Start-up</th>
                                                <th>First Reliever</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                           
                                             <tr>
                                                <td><?php echo \App\Models\Department::find($item->dep_id)->name ?></td>
												<?php $postInfo=\App\Models\Posts::find($item->post_id);  ?>
                                                <td><?php echo $postInfo->name ?></td>
                                                <td><?php echo $postInfo->rank ?></td>
                                               
                                                <td><?php echo $item->contract_length_loi ?></td>
                                                <td><?php echo convertPriceToNumber($item->total_salary) ?></td>
                                                <td><?php echo $item->min_eng ?></td>
                                                <td><?php echo $item->contract_length ?></td>
                                                <td><?php echo $item->vacation_month ?></td>
                                                <td><?php echo $item->start_up	 ?></td>
                                                <td><?php echo $item->first_reliever ?></td>
                                               
                                             </tr>
                                            
                                          </tbody>
                                       </table>
                                    </div>
                                   		<?php }else{ ?>

								
									<div class="table-responsive">
                                       <table class="table table-striped company_salary_list">
                                          <thead>
                                             <tr>
                                                <th>Department</th>
                                                <th>Posts</th>
                                                <th>Rank</th>
                                                <th>Rank Position</th>
                                                <th>Contract Currency</th>
                                                <th>Seniority</th>
                                                <th>Level Additional Comp</th>
                                                <th>Seniority Range</th>
                                                <th>Total Salary</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                             <tr>
                                                <td><?php echo \App\Models\Department::find($item->dep_id)->name ?></td>
												<?php $postInfo=\App\Models\Posts::find($item->post_id);  ?>
                                                <td><?php echo $postInfo->name ?></td>
                                                <td><?php echo $postInfo->rank ?></td>
                                                <td><?php echo $postInfo->rank_position ?></td>
                                              
                                                <td><?php echo $item->contract_currency ?></td>
                                                <td><?php echo $item->seniority ?></td>
                                                <td><?php echo $item->level_additional_comp ?></td>
                                                <td><?php echo $item->seniority_range ?></td>
                                                <td><?php echo convertPriceToNumber($item->total_salary) ?></td>
                                                
                                             </tr>
                                           
                                          </tbody>
                                       </table>
                                    </div>
		<?php } 
			$content = ob_get_contents();
			ob_end_clean();
			
			return $content;
		}
        return "n/a";
    }
}


if (!function_exists('get_company_loi_html'))
{
    function get_company_loi_html($event=null,$company=null,$companySalaryInfo=null,$user=null)
    {
		if($event!=null && $company!=null && $companySalaryInfo!=null && $user!=null){
			$post=Posts::find($companySalaryInfo->post_id);
			$department=Department::find($post->dep_id);
			//Header LOI
			$headerContent="";
			ob_start();
				$headerPath = resource_path('views/mail/candidate/loi/default/header.php');
			if($company->id==26){
				$headerPath = resource_path('views/mail/candidate/loi/explora/header.php');
			}
			if (File::exists($headerPath)) {
				include $headerPath;
			} else {
				echo "n/a";
			}
			$headerContent = ob_get_contents();
			
			ob_end_clean();
			
			//Footer LOI
			$footerContent="";
			ob_start();
			$footerPath = resource_path('views/mail/candidate/loi/default/footer.php');
			if($company->id==26){
				$footerPath = resource_path('views/mail/candidate/loi/explora/footer.php');
			}
			if (File::exists($footerPath)) {
				include $footerPath;
			} else {
				echo "";
			}
			$footerContent = ob_get_contents();
			ob_end_clean();
			
			//Main Content LOI
			$mainContent="";
			ob_start();
				$htmlPath = resource_path('views/mail/candidate/loi/default/default.php');
			if($company->id==26){
				$htmlPath = resource_path('views/mail/candidate/loi/explora/default.php');
			}
			if (File::exists($htmlPath)) {
				include $htmlPath;
			} else {
				echo "";
			}
			$mainContent = ob_get_contents();
			ob_end_clean();
			
			//return ["headerContent"=>$headerContent,"footerContent"=>$footerContent,"mainContent"=>$mainContent];
			return $mainContent;
		}
        return "n/a";
    }
}	

if (!function_exists('getDepartmentQuestionsHtmlShuffle'))
{
	function getDepartmentQuestionsHtmlShuffle($department){
		
		if(isset($department) && !empty($department->questions)){
			$content="";
			ob_start();	
					foreach(unserialize($department->questions) as $question){
						?>
							<div class="row mb-3 shuffle_question_item">
								<div class="col-md-12">
								Question: <?php echo $question['question'] ?>
								</div>
								<div class="col-md-12">
								Answer: <?php echo $question['answer'] ?>
								</div>
							</div>
							<?php
					}
										

					$content = ob_get_contents();
					ob_end_clean();
					
					return $content;
		}
		return "n/a";
	}
}
if (!function_exists('googleMapEmbedToShare'))
{
	function googleMapEmbedToShare($src){
		
		$array = explode('=', $src);
		$data = array_filter(explode('!', $array[1]));

		$location = $x = $y = '';
		foreach($data as $s)
		{
			if(substr($s, 0, 2) == "2s" and strlen($s) > 5)
			{
				$location = substr($s, 2);
			}
			elseif(substr($s, 0, 2) == "3d" and strlen($s) > 5)
			{
				$x = substr($s, 2);
			}
			elseif(substr($s, 0, 2) == "2d" and strlen($s) > 5)
			{
				$y = substr($s, 2);
			}
		}
		if($location != "" and $x != "" and $y != "")
			return 'https://www.google.com/maps/place/'.urldecode($location).'/@'.$x.','.$y;
		else
		{
			return $src;
		}

	}
}

if (!function_exists('getAgenciesUsers'))
{
    function getAgenciesUsers($isCount=true,$countries=null, $eventId=0, $isSelectedcount=false)
    {
		if($countries!=null){
			if($isCount==true){
			 $data=   DB::table('event_attendings')
			->join('user_events', 'event_attendings.uevent_id', '=', 'user_events.id')
			->join('users', 'user_events.user_id', '=', 'users.id')
			->join('user_bios', 'users.id', '=', 'user_bios.user_id')
			->where('event_attendings.event_id','=', $eventId)
			->whereIn('user_bios.nationality', $countries)
			->select('event_attendings.id');
			if($isSelectedcount==true){
			$data= $data->where('event_attendings.status','=', 3);
			}
			$data= $data->count();
				//dd($countries);
			return $data;
			}else{
				$data=    DB::table('event_attendings')
				->join('user_events', 'event_attendings.uevent_id', '=', 'user_events.id')
				->join('users', 'user_events.user_id', '=', 'users.id')
				->join('user_bios', 'users.id', '=', 'user_bios.user_id')
				->where('event_attendings.event_id','=', $eventId)
				->where('event_attendings.status','=', 3)
				->whereIn('user_bios.nationality', $countries)
				->select('user_events.id as uev_id','user_events.status as uev_status','user_events.dep_id as uev_dep_id','user_events.*','event_attendings.id as uevatt_id','event_attendings.event_info as att_event_info','event_attendings.status as att_status', 'event_attendings.*', 'users.id as u_id', 'users.*', 'user_bios.id as ubio_id', 'user_bios.*')
				->get();
				
				//dd($data);
				return $data;
			}
		}else{
			return null;
		}
	
    }
}
if (!function_exists('convertPriceToNumber'))
{
	function convertPriceToNumber($value) {
		 if (is_numeric($value)) {
			// If the value is already numeric, return it as is, rounded to 2 decimal places
			return number_format((float) $value, 2);
		} elseif (is_string($value)) {
			// If the value is a string, remove commas and convert to a float
			$newvalue = str_replace(',', '', $value);
			$floatValue = floatval($newvalue);

			// Use number_format to round to 2 decimal places
			return number_format($floatValue, 2, '.', '');
		} else {
			// Return 0.00 for other types of values
			return '0.00';
		}
	}
}





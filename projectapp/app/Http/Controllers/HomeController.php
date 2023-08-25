<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Events;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Jobs\SendEmailJob;
use App\Jobs\LoiPdfJob;
use App\Jobs\SendSheetAgencyJob;
use Shortcode;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
		$events=DB::table('events')->whereIn('status',[1,2])->where('end_date','>=',date("Y-m-d"))->get();
		$departments=DB::table('departments')->select('id','name')->get();
		 //return view('shortcode', ['events' => $events,'departments' => $departments])->withShortcodes();
		 return view('welcome', ['events' => $events,'departments' => $departments]);
    }   
	public function get_departments(Request $request,$param=null)
    {
		//dd($param);
		 
		$department = DB::table('departments')
             ->join('posts','posts.dep_id', '=', 'departments.id')// joining the posts table , where dep_id and id are same
            ->select('posts.id','posts.name')
			->where('departments.id',$param)
            ->get();
			
         return view('department', ['department' => $department]); 
    }  
    
    public function job_events(Request $request,$param=null)
    {
	  //dd($param);
	   
		$jobs = DB::table('posts')
            ->join('events','events.dep_id', '=', 'posts.dep_id')// joining the posts table , where dep_id and id are same
            ->select('events.id','events.name')
			->where('events.dep_id',$param)
            ->get();
			
            			
        //dd($jobs);
		//dd(DB::getQueryLog());
		//dd($jobs->getBindings());
		//print_r( $jobs->getBindings() );
		return view('jobevents', ['jobs' => $jobs]); 
    }   
	
	public function test_email()
    {
		echo __FILE__."</br>".asset('/assets')."</br>".__DIR__."/../assets/</br>".public_path()."</br>".base_path()."</br>".storage_path()."</br>".app_path(); 
	 $pdfContent = Shortcode::compile('[GetSalaryTable]');

        // Send the email with the PDF attachment
		$details['email'] = 'davinder.impalawebs@gmail.com';
		$details['pdfContent'] = $pdfContent;
		LoiPdfJob::dispatch($details);
        //dd(response()->json(['message' => 'Email sent successfully']));
		   $details['email'] = 'testdev1102@gmail.com';
			 SendSheetAgencyJob::dispatch($details);
			 SendEmailJob::dispatch($details);
			dd('done'); 
    }
}

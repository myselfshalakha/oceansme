<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Mail\SendEmailDemo;
use Mail;
use Illuminate\Support\Facades\DB;
 
class SendEmailJob implements ShouldQueue
{
       use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
   protected $details;
   
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new SendEmailDemo();  
     
			try {
				Mail::to('davinder.impalawebs@gmail.com')->send(new SendEmailDemo());
				 Mail::to($this->details['email'])->send($email);
					DB::table('demotable')->insert(
						array(
						'valuess'   =>   'ok',
						'created'   =>   date("Y-m-d h:i:s")
						)
					);
			 }catch(Exception $e) {
					DB::table('demotable')->insert(
					array(
					'valuess'   =>   'Message: ' .$e->getMessage(),
					'created'   =>   date("Y-m-d h:i:s")
					)
					);
			}
	}
}

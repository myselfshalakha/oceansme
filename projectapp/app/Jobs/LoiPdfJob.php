<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Mail\LoiEmail;
use Mail;
use Illuminate\Support\Facades\DB;
 
class LoiPdfJob implements ShouldQueue
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
       
     
			try {
				Mail::to($this->details['email'])->send(new LoiEmail($this->details['pdfContent']));
			 }catch(Exception $e) {
					
			}
	   
	}
}

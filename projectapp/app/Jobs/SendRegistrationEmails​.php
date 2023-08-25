<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Auth\Events\Registered;
use Mail;
use Illuminate\Support\Facades\DB;
 

class SendRegistrationEmails​ implements ShouldQueue
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
        switch ($this->details['action']) {
            case 'customer':
			// do else
				event(new Registered($this->details['user']));
			break;
			default:
			// do else
			 return;
			break;
		}
    }
}

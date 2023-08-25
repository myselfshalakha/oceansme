<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CandidateEventActivity extends Notification  implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
	protected $details; 
	public function __construct($details)
	{
	   $this->details = $details; 
	}
       


    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
         $event=$this->details["event"];
         $schedule=isset($this->details["schedule"])?$this->details["schedule"]:"";
		 $defaultEmail="mail.candidate.default";
		 switch ($event->uev_status) {
		  case "9":
			$defaultEmail=(empty($schedule))?"mail.candidate.selected":"mail.candidate.scheduled";
			break; 
			case "7":
			$defaultEmail=(empty($schedule))?"mail.candidate.selected":"mail.candidate.scheduled";
			break;
		  default:
			$defaultEmail="mail.candidate.default";
		}
		 $this->details["user"]=$notifiable;
			return (new MailMessage)
			   ->subject($this->details["subject"])
			    ->line($defaultEmail)
			   ->markdown($defaultEmail, ['details' => $this->details]);				   
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EventActivity extends Notification implements ShouldQueue
{
    use Queueable;

	protected $details; 
   public function __construct($details)
   {
       $this->details = $details; 
   }
   public function via($notifiable)
   {
       return ['mail'];
   }
   public function toMail($notifiable)
   {
	   $event=$this->details["event"];
       return (new MailMessage)
                   ->subject($this->details["subject"])
				   ->greeting('Hello! '.$notifiable->name)
                   ->line($this->details["welcomeMesage"])
                   ->line('Event Details')
                   ->line('Name: '.$event->name)
                   ->line('Description: '.$event->description)
                   ->line('Start Date: '.$event->start_date)
                   ->line('End Date: '.$event->end_date)
                   ->action('Go to your Dashbaord', url('/admin/dashboard'));
   }
   public function toArray($notifiable)
   {
       return [
           //
       ];
   }
}

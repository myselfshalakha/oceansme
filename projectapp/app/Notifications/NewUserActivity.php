<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewUserActivity extends Notification implements ShouldQueue
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
       return (new MailMessage)
                   ->subject($this->details["subject"])
				   ->greeting('Hello! '.$notifiable->name)
                   ->line($this->details["welcomeMesage"])
                   ->line('This is your login credentitals')
                   ->line('Email: '.$notifiable->email)
                   ->line('Password: '.$this->details["password"])
                   ->action('Login', url('/login'));
   }
   public function toArray($notifiable)
   {
       return [
           //
       ];
   }
}

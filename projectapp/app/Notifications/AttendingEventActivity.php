<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use PDF;

class AttendingEventActivity extends Notification  implements ShouldQueue
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
		$defaultEmail="mail.candidate.default";
         $emailtype=isset($this->details["type"])?$this->details["type"]:"";
		  $event=$this->details["event"];
		  $company=$this->details["company"];
		 if(!empty($emailtype) && $emailtype=="adminalert"){
		   return (new MailMessage)
					   ->subject($this->details["subject"])
					   ->greeting('Hello! '.$notifiable->name)
					   ->line($this->details["welcomeMesage"])
					   ->line('Event Details')
					   ->line('Name: '.$event->name)
					   ->line('Description: '.$event->description);
		 }else if(isset($event->att_status)){
			 /*  If attending */
			  switch ($event->att_status) {
			case "3":
				$defaultEmail="mail.candidate.interview_selected";
				break;
			  default:
				$defaultEmail="mail.candidate.default";
			}
		 }else{
			 /*  If only applied */
			  switch ($event->uev_status) {
			  case "6":
				$defaultEmail="mail.candidate.selected";
				break; 
			  default:
				$defaultEmail="mail.candidate.default";
			}
		 }
		 
		 $this->details["user"]=$notifiable;
		 if(isset($this->details["pdfContent"])){
			  $pdfData = $this->details["pdfContent"];
			
				$pdfPath = 'loi/email/pdf.pdf'; // Path to save the PDF file

				// Convert the PDF to an attachment using Pdfcrowd API
				$client = new \Pdfcrowd\HtmlToPdfClient("demo", "ce544b6ea52a5621fb9d55f8b542d14d");
				 if($company->id=="26"){
				
				$headerHtml = '<table style="width: 100%;">
								<tr>
									<td> <img src="'.url('/').'/assets/images/company/'.$company->logo.'" alt="logo" style="max-width: 100%; height: 91px; object-fit: contain; display: block; padding: 30px 0px"></td>
								</tr>
							</table>';
				$footerHtml = '<div style="width: 100%;">
					<p style="text-align: left;font-size: 14px;font-weight: 600; margin: 0px; padding: 50px 20px 30px 0px; line-height: 1.5em; text-align: right;"> Page <span class="pdfcrowd-page-number"></span> of <span class="pdfcrowd-page-count" style="font-weight: bold"></span></p>
				</div>';
		
				$client->setHeaderHtml($headerHtml);
				$client->setHeaderHeight('2.5in');
				$client->setFooterHeight('1.5in');
				$client->setFooterHtml($footerHtml);
				 }else{
					$headerHtml = '<table style="width: 100%;">
								<tr>
									<td> <img src="'.url('/').'/assets/images/company/'.$company->logo.'" alt="logo" style="max-width: 100%; height: 91px; object-fit: contain; display: block; padding: 30px 0px"></td>
								</tr>
							</table>';
				$footerHtml = '<div style="width: 100%;">
			<p style="text-align: center;font-size: 14px;font-weight: 600; margin: 0px; line-height: 1.5em;"><span class="pdfcrowd-page-number">1</span></span>
			<ul style=" list-style: none; text-align: right; padding: 0px 20px;">
				<li style="display: inline-block;"> <p style="font-size: 14px;font-weight: 600; line-height: 1.5em; margin: 0px; text-align: center;"> MSC </p> 
				<span style="border: 1px solid #000; width: 70px; height: 30px; display: block;"> </span> </li>
				<li style="display: inline-block;"> <p style="font-size: 14px;font-weight: 600; line-height: 1.5em; margin: 0px; text-align: center;"> AGENT </p> 
				<span style="border: 1px solid #000; width: 70px; height: 30px; display: block;"> </span> </li>
			</ul>
		</div>';
				$client->setHeaderHtml($headerHtml);
				$client->setHeaderHeight('1.7in');
				$client->setFooterHeight('1.7in');
				$client->setFooterHtml($footerHtml);
				 }
			
				
			
				$pdf = $client->convertStringToFile($pdfData,storage_path('app/' . $pdfPath));
				
			
			  return (new MailMessage)
			   ->subject($this->details["subject"])
				->attach(storage_path('app/' . $pdfPath), [
							'as' => 'loi.pdf',
							'mime' => 'application/pdf',
						])
			   ->markdown($defaultEmail, ['details' => $this->details]);
		 }
			return (new MailMessage)
			   ->subject($this->details["subject"])
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

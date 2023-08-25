<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use PDF;

class LoiEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $pdfContent;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pdfContent)
    {
        $this->pdfContent = $pdfContent;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $pdfData = $this->pdfContent;
       
        $pdfPath = 'loi/email/pdf.pdf'; // Path to save the PDF file

        // Convert the PDF to an attachment using Pdfcrowd API
        $client = new \Pdfcrowd\HtmlToPdfClient("demo", "ce544b6ea52a5621fb9d55f8b542d14d");
		/* $client = new \Pdfcrowd\HtmlToPdfClient(
            config('app.pdfcrowd_username'),
            config('app.pdfcrowd_api_key')
        ); */
 $pdf = $client->convertStringToFile($pdfData,storage_path('app/' . $pdfPath));
        

        return $this->view('emails.loiuser')
            ->attach(storage_path('app/' . $pdfPath), [
                'as' => 'loi.pdf',
                'mime' => 'application/pdf',
            ]);
    }
}

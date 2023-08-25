<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class SendSheetAgencyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $csvData;
    public $event;
    public $agency;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($csvData,$event,$agency)
    {
        $this->csvData = $csvData;
        $this->event = $event;
        $this->agency = $agency;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       
        return $this->markdown('mail.candidate.sheetcsv')->attachData($this->csvData, 'users_data.csv')->with('event', $this->event)->with('agency', $this->agency);
    }
}

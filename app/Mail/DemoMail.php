<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DemoMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */


    public $mailData;

    public function __construct($mailData)
    {
        $this->mailData= $mailData;
    }

  
    public function build()
    {
        return $this->subject($this->mailData['title'])
                    ->view('demoMail');
                    // ->with('mailData', $this->mailData);
    }
}

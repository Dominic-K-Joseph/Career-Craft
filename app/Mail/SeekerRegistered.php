<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SeekerRegistered extends Mailable
{
    use Queueable, SerializesModels;

    public $seekerName;

    public function __construct($seekerName)
    {
        $this->seekerName = $seekerName;
    }

    public function build()
    {
        return $this->subject('Welcome to Career Craft')
                    ->view('emails.seeker_registered');
    }
}

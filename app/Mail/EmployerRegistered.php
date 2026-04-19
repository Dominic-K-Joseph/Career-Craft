<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmployerRegistered extends Mailable
{
    use Queueable, SerializesModels;

    public $companyTitle;

    public function __construct($companyTitle)
    {
        $this->companyTitle = $companyTitle;
    }

    public function build()
    {
        return $this->subject('Welcome to Career Craft')
                    ->view('emails.employer_registered');
    }
}

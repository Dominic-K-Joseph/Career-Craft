<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;

class DailySeekerMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;// ← will hold "John Doe"

    public function __construct($name)// ← "John Doe" arrives here
    {
        $this->name = $name;// ← stored as class property
    }

    public function build()
    {
        return $this->subject('Good Morning from CareerCraft')
                    ->view('emails.seeker_daily')
                    ->with([
                        'name' => $this->name// ← "John Doe" sent to blade
                    ]);
    }
}
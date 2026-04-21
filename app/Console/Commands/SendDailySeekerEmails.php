<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\DailySeekerMail;

class SendDailySeekerEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'app:send-daily-seeker-emails';
    protected $signature = 'send:seeker-emails';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily emails to all seekers';
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $seekers = DB::table('tbl_seeker_profile')
            ->whereNotNull('seeker_email')
            ->get(); // returns a collection of objects

        foreach ($seekers as $seeker) {
            Mail::to($seeker->seeker_email)
                // ->send(new DailySeekerMail($seeker->seeker_name));
                ->queue(new DailySeekerMail($seeker->seeker_name));
                //                          ^^^^^^^^^^^^^^^^^^^
                //                         "John Doe" passed here

        }

        $this->info('Daily emails sent successfully!');
    }
}

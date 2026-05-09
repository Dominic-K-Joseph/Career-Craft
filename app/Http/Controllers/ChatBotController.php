<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatBotController extends Controller
{
    public function send(Request $request)
    {
        $message = strtolower($request->message);

        $reply = "Sorry, I didn't understand. Please ask CareerCraft related questions.";

        /*
        |--------------------------------------------------------------------------
        | Greetings
        |--------------------------------------------------------------------------
        */

        if (
            str_contains($message, 'hi') ||
            str_contains($message, 'hello')
        ) {

            $reply = "Hello! Welcome to CareerCraft. How can I help you today?";
        }

        /*
        |--------------------------------------------------------------------------
        | CareerCraft Info
        |--------------------------------------------------------------------------
        */

        elseif (
            str_contains($message, 'careercraft') ||
            str_contains($message, 'career craft')
        ) {

            $reply = "CareerCraft is a job portal platform where seekers can search and apply for jobs, manage profiles, upload resumes, and connect with employers.";
        }

        elseif (str_contains($message, 'career')) {

            $reply = "CareerCraft helps users build their careers by finding suitable job opportunities and improving professional profiles.";
        }

        /*
        |--------------------------------------------------------------------------
        | Resume
        |--------------------------------------------------------------------------
        */

        elseif (str_contains($message, 'resume')) {

            $reply = "Go to Profile page and upload your resume.";
        }

        /*
        |--------------------------------------------------------------------------
        | Job Apply
        |--------------------------------------------------------------------------
        */

        elseif (str_contains($message, 'apply')) {

            $reply = "Open Jobs page and click Apply button.";
        }

        /*
        |--------------------------------------------------------------------------
        | Profile
        |--------------------------------------------------------------------------
        */

        elseif (str_contains($message, 'profile')) {

            $reply = "You can update your profile from Profile section.";
        }

        /*
        |--------------------------------------------------------------------------
        | Subscription
        |--------------------------------------------------------------------------
        */

        elseif (str_contains($message, 'subscription')) {

            $reply = "Subscription details are available in Payment section.";
        }

        /*
        |--------------------------------------------------------------------------
        | Payment
        |--------------------------------------------------------------------------
        */

        elseif (str_contains($message, 'payment')) {

            $reply = "Please check your payment history in dashboard.";
        }

        /*
        |--------------------------------------------------------------------------
        | Saved Jobs
        |--------------------------------------------------------------------------
        */

        elseif (str_contains($message, 'saved jobs')) {

            $reply = "Saved jobs are available in your dashboard.";
        }

        /*
        |--------------------------------------------------------------------------
        | Logout
        |--------------------------------------------------------------------------
        */

        elseif (str_contains($message, 'logout')) {

            $reply = "Click the logout button from the top navigation menu.";
        }

        /*
        |--------------------------------------------------------------------------
        | Forgot Password
        |--------------------------------------------------------------------------
        */

        elseif (
            str_contains($message, 'forgot password') ||
            str_contains($message, 'reset password')
        ) {

            $reply = "Use Forgot Password option on the login page.";
        }

        /*
        |--------------------------------------------------------------------------
        | Jobs
        |--------------------------------------------------------------------------
        */

        elseif (str_contains($message, 'jobs')) {

            $reply = "You can browse jobs from the Jobs section.";
        }

        return response()->json([
            'reply' => $reply
        ]);
    }
}
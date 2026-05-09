<?php

namespace App\AiAgents;

use LarAgent\Agent;

class SeekerSupportAgent extends Agent
{
    protected $model = 'gpt-4.1-nano';

    protected $history = 'in_memory';

    protected $provider = 'default';

    protected $tools = [];

    public function instructions()
    {
        return "
        You are a seeker support chatbot.

        Help users with:
        - resume upload
        - job apply
        - subscriptions
        - payments
        - profile update

        Keep answers short.
        ";
    }

    public function prompt($message)
    {
        return $message;
    }
}

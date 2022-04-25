<?php

namespace App\Listeners;

use App\Events\CandidateContactedByCompany;
use App\Mail\CompanyIntroduction;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendIntroductionEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param CandidateContactedByCompany $event
     * @return void
     */
    public function handle(CandidateContactedByCompany $event)
    {
        Log::info('Email Sent!');

        Mail::to($event->candidate)->send(new CompanyIntroduction($event->candidate->name, $event->company->name));
    }
}

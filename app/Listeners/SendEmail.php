<?php

namespace App\Listeners;

use App\Events\EmailNotification;
use App\Mail\ContactEmail;
use App\Mail\HiringEmail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmail
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
     * @param EmailNotification $event
     * @return void
     */
    public function handle(EmailNotification $event)
    {
        Log::info('Before Email Send', [$event]);

        switch ($event->type) {
            case 'contact':

                Mail::to($event->candidate)
                    ->send(new ContactEmail($event->candidate->name, $event->company->name));

                break;
            case 'hired':

                Mail::to($event->candidate)
                    ->send(new HiringEmail($event->candidate->name, $event->company->name));

                break;
        }

        Log::info('Email Sent!');
    }
}

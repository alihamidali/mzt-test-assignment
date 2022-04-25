<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactEmail extends Mailable
{
    use Queueable, SerializesModels;

    private string $candidateName;
    private string $companyName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $candidateName, string $companyName)
    {
        //
        $this->candidateName = $candidateName;
        $this->companyName = $companyName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        return $this
            ->from(env('MAIL_FROM_ADDRESS'), 'Assessment')
            ->subject('We have found a job which you may find interesting!')
            ->view('emails.contact_candidate', [
                'candidateName' => $this->candidateName,
                'companyName'   => $this->companyName,
            ]);
    }
}

<?php

namespace App\Events;

use App\Models\Candidate;
use App\Models\Company;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EmailNotification
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Company $company;
    public Candidate $candidate;
    public string $type;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Company $company, Candidate $candidate, string $type)
    {
        $this->company      = $company;
        $this->candidate    = $candidate;
        $this->type    = $type;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}

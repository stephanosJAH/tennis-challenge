<?php

namespace App\Events;

use App\Models\Player;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TournamentPlayed
{
    use Dispatchable, SerializesModels;

    public array $payload;
    public array $winner;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(array $payload, array $winner)
    {
        $this->payload = $payload;
        $this->winner = $winner;
    }
}
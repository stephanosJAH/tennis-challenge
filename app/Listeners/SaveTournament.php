<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;

use App\Events\TournamentPlayed;
use App\Models\Tournament;

class SaveTournament
{
    /**
     * Handle the event.
     *
     * @param  TournamentPlayed  $event
     * @return void
     */
    public function handle(TournamentPlayed $event)
    {
        $tournament = Tournament::create([
            'name' => $event->payload['name'],
            'gender' => $event->payload['gender'],
            'type' => $event->payload['type'],
            'players' => json_encode($event->payload['players']),
            'winner_name' => $event->winner->getName(),
            'winner_skill' => $event->winner->getSkill(),
            'date' => $event->payload['date'],
        ]);
        Log::info('Tournament saved: ' . $tournament->id . ' - ' . $tournament->name);
    }
}
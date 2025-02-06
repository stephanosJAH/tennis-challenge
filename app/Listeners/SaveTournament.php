<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;

use App\Events\TournamentPlayed;
use App\Models\Tournament;
use App\Traits\PlayerHelpers;

class SaveTournament
{
    use PlayerHelpers;

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
            'winner_name' => $this->getName($event->winner),
            'winner_skill' => $this->getSkill($event->winner),
            'date' => $event->payload['date'],
        ]);
        Log::info('Tournament saved: ' . $tournament->id . ' - ' . $tournament->name);
    }
}
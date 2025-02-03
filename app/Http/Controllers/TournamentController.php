<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Factories\PlayerFactory;
use App\Services\TournamentService;

use App\Strategies\MasculineTournamentStrategy;
use App\Strategies\FeminineTournamentStrategy;

class TournamentController extends Controller {

    public function playTournament(Request $request) {

		dd($request->all());

        $players = collect($request->input('players')); // Lista de jugadores
        $type = $request->input('type'); // "male" o "female"

        // Seleccionar estrategia
        $strategy = $type === 'male' ? new MasculineTournamentStrategy() : new FeminineTournamentStrategy();
        $tournamentService = new TournamentService($strategy);

        // Jugar torneo (eliminación directa)
        while ($players->count() > 1) {
            $winners = [];
            for ($i = 0; $i < $players->count(); $i += 2) {
                $player1 = PlayerFactory::create($type, ...$players[$i]);
                $player2 = PlayerFactory::create($type, ...$players[$i + 1]);
                $winner = $tournamentService->playMatch($player1, $player2);
                $winners[] = [$winner->getName(), $winner->getSkill()];
            }
            $players = collect($winners);
        }

        return response()->json(["winner" => $players->first()]);
    }
}

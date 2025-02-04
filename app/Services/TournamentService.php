<?php 

namespace App\Services;

use Illuminate\Support\Facades\Log;

use App\Models\Player;

use App\Strategies\TournamentStrategy;
use App\Factories\PlayerFactory;

class TournamentService {

    private TournamentStrategy $strategy;

    public function __construct(TournamentStrategy $strategy) {
        $this->strategy = $strategy;
    }

	/**
	 * Play a tournament
	 * 
	 * @param array $players
	 * 
	 * @return Player
	 */
	public function playTournament(string $gender,  array $players): Player 
	{
		$players = $this->preparePlayers($gender, $players);

		while (count($players) > 1) {
			Log::info("Playing round with " . count($players) . " players");
			
			$winners = [];
			
			for ($i = 0; $i < count($players); $i += 2) {
				$winner = $this->playMatch($players[$i], $players[$i + 1]);
				Log::info("{$players[$i]->getName()} vs {$players[$i + 1]->getName()} winner is {$winner->getName()}");
				$winners[] = $winner;
			}
			
			$players = $winners;
		}

		Log::info("** {$players[0]->getName()} wins the tournament **");

		return $players[0];
	}

	/**
	 * Prepare players
	 * 
	 * @param string $gender
	 * @param array $players
	 * 
	 * @return array
	 */
	protected function preparePlayers(string $gender, array $players): array 
	{
		$preparedPlayers = [];

		foreach ($players as $player) {
			$preparedPlayers[] = PlayerFactory::create($gender, $player[0], $player[1], $player[2], $player[3] ?? 0);
		}

		return $preparedPlayers;

	}

	/**
	 * Play a match between two players
	 * 
	 * @param Player $player1
	 * @param Player $player2
	 * 
	 * @return Player
	 */
	protected function playMatch(Player $player1, Player $player2): Player {
		return $this->strategy->determineWinner($player1, $player2);
	}
}

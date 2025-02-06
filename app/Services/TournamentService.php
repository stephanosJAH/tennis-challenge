<?php 

namespace App\Services;

use Illuminate\Support\Facades\Log;

use App\Strategies\TournamentStrategy;
use App\Factories\PlayerFactory;
use App\Traits\PlayerHelpers;

class TournamentService 
{
	use PlayerHelpers;

    private TournamentStrategy $strategy;

    public function __construct(TournamentStrategy $strategy) {
		$this->strategy = $strategy;
    }

	/**
	 * Play a tournament
	 * 
	 * @param string $type
	 * @param string $gender
	 * @param array $players
	 * 
	 * @return array
	 */
	public function playTournament(string $type, string $gender,  array $players): array 
	{
		$teams = $this->prepareTeamsPlayers($type, $gender, $players);

		while (count($teams) > 1) {
			Log::info("Playing round with " . count($teams) . " teams");
			
			$winners = [];
			
			for ($i = 0; $i < count($teams); $i += 2) {
				$winner = $this->playMatch($teams[$i], $teams[$i + 1]);
				Log::info("{$this->getNameObject($teams[$i])} vs {$this->getNameObject($teams[$i+1])} winner is {$this->getNameObject($winner)}");
				$winners[] = $winner;
			}
			
			$teams = $winners;
		}

		Log::info("** {$this->getName($teams)} win the tournament **", );

		return $teams;
	}

	/**
	 * Prepare players for the tournament
	 * 
	 * @param string $type
	 * @param string $gender
	 * @param array $players
	 * 
	 * @return array
	 */
	protected function prepareTeamsPlayers(string $type, string $gender, array $players): array 
	{
		$preparedPlayers = [];

		if ($type === 'single') {
			foreach ($players as $player) {
					$preparedPlayers[] = [PlayerFactory::create($gender, $player[0], $player[1], $player[2], $player[3] ?? 0)];
			}
		}

		if ($type === 'double') {
			for ($i = 0; $i < count($players); $i += 2) {
				$preparedPlayers[] = [
					PlayerFactory::create($gender, $players[$i][0], $players[$i][1], $players[$i][2], $players[$i][3] ?? 0),
					PlayerFactory::create($gender, $players[$i+1][0], $players[$i+1][1], $players[$i+1][2], $players[$i+1][3] ?? 0)
				];
			}
		}

		return $preparedPlayers;
	}

	/**
	 * Play a match 
	 * 
	 * 
	 * @param array $team1 <List of Player>
	 * @param array $team2 <List of Player>
	 * 
	 * @return array
	 */
	protected function playMatch(array $team1, array $team2): array {
		return $this->strategy->determineWinner($team1, $team2);
	}
}

<?php 

namespace App\Services;

use App\Models\Player;

use App\Strategies\TournamentStrategy;

class TournamentService {

    private TournamentStrategy $strategy;

    public function __construct(TournamentStrategy $strategy) {
        $this->strategy = $strategy;
    }

	/**
	 * Play a match between two players
	 * 
	 * @param Player $player1
	 * @param Player $player2
	 * 
	 * @return Player
	 */
	public function playMatch(Player $player1, Player $player2): Player {
		return $this->strategy->determineWinner($player1, $player2);
	}
}

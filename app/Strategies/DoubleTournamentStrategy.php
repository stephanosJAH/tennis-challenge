<?php 

namespace App\Strategies;

use App\Models\Player;

class DoubleTournamentStrategy implements TournamentStrategy {

    /**
     * Determine the winner of a match between two couples
     * on basis of their total skill
     * 
     * @param Player $player1
     * @param Player $player2
     * 
     * @return Player
     */
    public function determineWinner(Player $player1, Player $player2): Player 
    {
        return $player1->getTotalSkill() > $player2->getTotalSkill() ? $player1 : $player2;
    }
	
}

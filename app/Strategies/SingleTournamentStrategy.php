<?php 

namespace App\Strategies;

use App\Models\Player;
use Illuminate\Support\Facades\Log;

class SingleTournamentStrategy implements TournamentStrategy {

	/**
	 * Determine the winner of a match between two players
	 * on basis of their total skill and luck
	 * 
	 * @param Player $player1
	 * @param Player $player2
	 * 
	 * @return Player
	 */
    public function determineWinner(Player $player1, Player $player2): Player 
	{
		$player1Skill = $player1->getTotalSkill() + $player1->getLuck();
		Log::info("Player {$player1->getName()} skill: " . $player1->getTotalSkill() . " + " . $player1->getLuck() . " : " . $player1Skill);
        $player2Skill = $player2->getTotalSkill() + $player2->getLuck();
		Log::info("Player {$player2->getName()} skill: " . $player2->getTotalSkill() . " + " . $player2->getLuck() . " : " . $player2Skill);

        return $player1Skill > $player2Skill ? $player1 : $player2;
    }

}

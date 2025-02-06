<?php 

namespace App\Strategies;

use App\Models\Player;
use Illuminate\Support\Facades\Log;

class SingleTournamentStrategy implements TournamentStrategy {

	/**
	 * Determine the winner of a match between two players
	 * on basis of their total skill and luck
	 * 
	 * @param array $player1 <Player>
	 * @param array $player2 <Player>
	 * 
	 * @return array
	 */
    public function determineWinner(array $player1, array $player2): array
	{
		$player1Skill = $player1[0]->getTotalSkill() + $player1[0]->getLuck();
		Log::info("Player {$player1[0]->getName()} skill: " . $player1[0]->getTotalSkill() . " + " . $player1[0]->getLuck() . " : " . $player1Skill);
        $player2Skill = $player2[0]->getTotalSkill() + $player2[0]->getLuck();
		Log::info("Player {$player2[0]->getName()} skill: " . $player2[0]->getTotalSkill() . " + " . $player2[0]->getLuck() . " : " . $player2Skill);

        return $player1Skill > $player2Skill ? $player1 : $player2;
    }

}

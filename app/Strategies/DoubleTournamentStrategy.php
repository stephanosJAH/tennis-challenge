<?php 

namespace App\Strategies;

use Illuminate\Support\Facades\Log;

class DoubleTournamentStrategy implements TournamentStrategy {

    /**
     * Determine the winner of a match between two couples or teams
     * on basis of their total skill
     * 
     * @param array $team1 
     * @param array $team2
     * 
     * @return array
     */
    public function determineWinner(array $team1, array $team2): array 
    {
        $team1Skill = $this->getTeamSkill($team1, 'team1');
        $team2Skill = $this->getTeamSkill($team2, 'team2');

        return $team1Skill > $team2Skill ? $team1 : $team2;
    }

    /**
     * Get the total skill of a team
     * 
     * @param array $team
     * 
     * @return int
     */
    private function getTeamSkill(array $team, string $nameTeam ): int
    {
        $teamSkill = 0;
        foreach ($team as $player) {
            $teamSkill +=  $player->getTotalSkill() + $player->getLuck();
            Log::info("{$nameTeam} : Player {$player->getName()} skill: " . $player->getTotalSkill() . " + " . $player->getLuck() . " : " . $teamSkill);
        }
        
        return $teamSkill;
    }
	
}

<?php 

namespace App\Strategies;

use App\Models\Player;
use App\Models\FemalePlayer;

class FeminineTournamentStrategy implements TournamentStrategy {
    public function determineWinner(Player $player1, Player $player2): Player {
        return $player1->getTotalSkill() > $player2->getTotalSkill() ? $player1 : $player2;
    }
}

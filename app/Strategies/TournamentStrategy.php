<?php

namespace App\Strategies;

use App\Models\Player;

interface TournamentStrategy {
    public function determineWinner(Player $player1, Player $player2): Player;
}
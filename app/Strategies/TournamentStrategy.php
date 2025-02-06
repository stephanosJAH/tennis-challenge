<?php

namespace App\Strategies;

/**
 * Interface TournamentStrategy
 * 
 * @param array $team1 <List of Player>
 * @param array $team2 <List of Player>
 * 
 * @return array
 * 
 * @package App\Strategies
 */
interface TournamentStrategy {
    public function determineWinner(array $team1, array $team2): array;
}
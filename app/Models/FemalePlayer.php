<?php

namespace App\Models;

class FemalePlayer extends Player 
{
    private int $reactionTime;

    public function __construct(string $name, int $skill, int $reactionTime) {
        parent::__construct($name, $skill);
        $this->reactionTime = $reactionTime;
    }

     /**
     * Get the total skill of the player
     * 
     * @return int
     */
    public function getTotalSkill(): int {
        return $this->skill + $this->reactionTime;
    }
}
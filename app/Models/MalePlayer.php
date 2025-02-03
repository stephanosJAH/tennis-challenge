<?php

namespace App\Models;

class MalePlayer extends Player {

    private int $strength;
    private int $speed;

    public function __construct(string $name, int $skill, int $strength, int $speed) 
    {
        parent::__construct($name, $skill);
        $this->strength = $strength;
        $this->speed = $speed;
    }

    /**
     * Get the total skill of the player
     * 
     * @return int
     */
    public function getTotalSkill(): int {
        return $this->skill + $this->strength + $this->speed;
    }
}
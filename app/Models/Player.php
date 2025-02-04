<?php

namespace App\Models;

abstract class Player {

    protected string $name;
    protected int $skill;

    public function __construct(string $name, int $skill) {
        $this->name = $name;
        $this->skill = $skill;
    }

    /**
     * Get the name of the player
     * 
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * Get the skill of the player
     * 
     * @return int
     */
    public function getSkill(): int {
        return $this->skill;
    }

    /**
     * Get the luck of the player
     * 
     * @return int
     */
    public function getLuck(): int
    {
        return rand(0, 25);
    }

    /**
     * Get the total skill of the player
     * 
     * @return int
     */
    abstract public function getTotalSkill(): int;
    
}
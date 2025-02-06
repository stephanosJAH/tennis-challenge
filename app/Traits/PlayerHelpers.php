<?php

namespace App\Traits;

trait PlayerHelpers
{
    /**
     * Get the name of the winner
     * 
     * @param array $winner <List of Players>
     * 
     * @return string
     */
    public function getName(array $winner): string
    {
        $names = array_map(function($player) {
            return $player->getName();
        }, reset($winner) ?? $winner);

        return implode(' - ', $names);
    }

    /**
     * Get the name of the winner
     * 
     * @param array $winner <List of Players>
     * @return string
     */
    public function getNameObject(array $teams): string
    {
        foreach ($teams as $player) {
            $names[] = $player->getName();
        }

        return implode(' - ', $names);
    }

    /**
     * Get the skill of the winner
     * 
     * @param array $winner <List of Players>
     * @return int
     */
    public function getSkill(array $winner): int
    {
        $skills = array_map(function($player) {
            return $player->getSkill();
        }, reset($winner) ?? $winner);

        return array_sum($skills);
    }
}
<?php

namespace App\Factories;

use App\Models\MalePlayer;
use App\Models\FemalePlayer;
use App\Models\Player;

use Exception;

class PlayerFactory 
{
	/**
	 * Create a new player instance
	 * 
	 * @param string $gender
	 * @param string $name
	 * @param int $skill
	 * @param int $extra1 [male - female]
	 * @param int $extra2 [male]
	 * 
	 * @return Player
	 */
    public static function create(string $gender, string $name, int $skill, int $extra1, int $extra2 = 0): Player 
    {
        if ($gender === 'male') {
            return new MalePlayer($name, $skill, $extra1, $extra2);
        } elseif ($gender === 'female') {
            return new FemalePlayer($name, $skill, $extra1);
        }

        throw new Exception("Tipo de jugador no válido");
    }
}

<?php

namespace App\Services;

use App\Strategies\SingleTournamentStrategy;
use App\Strategies\DoubleTournamentStrategy;
use App\Strategies\TournamentStrategy;
use InvalidArgumentException;

class TournamentServiceFactory
{
    /**
     * Get the tournament service based on the type
     * 
     * @param string $type
     * @return TournamentService
     */
    public static function create(string $type): TournamentService
    {
        $strategy = self::getStrategy($type);
        return new TournamentService($strategy);
    }

    /**
     * Get the tournament strategy based on the type
     * 
     * @param string $type
     * @return TournamentStrategy
     */
    private static function getStrategy(string $type): TournamentStrategy
    {
        switch ($type) {
            case 'single':
                return new SingleTournamentStrategy();
            case 'double':
                return new DoubleTournamentStrategy();
            default:
                throw new InvalidArgumentException("Invalid tournament type: $type");
        }
    }
}
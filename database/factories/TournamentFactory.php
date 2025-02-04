<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tournament>
 */
class TournamentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fakePlayers = [
                ["Juan", 80, 10, 5],
                ["Pedro", 75, 8, 6],
                ["Carlos", 90, 15, 7],
                ["Luis", 70, 25, 7],
                ["Test", 90, 8, 4],
                ["Jesus", 100, 9, 5],
                ["LAu", 98, 1, 2],
                ["Mica", 99, 8, 4]
        ];

        $fakeWinner = $fakePlayers[array_rand($fakePlayers)];

        return [
            'name' => $this->faker->name(),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'type' => $this->faker->randomElement(['single', 'double']),
            'players' => json_encode($fakePlayers),
            'winner_name' => $fakeWinner[0],
            'winner_skill' => $fakeWinner[1],
            'created_at' => now(),
        ];
    }
}

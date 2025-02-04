<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Tournament;
use Illuminate\Foundation\Testing\RefreshDatabase;


class TournamentControllerTest extends TestCase
{
    use RefreshDatabase;

     /**
     * get all tournaments
     *
     * @return void
     */
    #[\PHPUnit\Framework\Attributes\Test]
    public function get_all_tournaments() : void
    {
        Tournament::factory()->count(10)->create();

        $response = $this->get('api/tournaments');

        $response->assertStatus(200);

        $response->assertJsonCount(10, 'data');
    }

    /**
     * get all tournaments with filter by name
     * filter: 
     *  eq (equal) 
     *  like (partial)
     *
     * @return void
     */
    #[\PHPUnit\Framework\Attributes\Test]
    public function get_all_tournaments_filter_name_eq_like() : void
    {
        Tournament::factory()->count(10)->create();

        $tournament = Tournament::factory()->create(['name' => 'Tournament Test']);

        $response = $this->get('api/tournaments?name[eq]=Tournament Test');

        $response->assertStatus(200);

        $response->assertJsonCount(1, 'data');

        $response->assertJsonFragment([
            'name' => $tournament->name
        ]);

        $response = $this->get('api/tournaments?name[like]=Test');

        $response->assertStatus(200);

        $response->assertJsonCount(1, 'data');

        $response->assertJsonFragment([
            'name' => $tournament->name
        ]);

    }

    /**
     * get all tournaments with filter by gender
     * filter: 
     *  eq (equal) 
     *  in (list)
     *
     * @return void
     */
    #[\PHPUnit\Framework\Attributes\Test]
    public function get_all_tournaments() : void
    {
        Tournament::factory()->count(10)->create();
        $tournament = Tournament::factory()->create(['gender' => 'male']);


    /**
     * get tournament by id
     *
     * @return void
     */
    #[\PHPUnit\Framework\Attributes\Test]
    public function get_tournament_by_id() : void
    {
        $tournament = Tournament::factory()->create();

        $response = $this->get("api/tournaments/{$tournament->id}");

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'id' => $tournament->id,
            'name' => $tournament->name
        ]);
    }


}

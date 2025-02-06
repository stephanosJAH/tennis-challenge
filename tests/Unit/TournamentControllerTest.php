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
    public function get_all_tournaments_filter_gender_eq_in() : void
    {
        Tournament::factory()->create(['gender' => 'male']);
        Tournament::factory()->create(['gender' => 'female']);
        Tournament::factory()->create(['gender' => 'mixed']);

        $response = $this->get('api/tournaments?gender[eq]=mixed');
        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
        $response->assertJsonFragment([
            'gender' => 'mixed'
        ]);

        $response = $this->get('api/tournaments?gender[in]=male,female');
        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
    }

    /**
     * get all tournaments with filter by type
     * filter: 
     *  eq (equal) 
     *  in (list)
     *
     * @return void
     */
    #[\PHPUnit\Framework\Attributes\Test]
    public function get_all_tournaments_filter_type_eq_in() : void
    {
        Tournament::factory()->create(['type' => 'single']);
        Tournament::factory()->create(['type' => 'double']);
        Tournament::factory()->create(['type' => 'mixed']);
        Tournament::factory()->create(['type' => 'mixed']);

        $response = $this->get('api/tournaments?type[eq]=mixed');
        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
        $response->assertJsonFragment([
            'type' => 'mixed'
        ]);

        $response = $this->get('api/tournaments?type[in]=single,double');
        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
    }

    /**
     * get all tournaments with filter by winner_name
     * filter: 
     *  eq (equal) 
     *  like (partial)
     *
     * @return void
     */
    #[\PHPUnit\Framework\Attributes\Test]
    public function get_all_tournaments_filter_winner_name_eq_like() : void
    {
        Tournament::factory()->create(['winner_name' => 'Test name one']);
        Tournament::factory()->create(['winner_name' => 'Test name two']);
        Tournament::factory()->create(['winner_name' => 'Test name three']);

        $response = $this->get('api/tournaments?winner_name[eq]=Test name one');
        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
        $response->assertJsonFragment([
            'winner_name' => 'Test name one'
        ]);

        $response = $this->get('api/tournaments?winner_name[like]=name two');
        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
    }

    /**
     * get all tournaments with filter by winner_skill
     * filter: 
     *  eq (equal) 
     *  gt (greater than)
     *  lt (less than)
     *  gte (greater than or equal)
     *  lte (less than or equal) 
     * 
     * @return void
     */
    #[\PHPUnit\Framework\Attributes\Test]
    public function get_all_tournaments_filter_winner_skill_eq_gt_lt_gte_lte() : void
    {
        Tournament::factory()->create(['winner_skill' => 95]); 
        Tournament::factory()->create(['winner_skill' => 100]);
        Tournament::factory()->create(['winner_skill' => 65]);
        Tournament::factory()->create(['winner_skill' => 75]);
        Tournament::factory()->create(['winner_skill' => 85]);

        $response = $this->get('api/tournaments?winner_skill[eq]=100');
        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
        $response->assertJsonFragment([
            'winner_skill' => 100
        ]);

        $response = $this->get('api/tournaments?winner_skill[gt]=85');
        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');

        $response = $this->get('api/tournaments?winner_skill[lt]=75');
        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');

        $response = $this->get('api/tournaments?winner_skill[gte]=85');
        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');

        $response = $this->get('api/tournaments?winner_skill[lte]=75');
        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
    }

    /**
     * get all tournaments with filter by date
     * filter: 
     *  eq (partial)
     *  gt (greater than)
     *  lt (less than)
     *  gte (greater than or equal)
     *  lte (less than or equal) 
     * 
     * @return void
     */
    #[\PHPUnit\Framework\Attributes\Test]
    public function get_all_tournaments_filter_date_like_gt_lt_gte_lte() : void
    {
        Tournament::factory()->create(['date' => '2025-01-01']); 
        Tournament::factory()->create(['date' => '2025-02-01']);
        Tournament::factory()->create(['date' => '2025-03-01']);
        Tournament::factory()->create(['date' => '2025-04-01']);
        Tournament::factory()->create(['date' => '2025-05-01']);

        $response = $this->get('api/tournaments?date[eq]=2025-01-01');
        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');

        $response = $this->get('api/tournaments?date[gt]=2025-03-01');
        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');

        $response = $this->get('api/tournaments?date[lt]=2025-03-01');
        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');

        $response = $this->get('api/tournaments?date[gte]=2025-03-01');
        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');

        $response = $this->get('api/tournaments?date[lte]=2025-03-01');
        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
    }

    /**
     * get all tournaments with filter by date
     * filter range:
     *  gt (greater than)
     *  lt (less than)
     *  gte (greater than or equal)
     *  lte (less than or equal) 
     * 
     * @return void
     */
    #[\PHPUnit\Framework\Attributes\Test]
    public function get_all_tournaments_filter_created_range() : void
    {
        Tournament::factory()->create(['date' => '2025-01-01']); 
        Tournament::factory()->create(['date' => '2025-02-01']);
        Tournament::factory()->create(['date' => '2025-03-01']);
        Tournament::factory()->create(['date' => '2025-04-01']);
        Tournament::factory()->create(['date' => '2025-05-01']);

        $response = $this->get('api/tournaments?date[gt]=2025-02-01&date[lt]=2025-04-01');
        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');

        $response = $this->get('api/tournaments?date[gte]=2025-02-01&date[lte]=2025-04-01');
        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
    }

     /**
     * get all tournaments order by name
     * filter range:
     *  order_by (name)
     *  direction (asc, desc)
     * 
     * @return void
     */
    #[\PHPUnit\Framework\Attributes\Test]
    public function get_all_tournaments_order_by_name() : void
    {
        Tournament::factory()->create(['name' => 'Tournament A']); 
        Tournament::factory()->create(['name' => 'Tournament B']);
        Tournament::factory()->create(['name' => 'Tournament C']);
        Tournament::factory()->create(['name' => 'Tournament D']);
        Tournament::factory()->create(['name' => 'Tournament E']);

        $response = $this->get('api/tournaments?order_by=name&direction=asc');
        $response->assertStatus(200);
        $response->assertJsonCount(5, 'data');
        $response->assertJsonFragment([
            'name' => 'Tournament A'
        ]);

        $response = $this->get('api/tournaments?order_by=name&direction=desc');
        $response->assertStatus(200);
        $response->assertJsonCount(5, 'data');
        $response->assertJsonFragment([
            'name' => 'Tournament E'
        ]);
    }

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

    /**
     * play a tournament single
     *
     * @return void
     */
    #[\PHPUnit\Framework\Attributes\Test]
    public function get_tournament_play_single() : void
    {
        $payload = [
            'name'=> 'torneo ' . rand(1, 100),
            'gender'=> 'male',
            'type'=> 'single',
            'date'=> '2024-02-01',
            'players'=> [
                ['Juan', 45, 10, 5],
                ['Pedro', 45, 8, 6],
                ['Carlos', 34, 15, 7],
                ['Luis', 61, 25, 7],
                ['Test', 32, 8, 4],
                ['Jesus', 100, 25, 5],
                ['LAu', 43, 1, 2],
                ['Mica', 55, 8, 4]
            ]
        ];

        $response = $this->post('api/tournaments', $payload);
        $response->assertStatus(200);
        $response->assertJsonFragment([
            "winner" => "Jesus",
            "skill" => 100
        ]);
    }

    /**
     * play a tournament double
     *
     * @return void
     */
    #[\PHPUnit\Framework\Attributes\Test]
    public function get_tournament_play_double() : void
    {
        $payload = [
            'name'=> 'torneo ' . rand(1, 100),
            'gender'=> 'male',
            'type'=> 'double',
            'date'=> '2024-02-01',
            'players'=> [
                ['Juan', 45, 10, 5],
                ['Pedro', 45, 8, 6],
                ['Carlos', 34, 15, 7],
                ['Luis', 61, 25, 7],
                ['Test', 100, 25, 4],
                ['Jesus', 100, 25, 5],
                ['LAu', 43, 1, 2],
                ['Mica', 55, 8, 4]
            ]
        ];

        $response = $this->post('api/tournaments', $payload);
        $response->assertStatus(200);
        $response->assertJsonFragment([
            "winner" => "Test - Jesus",
            "skill" => 200
        ]);
    }
}

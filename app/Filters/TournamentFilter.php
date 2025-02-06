<?php 

namespace App\Filters;

use App\Filters\ApiFilter;

class TournamentFilter extends ApiFilter 
{   
    /**
     * The safe parameters.
     * 
     * @var array
     */
    protected $safeParameters = [
        'name' => ['like', 'eq'],
        'gender' => ['eq','in'],
        'type' => ['eq','in'],
        'winner_name' => ['like', 'eq'],
        'winner_skill' => ['eq', 'gt', 'lt', 'gte', 'lte'],
        'date' => ['eq', 'gt', 'lt', 'gte', 'lte'],
    ];

    /**
     * The columns map.
     * 
     * @var array
     */
    protected $columnsMap = [
        'name' => 'name',
        'gender' => 'gender',
        'type' => 'type',
        'winner_name' => 'winner_name',
        'winner_skill' => 'winner_skill',
        'date' => 'date',
    ];

    /**
     * The operators map.
     * 
     * @var array
     */
    protected $operatorsMap = [
        'like' => 'like',
        'eq' => '=',
        'gt' => '>',
        'lt' => '<',
        'lte' => '<=',
        'gte' => '>=',
        'in' => 'in',
    ];

}
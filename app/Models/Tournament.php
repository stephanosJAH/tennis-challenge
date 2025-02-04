<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tournament extends Model
{
    use HasFactory;

    protected $table = 'tournaments';

    protected $fillable = [
        'name',
        'gender',
        'type',
        'players',
        'winner_name',
        'winner_skill',
    ];


    ## scopes

    /**
     * Scope a query to where the name is like.
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array whereIns 
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereIns($query, $whereIns)
    {   
        if (empty($whereIns))
            return $query;

        foreach ($whereIns as $whereIn) {
            $query->whereIn($whereIn[0], $whereIn[1]);
        }

        return $query;
    }
}

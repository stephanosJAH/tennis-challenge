<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TournamentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'gender' => $this->gender,
            'type' => $this->type,
            'players' => json_decode($this->players),
            'winner_name' => $this->winner_name,
            'winner_skill' => $this->winner_skill,
            'date' => $this->date,
            'created_at' => $this->created_at,
        ];
    }
}

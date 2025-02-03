<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TournamentController;

Route::post('/play-tournament', [TournamentController::class, 'playTournament']);



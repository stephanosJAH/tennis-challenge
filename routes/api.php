<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TournamentController;

Route::middleware('api')->group(function () {
    Route::post('/tournaments', [TournamentController::class, 'playTournament']);
    Route::get('/tournaments', [TournamentController::class, 'index']);
    Route::get('/tournaments/{id}', [TournamentController::class, 'show']);
});
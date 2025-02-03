<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TournamentController;

Route::group(['prefix' => 'api'], function () {
	Route::post('/play-tournament', [TournamentController::class, 'playTournament']);
});
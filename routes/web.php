<?php

use App\Http\Controllers\MatchResultController;
use App\Http\Controllers\MatchScheduleController;
use App\Http\Controllers\PlayerAffiliationController;
use App\Http\Controllers\TeamController;
use App\Http\Middleware\PlayerAffiliationIndexMiddleware;
use App\Http\Middleware\MatchScheduleIndexMiddleware;
use App\Http\Middleware\MatchResultIndexMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// チーム
route::get('/teams', [TeamController::class, 'index']);

// 選手所属
route::get('/player-affiliations', [PlayerAffiliationController::class, 'index'])
    ->middleware([
        PlayerAffiliationIndexMiddleware::class
    ])->
    name('player-affiliations');

// 試合日程
route::get('/match-schedules', [MatchScheduleController::class, 'index'])
    ->middleware([
        MatchScheduleIndexMiddleware::class
    ])->
    name('match-schedules');

// 試合日程
route::get('/match-results', [MatchResultController::class, 'index'])
    ->middleware([
        MatchResultIndexMiddleware::class
    ])->
    name('match-results');

Route::get('/bootstrap', function () {
    return view('bootstrap');
});

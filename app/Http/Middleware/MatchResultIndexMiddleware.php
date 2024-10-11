<?php

namespace App\Http\Middleware;

use App\Models\MatchResult;
use App\Models\Player;
use App\Models\Season;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MatchResultIndexMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ====================
        // ここに前処理を記述
        // ====================

        // マスタの取得
        $request->merge([
            'seasons' => Season::get(),
            'players' => Player::get(),
        ]);

        // 試合結果の取得
        $match_results = MatchResult::with([
            'player',
            'matchInformation',
            'matchInformation.matchSchedule',
            'matchInformation.matchSchedule.season',
        ])
        ->when($request->player_id, function (Builder $query) use ($request) {
            $query->equalPlayerId($request->player_id);
        })
        ->when($request->season_id, function (Builder $query) use ($request) {
            $query->whereHas('matchInformation.matchSchedule', function (Builder $query) use ($request) {
                $query->equalSeasonId($request->season_id);
            });
        })
        ->get()
        ;

        $request->merge([
            'match_results' => $match_results,
        ]);

        return $next($request);
        // ====================
        // ここに後処理を記述
        // ====================
    }
}

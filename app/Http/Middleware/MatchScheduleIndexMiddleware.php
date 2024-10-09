<?php

namespace App\Http\Middleware;

use App\Models\MatchCategory;
use App\Models\MatchSchedule;
use App\Models\Season;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MatchScheduleIndexMiddleware
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
            'match_categories' => MatchCategory::get(),
        ]);

        $season_id = $request->season_id;
        $match_category_id = $request->match_category_id;
        // 試合日程の取得
        $match_schedules = MatchSchedule::with([
            'season',
            'match_category',
        ])
        ->when($season_id, function (Builder $query, int $season_id) {
            $query->equalSeasonId($season_id);
        })
        ->when($match_category_id, function (Builder $query, int $match_category_id) {
            $query->equalMatchCategoryId($match_category_id);
        })
        ->get()
        ;

        $request->merge([
            'match_schedules' => $match_schedules,
        ]);

        return $next($request);
        // ====================
        // ここに後処理を記述
        // ====================
    }
}

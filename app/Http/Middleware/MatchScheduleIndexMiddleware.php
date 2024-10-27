<?php

namespace App\Http\Middleware;

use App\Models\MatchCategory;
use App\Models\MatchSchedule;
use App\Models\Season;
use App\Traits\CommonFunctionsTrait;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MatchScheduleIndexMiddleware
{
    use CommonFunctionsTrait;
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
        // クエリパラメータが存在しない場合を考慮して、クエリパラメータの追加
        // 検索結果が0件になるように-1を指定している
        $this->addQueryParameter($request, [
            'season_id' => -1,
            'match_category_id' => -1,
        ]);

        // マスタの取得
        $request->merge([
            'seasons' => Season::get(),
            'match_categories' => MatchCategory::get(),
        ]);

        // 試合日程の取得
        $match_schedules = MatchSchedule::with([
            'season',
            'match_category',
        ])
        ->when($request->season_id, function (Builder $query) use ($request) {
            $query->equalSeasonId($request->season_id);
        })
        ->when($request->match_category_id, function (Builder $query) use ($request) {
            $query->equalMatchCategoryId($request->match_category_id);
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

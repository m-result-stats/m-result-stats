<?php

namespace App\Http\Middleware;

use App\Enums\BlankInList;
use App\Models\MatchCategory;
use App\Models\Season;
use App\Models\Team;
use App\Traits\CommonFunctionsTrait;
use App\Traits\MstatsFunctionsTrait;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TeamStatsIndexMiddleware
{
    use CommonFunctionsTrait;
    use MstatsFunctionsTrait;
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
        $this->addQueryParameter($request, [
            'team_id' => BlankInList::EXIST->value,
            'season_id' => BlankInList::EXIST->value,
            'match_category_id' => BlankInList::EXIST->value,
        ]);

        // マスタの取得
        $request->merge([
            'teams' => Team::get(),
            'seasons' => Season::get(),
            'matchCategories' => MatchCategory::get(),
        ]);

        $request->merge([
            'matchLastDateDisplay' => $this->getMatchLastDateDisplay(
                $request->season_id,
                $request->match_category_id
            ),
        ]);

        return $next($request);
        // ====================
        // ここに後処理を記述
        // ====================
    }
}

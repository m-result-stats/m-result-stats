<?php

namespace App\Http\Middleware;

use App\Models\MatchCategory;
use App\Models\MatchInformation;
use App\Models\MatchResult;
use App\Models\MatchSchedule;
use App\Models\PlayerAffiliation;
use App\Models\Season;
use App\Traits\CommonFunctionsTrait;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;

class TeamPointChartMiddleware
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
        $this->addQueryParameter($request, [
            'season_id' => 0,
            'match_category_id' => 0,
        ]);

        // マスタの取得
        $request->merge([
            'seasons' => Season::get(),
            'match_categories' => MatchCategory::get(),
        ]);


        // 検索条件から対象の試合日を配列にして取得する
        $target_match_dates = (function () use ($request) {
            $result = MatchSchedule::with([
            ])
            ->select(
                'match_date'
            )
            ->equalSeasonId($request->season_id) // シーズンでの絞り込み
            ->equalMatchCategoryId($request->match_category_id) // 試合カテゴリーでの絞り込み
            ->whereHas('matchInformation.matchResult', function (Builder $query) {
                // 試合が開催されている試合日を取得
                // 試合が開催されていない場合は選手IDが0となる
                $query->where('player_id', '<>', 0);
            })
            ->get()
            ->toArray()
            ;
            // 連想配列からただの配列に変更
            return Arr::flatten($result);
        })();

        // チームID/試合日毎のポイントを取得
        $team_points_per_match_date = (function () use ($request) {
            // チームIDでグルーピングするために、結合用の成績所属テーブルの定義
            $playerAffiliation = PlayerAffiliation::select(
                'player_id as player_id_pa',
                'team_id',
                'season_id',
            )
            ->equalSeasonId($request->season_id)
            ;

            // 試合日でグルーピングするために、結合用の試合情報テーブルの定義
            $matchInformation = MatchInformation::select(
                'match_id as match_id_mi',
                'match_date',
            )
            ;

            // チームID/試合日毎のポイントを取得
            $result = MatchResult::with([
                'team:team_id,team_name,team_color_to_graph',
            ])
            ->select(
                'team_id',
                'match_date',
            )
            ->selectRaw(
                'SUM(point + IFNULL(penalty, 0)) as sum_point', // ポイント
            )
            ->joinSub($playerAffiliation, 'pa', function (JoinClause $join) {
                $join->on('player_id', '=', 'pa.player_id_pa');
            })
            ->joinSub($matchInformation, 'mi', function (JoinClause $join) {
                $join->on('match_id', '=', 'mi.match_id_mi');
            })
            ->whereHas('matchInformation.matchSchedule', function (Builder $query) use ($request) {
                $query->equalSeasonId($request->season_id); // シーズンでの絞り込み
                $query->equalMatchCategoryId($request->match_category_id); // 試合カテゴリーでの絞り込み
            })
            ->groupBy('team_id')
            ->groupBy('match_date')
            ->orderBy('team_id')
            ->orderBy('match_date')
            ->get()
            ->toArray()
            ;

            // 取得したポイント情報をチーム毎の配列に変換
            return collect($result)->groupBy('team_id');
        })();

        // Chart.js用に
        // チーム情報+試合日毎の累計ポイントを配列に格納する
        $team_points = (function () use ($team_points_per_match_date, $target_match_dates) {
            $results = [];
            // チーム数LOOP
            foreach ($team_points_per_match_date as $key => $team_point_per_match_date) {
                // 試合日 => ポイント の連想配列に変換
                $team_points_array = Arr::mapWithKeys($team_point_per_match_date->toArray(), function (array $items, int $key) {
                    return [$items['match_date'] => $items['sum_point']];
                });

                $team_points_per_match_date_for_graph = (function () use ($team_points_array, $target_match_dates) {
                    $added = $team_points_array;

                    // チーム毎に試合日が異なるため、試合日がないチームポイントは存在しない
                    // グラフ用に試合日がないところは0ポイントで追加する
                    foreach ($target_match_dates as $key => $value) {
                        $added = Arr::add($added, $value, '0');
                    }

                    // 日付で配列をソートする
                    $sorted = collect($added)->sortKeysUsing('strnatcasecmp');

                    // 日付毎の累計ポイントを算出
                    $total_point = '';
                    foreach ($sorted as $key => $value) {
                        $total_point = bcadd($total_point, $value, 1);
                        $sorted[$key] = $total_point;
                    }

                    return $sorted;
                })();

                [$dates, $points] = Arr::divide($team_points_per_match_date_for_graph->toArray());
                // グラフ用に配列を生成
                // チームID
                // チーム名
                // チームカラー
                // 試合日毎の累計ポイント
                $results[] = [
                    'team_id' => $key,
                    'team_name' => data_get($team_point_per_match_date, '0.team.team_name'),
                    'team_color' => data_get($team_point_per_match_date, '0.team.team_color_to_graph'),
                    'points' => $points,
                ];
            }
            return $results;
        })();

        $request->merge([
            'team_points' => $team_points,
            'target_match_dates' => $target_match_dates, // 対象の試合日
        ]);

        return $next($request);
        // ====================
        // ここに後処理を記述
        // ====================
    }
}

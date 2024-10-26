<!doctype html>
<html>

<x-header title="{{ __('PlayerRanking') }}" />

<x-sidebar />

<body data-bs-theme="dark" @class([
    'container-lg',
])>
    <form action="{{ url()->current() }}" method="get">
        <div class="card card-body">
            {{-- シーズン --}}
            <x-season-list :season-id="$request->season_id" :seasons="$request->seasons" />

            {{-- 試合カテゴリー --}}
            <x-match-category-list :match-category-id="$request->match_category_id" :match-categories="$request->match_categories" />

            <button type="submit" @class([
                'btn',
                'btn-primary',
            ])>{{ __('Search') }}</button>
        </div>
    </form>
    {{--  --}}
    <div @class([
        'table-responsive',
    ])>
        <table @class([
            'table',
            'table-hover',
            'caption-top',
        ])>
            <caption>{{ __('PlayerRanking') }}</caption>
            {{-- ヘッダー --}}
            <thead>
                <tr>
                    <th @class([
                        'text-center',
                    ])>{{ __('Ranking') }}</th>
                    <th @class([
                        'text-center',
                    ])>{{ __('PlayerName') }}</th>
                    <th @class([
                        'text-center',
                    ])>{{ __('TeamName') }}</th>
                    <th @class([
                        'text-end',
                    ])>{{ __('Point') }}</th>
                    <th @class([
                        'text-end',
                    ])>{{ __('TopRatio') }}</th>
                    <th @class([
                        'text-end',
                    ])>{{ __('AvoidBottomRatio') }}</th>
                    <th @class([
                        'text-center',
                    ])>{{ __('RankingBreakdown') }}</th>
                </tr>
            </thead>
            {{-- 詳細 --}}
            <tbody>
                @foreach ($request->team_rankings as $team_ranking)
                <tr>
                    {{-- 順位 --}}
                    <td @class([
                        'text-center',
                    ])>{{ $team_ranking->player_rank }}</td>
                    {{-- 選手名 --}}
                    <td @class([
                        'text-center',
                    ])>{{ $team_ranking->player->player_name }}</td>
                    {{-- チーム名 --}}
                    @php
                        $team_color = $team_ranking->playerAffiliation->team->team_color;
                        $background_color = "background-color: #{$team_color}";
                    @endphp
                    <td @class([
                        'text-center',
                    ])
                    @style([
                        $background_color,
                    ])>{{ $team_ranking->playerAffiliation->team->team_name }}</td>
                    {{-- ポイント --}}
                    <td @class([
                        'text-end',
                        'text-danger' => $team_ranking->sum_point < 0, // マイナスポイントの場合は赤字にする
                    ])>{{ $team_ranking->sum_point }}</td>
                    {{-- トップ率 --}}
                    <td @class([
                        'text-end',
                    ])>{{ $team_ranking->top_ratio }}</td>
                    {{-- ラス回避率 --}}
                    <td @class([
                        'text-end',
                    ])>{{ $team_ranking->avoid_bottom_ratio }}</td>
                    {{-- 順位詳細 --}}
                    <td @class([
                        'text-center',
                    ])>{{ $team_ranking->rank_detail }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>

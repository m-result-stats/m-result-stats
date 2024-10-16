<!doctype html>
<html>

<x-header title="{{ __('TeamRanking') }}" />

<body @class([
    'container-lg',
])>
    <form action="{{ url()->current() }}" method="get">
        {{-- シーズン --}}
        <div @class([
            'row',
            'mb-3',
        ])>
            <label for="season_id" @class([
                'col-sm-2',
                'col-form-label'
            ])>{{ __('Season') }}</label>
            <div @class([
                'col-sm-10'
            ])>
                <select @class([
                    'form-select'
                ]) name="season_id" id="season_id">
                    @foreach ($request->seasons as $season)
                        <option value="{{ $season->season_id }}" @selected($request->season_id == $season->season_id)>
                            {{ $season->season_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- 試合カテゴリー --}}
        <div @class([
            'row',
            'mb-3',
        ])>
            <label for="match_category_id" @class([
                'col-sm-2',
                'col-form-label'
            ])>{{ __('MatchCategory') }}</label>
            <div @class([
                'col-sm-10'
            ])>
                <select @class([
                    'form-select'
                ]) name="match_category_id" id="match_category_id">
                    <option value=""></option>
                    @foreach ($request->match_categories as $match_category)
                        <option value="{{ $match_category->match_category_id }}" @selected($request->match_category_id == $match_category->match_category_id)>
                            {{ $match_category->match_category_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <button type="submit" @class([
            'btn',
            'btn-primary',
        ])>{{ __('Search') }}</button>
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
            <caption>{{ __('TeamRanking') }}</caption>
            {{-- ヘッダー --}}
            <thead>
                <tr>
                    <th @class([
                        'text-center',
                    ])>{{ __('Ranking') }}</th>
                    <th @class([
                        'text-center',
                    ])>{{ __('TeamName') }}</th>
                    <th @class([
                        'text-end',
                    ])>{{ __('Point') }}</th>
                    <th @class([
                        'text-end',
                    ])>{{ __('PointGap') }}</th>
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
                    ])>{{ $team_ranking->team_rank }}</td>
                    {{-- チーム名 --}}
                    <td @class([
                        'text-center',
                    ])>{{ $team_ranking->team->team_name }}</td>
                    {{-- ポイント --}}
                    <td @class([
                        'text-end',
                        'text-danger' => $team_ranking->sum_point < 0, // マイナスポイントの場合は赤字にする
                    ])>{{ $team_ranking->sum_point }}</td>
                    {{-- 差 --}}
                    <td @class([
                        'text-end',
                    ])>
                        {{-- 1位はハイフンで表示 --}}
                        @if ($loop->first)
                            {{ '-' }}
                        @else
                            {{ bcsub($sum_point_old, $team_ranking->sum_point, 1) }}
                        @endif
                    </td>
                    @php
                        $sum_point_old = $team_ranking->sum_point;
                    @endphp
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

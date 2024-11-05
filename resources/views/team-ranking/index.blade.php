<x-main>
    @php
        // 予選通過ライン情報が存在する場合
        // - 通過までのポイントを表示
        // - 通過順位の枠線を変更してボーダーラインを表示
        $isExistQualifyingLine = $request->qualifying_line == null ? false : true;
    @endphp
    <x-slot:title>
        {{ __('TeamRanking') }}
    </x-slot>

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

    <x-table>
        <x-slot:title>
            {{ __('TeamRanking') }}
        </x-slot>
        {{-- ヘッダー --}}
        <x-slot:header>
            <th @class([
                'text-center',
                'align-middle',
            ])>{{ __('Ranking') }}</th>
            <th @class([
                'text-center',
                'align-middle',
            ])>{{ __('TeamName') }}</th>
            <th @class([
                'text-end',
                'align-middle',
            ])>{{ __('Point') }}</th>
            <th @class([
                'text-end',
                'align-middle',
            ])>{{ __('PointGap') }}</th>
            @if ($isExistQualifyingLine)
                <th @class([
                    'text-end',
                    'align-middle',
                ])>{!! nl2br(e(__('QualifyingDifferencePoint'))) !!}</th>
            @endif
            <th @class([
                'text-end',
                'align-middle',
            ])>{{ __('MatchCount') }}</th>
            <th @class([
                'text-center',
                'align-middle',
            ])>{{ __('RankingBreakdown') }}</th>
        </x-slot>

        {{-- 詳細 --}}
        <x:slot:body>
            @foreach ($request->team_rankings as $team_ranking)
            <tr @class([
                'border-bottom border-light' => $isExistQualifyingLine && $team_ranking->team_rank == $request->qualifying_line->qualifying_line_team_rank,
            ]) class=" ">
                {{-- 順位 --}}
                <td @class([
                    'text-center',
                ])>{{ $team_ranking->team_rank }}</td>
                {{-- チーム名 --}}
                <x-team-name :team-name="$team_ranking->team->team_name" :team-color="$team_ranking->team->team_color_to_text" />
                {{-- ポイント --}}
                <x-point :point="$team_ranking->sum_point" />
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
                {{-- 通過までのポイント --}}
                @if ($isExistQualifyingLine)
                    {{-- 予選通過チーム順位が同じ場合に、予選通過チームポイントを格納する --}}
                    @php
                        if ($team_ranking->team_rank == $request->qualifying_line->qualifying_line_team_rank) {
                            $qualifyingLineTeamPoint = $team_ranking->sum_point;
                        }
                    @endphp
                    <x-qualifying-difference-point
                    :team-rank="$team_ranking->team_rank"
                    :sum-point="$team_ranking->sum_point"
                    :qualifying-line-team-rank="$request->qualifying_line->qualifying_line_team_rank"
                    :qualifying-line-team-point="$qualifyingLineTeamPoint ?? null"
                    />
                @endif
                {{-- 試合数 --}}
                <td @class([
                    'text-end',
                ])>{{ $team_ranking->match_count }}</td>
                {{-- 順位詳細 --}}
                <td @class([
                    'text-center',
                ])>{{ $team_ranking->rank_detail }}</td>
            </tr>
            @endforeach
        </x:slot>
    </x-table>
</x-main>

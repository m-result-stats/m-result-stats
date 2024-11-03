<x-main>
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
        </x-slot>

        {{-- 詳細 --}}
        <x:slot:body>
            @foreach ($request->team_rankings as $team_ranking)
            <tr>
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
                {{-- 順位詳細 --}}
                <td @class([
                    'text-center',
                ])>{{ $team_ranking->rank_detail }}</td>
            </tr>
            @endforeach
        </x:slot>
    </x-table>
</x-main>

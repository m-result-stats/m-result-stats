<x-main>
    <x-slot:title>
        {{ __('PlayerRanking') }}
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
            {{ __('PlayerRanking') }}
        </x-slot>

        <x-slot:header>
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
            ])>{{ __('MatchCount') }}</th>
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
        </x-slot>

        <x-slot:body>
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
                <x-team-name :team-name="$team_ranking->playerAffiliation->team->team_name" :team-color="$team_ranking->playerAffiliation->team->team_color_to_text" />
                <td @class([
                    'text-end',
                ])>{{$team_ranking->match_count}}</td>
                {{-- ポイント --}}
                <x-point :point="$team_ranking->sum_point" />
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
        </x-slot>
    </x-table>
</x-main>

<x-main>
    <x-slot:title>
        {{ __('MatchResult') }}
    </x-slot>

    <form action="{{ url()->current() }}" method="get">
        <div class="card card-body">
            {{-- シーズン --}}
            <x-season-list :season-id="$request->season_id" :seasons="$request->seasons" />

            {{-- 試合カテゴリ --}}
            <x-match_category-list :match_category-id="$request->match_category_id" :match_categories="$request->match_categories" :is-add-empty=true />

            {{-- チーム --}}
            <x-team-list :team-id="$request->team_id" :teams="$request->teams" :is-add-empty=true />

            {{-- 選手 --}}
            <x-player-list :player-id="$request->player_id" :players="$request->players" :is-add-empty=true />

            <button type="submit" @class([
                'btn',
                'btn-primary',
            ])>{{ __('Search') }}</button>
        </div>
    </form>

    <x-table>
        <x-slot:title>
            {{ __('MatchResult') }}
        </x-slot>

        <x-slot:header>
            <th @class([
                'text-center',
            ])>{{ __('Season') }}</th>
            <th @class([
                'text-center',
            ])>{{ __('MatchCategory') }}</th>
            <th @class([
                'text-center',
            ])>{{ __('MatchDate') }}</th>
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
            ])>{{ __('Penalty') }}</th>
        </x-slot>

        <x-slot:body>
            @foreach ($request->match_results as $match_result)
            <tr>
                <td @class([
                    'text-center',
                ])>{{ $match_result->matchInformation->matchSchedule->season->season_name }}</td>
                <td @class([
                    'text-center',
                ])>{{ $match_result->matchInformation->matchSchedule->matchCategory->match_category_name }}</td>
                <td @class([
                    'text-center',
                ])>{{ $match_result->matchInformation->match_date_order_display }}</td>
                <td @class([
                    'text-center',
                ])>{{ $match_result->rank }}</td>
                <td @class([
                    'text-center',
                ])>{{ $match_result->playerAffiliation->player->player_name}}</td>
                @php
                    $background_color = "background-color: #{$match_result->playerAffiliation->team->team_color_to_text}";
                @endphp
                <td @class([
                    'text-center',
                ])
                @style([
                    $background_color,
                ])>{{ $match_result->playerAffiliation->team->team_name }}</td>
                {{-- ポイント --}}
                <x-point :point="$match_result->point" />
                {{-- ペナルティ --}}
                <td @class([
                    'text-end',
                    'text-danger',
                ])>{{ $match_result->penalty ?? null }}</td>
            </tr>
            @endforeach
        </x-slot>
    </x-table>
</x-main>

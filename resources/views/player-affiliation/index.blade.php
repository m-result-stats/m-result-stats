<x-main>
    <x-slot:title>
        {{ __('PlayerAffiliation') }}
    </x-slot>

    {{-- 検索条件 --}}
    <x-search-condition>
        {{-- チーム --}}
        <x-team-list :team-id="$request->team_id" :teams="$request->teams" />

        {{-- シーズン --}}
        <x-season-list :season-id="$request->season_id" :seasons="$request->seasons" />
    </x-search-condition>

    {{-- 検索結果に対する見出し --}}
    <x-search-result-headline
    text-center="{{ __('PlayerAffiliation') }}"
    />

    <x-table>
        <x-slot:title>
        </x-slot>

        <x-slot:header>
            <th>ID</th>
            <th scope="col">{{ __('PlayerName') }}</th>
            <th scope="col">{{ __('Season') }}</th>
            <th scope="col">{{ __('TeamName') }}</th>
        </x-slot>

        <x-slot:body>
            @foreach ($request->playerAffiliations as $playerAffiliation)
            <tr>
                <th scope="row">{{ $playerAffiliation->playerAffiliation_id }}</th>
                <td>{{ $playerAffiliation->player->player_name }}</td>
                <td>{{ $playerAffiliation->season->season_name }}</td>
                <td>{{ $playerAffiliation->team->team_name }}</td>
            </tr>
            @endforeach
        </x-slot>
    </x-table>
</x-main>

<x-main>
    <x-slot:title>
        {{ __('PlayerAffiliation') }}
    </x-slot>

    <form action="{{ url()->current() }}" method="get">
        <div class="card card-body">
            {{-- チーム --}}
            <x-team-list :team-id="$request->team_id" :teams="$request->teams" />

            {{-- シーズン --}}
            <x-season-list :season-id="$request->season_id" :seasons="$request->seasons" />

            <button type="submit" @class([
                'btn',
                'btn-primary',
            ])>{{ __('Search') }}</button>
        </div>
    </form>

    <x-table>
        <x-slot:title>
            {{ __('PlayerAffiliation') }}
        </x-slot>

        <x-slot:header>
            <th>ID</th>
            <th scope="col">{{ __('PlayerName') }}</th>
            <th scope="col">{{ __('Season') }}</th>
            <th scope="col">{{ __('TeamName') }}</th>
        </x-slot>

        <x-slot:body>
            @foreach ($request->player_affiliations as $player_affiliation)
            <tr>
                <th scope="row">{{ $player_affiliation->player_affiliation_id }}</th>
                <td>{{ $player_affiliation->player->player_name }}</td>
                <td>{{ $player_affiliation->season->season_name }}</td>
                <td>{{ $player_affiliation->team->team_name }}</td>
            </tr>
            @endforeach
        </x-slot>
    </x-table>
</x-main>

<!doctype html>
<html>

<x-header title="{{ __('PlayerAffiliation') }}" />

<x-sidebar />

<body data-bs-theme="dark" @class([
    'container-lg',
])>
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
    <div @class([
        'table-responsive',
    ])>
        <table @class([
            'table',
            'table-hover',
            'caption-top',
        ])>
            <caption>{{ __('PlayerAffiliation') }}</caption>
            <thead>
                <tr>
                    <th>ID</th>
                    <th scope="col">{{ __('PlayerName') }}</th>
                    <th scope="col">{{ __('Season') }}</th>
                    <th scope="col">{{ __('TeamName') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($request->player_affiliations as $player_affiliation)
                <tr>
                    <th scope="row">{{ $player_affiliation->player_affiliation_id }}</th>
                    <td>{{ $player_affiliation->player->player_name }}</td>
                    <td>{{ $player_affiliation->season->season_name }}</td>
                    <td>{{ $player_affiliation->team->team_name }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>

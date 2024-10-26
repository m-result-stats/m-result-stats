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
            <div class="mb-3">
                <label for="team_id" class="form-label">チーム</label>
                <select name="team_id" class="form-select" id="team_id">
                    <option value=""></option>
                    @foreach ($request->teams as $team)
                        <option value="{{ $team->team_id }}" @selected($request->team_id == $team->team_id)>
                            {{ $team->team_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- シーズン --}}
            <div class="mb-3">
                <label for="season_id" class="form-label">シーズン</label>{{ old('season_id') }}
                <select name="season_id" class="form-select" id="season_id">
                    <option value=""></option>
                    @foreach ($request->seasons as $season)
                        <option value="{{ $season->season_id }}" @selected($request->season_id == $season->season_id)>
                            {{ $season->season_name }}
                        </option>
                    @endforeach
                </select>
            </div>

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

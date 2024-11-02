<!doctype html>
<html>

<x-header title="{{ __('Team') }}" />

<x-sidebar />

<body data-bs-theme="dark" @class([
    'container-lg',
])>
    <x-table>
        <x-slot:title>
            {{ __('Team') }}
        </x-slot>

        <x-slot:header>
            <th scope="col">@sortablelink('team_id', 'ID')</th>
            <th scope="col">@sortablelink('team_name', 'チーム名')</th>
        </x-slot>

        <x-slot:body>
            @foreach ($teams as $team)
            <tr>
                <th scope="row">{{ $team->team_id }}</th>
                {{-- チーム名 --}}
                <x-team-name :team-name="$team->team_name" :team-color="$team->team_color_to_text" />
            </tr>
            @endforeach
        </x-slot>
    </x-table>
</body>

</html>

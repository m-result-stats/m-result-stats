<!doctype html>
<html>

<x-header title="{{ __('Team') }}" />

<x-sidebar />

<body data-bs-theme="dark" @class([
    'container-lg',
])>
    <div @class([
        'table-responsive',
    ])>
        <table @class([
            'table',
            'table-hover',
            'caption-top',
        ])>
            <caption>{{ __('Team') }}</caption>
            <thead>
                <tr>
                    <th scope="col">@sortablelink('team_id', 'ID')</th>
                    <th scope="col">@sortablelink('team_name', 'チーム名')</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($teams as $team)
                <tr>
                    <th scope="row">{{ $team->team_id }}</th>
                    <td>{{ $team->team_name }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>

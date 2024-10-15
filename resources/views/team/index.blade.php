<!doctype html>
<html>

<x-header title="チーム一覧" />

<body>
    <table class="table table-striped table-hover caption-top">
        <caption>チーム一覧</caption>
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
</body>

</html>

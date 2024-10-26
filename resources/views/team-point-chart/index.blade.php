<!doctype html>
<html>

<x-header title="{{ __('TeamPointChart') }}" />

<body data-bs-theme="dark" @class([
    'container-lg',
])>
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

    {{-- グラフ --}}
    <canvas id="team-point-chart"></canvas>
    <script type="module">
        const labels = @json($request->target_match_dates);
        const data = {
            labels: labels,
            datasets: [
                @foreach ($request->team_points as $key => $value)
                {
                    label: '{{ $value['team_name'] }}',
                    data: @json($value['points']),
                    backgroundColor: '#{{ $value['team_color'] }}',
                    borderColor: '#{{ $value['team_color'] }}',
                    pointRadius: 3, {{-- 点の半径 --}}
                } @if (!$loop->last) , @endif
                @endforeach
            ],
        };
        makeTeamPointChart('team-point-chart', data);
    </script>
</body>

</html>

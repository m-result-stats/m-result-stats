<x-main>
    <x-slot:title>
        {{ __('TeamPointChart') }}
    </x-slot>

    {{-- 検索条件 --}}
    <x-search-condition>
        {{-- シーズン --}}
        <x-season-list :season-id="$request->season_id" :seasons="$request->seasons" />

        {{-- 試合カテゴリー --}}
        <x-match-category-list :match-category-id="$request->match_category_id" :match-categories="$request->matchCategories" />
    </x-search-condition>

    {{-- グラフ --}}
    <canvas id="teamPointChart"></canvas>
    <script type="module">
        const labels = @json($request->targetMatchDates);
        const data = {
            labels: labels,
            datasets: [
                @foreach ($request->teamPoints as $key => $value)
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
        makeTeamPointChart('teamPointChart', data);
    </script>
</x-main>

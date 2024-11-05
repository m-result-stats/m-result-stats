<x-main>
    <x-slot:title>
        {{ __('TeamPointChart') }}
    </x-slot>

    <form action="{{ url()->current() }}" method="get">
        <div class="card card-body">
            {{-- シーズン --}}
            <x-season-list :season-id="$request->season_id" :seasons="$request->seasons" />

            {{-- 試合カテゴリー --}}
            <x-match-category-list :match-category-id="$request->match_category_id" :match-categories="$request->matchCategories" />

            <button type="submit" @class([
                'btn',
                'btn-primary',
            ])>{{ __('Search') }}</button>
        </div>
    </form>

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

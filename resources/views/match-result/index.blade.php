<!doctype html>
<html>

<x-header title="{{ __('MatchResult') }}" />

<x-sidebar />

<body data-bs-theme="dark" @class([
    'container-lg',
])>
    <form action="{{ url()->current() }}" method="get">
        <div class="card card-body">
            {{-- シーズン --}}
            <x-season-list :season-id="$request->season_id" :seasons="$request->seasons" />

            {{-- 選手 --}}
            <x-player-list :player-id="$request->player_id" :players="$request->players" :is-add-empty=true />

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
            <caption>{{ __('MatchResult') }}</caption>
            <thead>
                <tr>
                    <th scope="col">{{ __('Season') }}</th>
                    <th>{{ __('MatchDate') }}</th>
                    <th>{{ __('Ranking') }}</th>
                    <th>{{ __('PlayerName') }}</th>
                    <th>{{ __('Point') }}</th>
                    <th>{{ __('Penalty') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($request->match_results as $match_result)
                <tr>
                    <td>{{ $match_result->matchInformation->matchSchedule->season->season_name }}</td>
                    <td>{{ $match_result->matchInformation->match_date_order_display }}</td>
                    <td>{{ $match_result->rank }}</td>
                    <td>{{ $match_result->player->player_name ?? null }}</td>
                    @php
                        $isMinus = $match_result->point < 0 ? true : false;
                    @endphp
                    {{-- ポイント --}}
                    <td @class([
                        'text-end',
                        'text-danger' => $isMinus, // マイナスポイントの場合は赤字にする
                    ])>{{ $match_result->point }}</td>
                    {{-- ペナルティ --}}
                    <td @class([
                        'text-end',
                        'text-danger',
                    ])>{{ $match_result->penalty ?? null }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>

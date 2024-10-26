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
            <div @class([
                'row',
                'mb-3',
            ])>
                <label for="season_id" @class([
                    'col-sm-2',
                    'col-form-label'
                ])>シーズン</label>
                <div @class([
                    'col-sm-10'
                ])>
                    <select @class([
                        'form-select'
                    ]) name="season_id" id="season_id">
                        <option value=""></option>
                        @foreach ($request->seasons as $season)
                            <option value="{{ $season->season_id }}" @selected($request->season_id == $season->season_id)>
                                {{ $season->season_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- 選手 --}}
            <div @class([
                'row',
                'mb-3',
            ])>
                <label for="player_id" @class([
                    'col-sm-2',
                    'col-form-label',
                ])>選手</label>
                <div @class([
                    'col-sm-10'
                ])>
                    <select @class([
                        'form-select'
                    ]) name="player_id" id="player_id">
                        <option value=""></option>
                        @foreach ($request->players as $player)
                            <option value="{{ $player->player_id }}" @selected($request->player_id == $player->player_id)>
                                {{ $player->player_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
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

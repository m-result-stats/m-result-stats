<!doctype html>
<html>

<x-header title="チームランキング" />

<body @class([
    'container-lg',
])>
    <form action="{{ url()->current() }}" method="get">
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

        <button type="submit" @class([
            'btn',
            'btn-primary',
        ])>検索</button>
    </form>
    {{--  --}}
    <div @class([
        'table-responsive',
    ])>
        <table @class([
            'table',
            'table-striped',
            'table-hover',
            'caption-top',
        ])>
            <caption>試合成績一覧</caption>
            {{-- ヘッダー --}}
            <thead>
                <tr>
                    <th @class([
                        'text-center',
                    ])>順位</th>
                    <th @class([
                        'text-center',
                    ])>チーム名</th>
                    <th @class([
                        'text-end',
                    ])>ポイント</th>
                    <th @class([
                        'text-end',
                    ])>差</th>
                    <th @class([
                        'text-center',
                    ])>順位詳細</th>
                </tr>
            </thead>
            {{-- 詳細 --}}
            <tbody>
                @foreach ($request->team_rankings as $team_ranking)
                <tr>
                    {{-- 順位 --}}
                    <td @class([
                        'text-center',
                    ])>{{ $team_ranking->team_rank }}</td>
                    {{-- チーム名 --}}
                    <td @class([
                        'text-center',
                    ])>{{ $team_ranking->team->team_name }}</td>
                    @php
                        $isMinus = $team_ranking->sum_point < 0 ? true : false;
                    @endphp
                    {{-- ポイント --}}
                    <td @class([
                        'text-end',
                        'text-danger' => $isMinus, // マイナスポイントの場合は赤字にする
                    ])>{{ $team_ranking->sum_point }}</td>
                    {{-- 差 --}}
                    <td @class([
                        'text-end',
                    ])>
                        {{-- 1位はハイフンで表示 --}}
                        @if ($loop->first)
                            {{ '-' }}
                        @else
                            {{ $sum_point_old - $team_ranking->sum_point }}
                        @endif
                    </td>
                    @php
                        $sum_point_old = $team_ranking->sum_point;
                    @endphp
                    {{-- 順位詳細 --}}
                    <td @class([
                        'text-center',
                    ])>{{ $team_ranking->rank_detail }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>

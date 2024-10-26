<!doctype html>
<html>

<x-header title="試合日程一覧" />

<x-sidebar />

<body>
    <form action="{{ route('match-schedules') }}" method="get">
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

        {{-- 試合区分 --}}
        <div class="mb-3">
            <label for="match_category_id" class="form-label">試合区分</label>
            <select name="match_category_id" class="form-select" id="match_category_id">
                <option value=""></option>
                @foreach ($request->match_categories as $match_category)
                    <option value="{{ $match_category->match_category_id }}" @selected($request->match_category_id == $match_category->match_category_id)>
                        {{ $match_category->match_category_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" @class([
            'btn',
            'btn-primary',
        ])>検索</button>
    </form>
    <table class="table table-striped table-hover caption-top">
        <caption>試合日程一覧</caption>
        <thead>
            <tr>
                <th scope="col">試合日</th>
                <th scope="col">シーズン</th>
                <th scope="col">試合区分</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($request->match_schedules as $match_schedule)
            <tr>
                <th scope="row">{{ $match_schedule->match_date_display }}</th>
                <td>{{ $match_schedule->season->season_name }}</td>
                <td>{{ $match_schedule->match_category->match_category_name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>

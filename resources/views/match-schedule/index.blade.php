<!doctype html>
<html>

<x-header title="{{ __('MatchSchedule') }}" />

<x-sidebar />

<body data-bs-theme="dark" @class([
    'container-lg',
])>
    <form action="{{ url()->current() }}" method="get">
        <div class="card card-body">
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
            <caption>{{ __('MatchSchedule') }}</caption>
            <thead>
                <tr>
                    <th scope="col">{{ __('MatchDate') }}</th>
                    <th>{{ __('Season') }}</th>
                    <th>{{ __('MatchCategory') }}</th>
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
    </div>
</body>

</html>

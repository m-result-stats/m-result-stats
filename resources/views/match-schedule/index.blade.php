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
            <x-season-list :season-id="$request->season_id" :seasons="$request->seasons" />

            {{-- 試合区分 --}}
            <x-match-category-list :match-category-id="$request->match_category_id" :match-categories="$request->match_categories" />

            <button type="submit" @class([
                'btn',
                'btn-primary',
            ])>{{ __('Search') }}</button>
        </div>
    </form>

    <x-table>
        <x-slot:title>
            {{ __('MatchSchedule') }}
        </x-slot>

        <x-slot:header>
            <th scope="col">{{ __('MatchDate') }}</th>
            <th>{{ __('Season') }}</th>
            <th>{{ __('MatchCategory') }}</th>
        </x-slot>

        <x-slot:body>
            @foreach ($request->match_schedules as $match_schedule)
            <tr>
                <th scope="row">{{ $match_schedule->match_date_display }}</th>
                <td>{{ $match_schedule->season->season_name }}</td>
                <td>{{ $match_schedule->matchCategory->match_category_name }}</td>
            </tr>
            @endforeach
        </x-slot>
    </x-table>
</body>

</html>

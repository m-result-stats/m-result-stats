<x-main data-page="teamStatsChart">
    @php
        // 予選通過ライン情報が存在する場合
        // - 通過までのポイントを表示
        // - 通過順位の枠線を変更してボーダーラインを表示
        $isExistQualifyingLine = $request->qualifyingLine == null ? false : true;
    @endphp
    <x-slot:title>
        {{ __('TeamStats') }}
    </x-slot>

    {{-- 検索条件 --}}
    <x-search-condition>
        {{-- シーズン --}}
        <x-season-list :season-id="$request->season_id" :seasons="$request->seasons" />

        {{-- 試合カテゴリー --}}
        <x-match-category-list :match-category-id="$request->match_category_id" :match-categories="$request->matchCategories" />

        {{-- チーム --}}
        <x-team-list :team-id="$request->team_id" :teams="$request->teams" />
    </x-search-condition>

    {{-- 検索結果に対する見出し --}}
    <x-search-result-headline
    :text-end="$request->matchLastDateDisplay"
    />
</x-main>

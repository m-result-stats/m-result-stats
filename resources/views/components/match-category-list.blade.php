<div @class([
    'row',
    'mb-3',
])>
    <label for="match_category_id" @class([
        'col-sm-2',
        'col-form-label'
    ])>{{ __('MatchCategory') }}</label>
    <div @class([
        'col-sm-10'
    ])>
        <select @class([
            'form-select'
        ]) name="match_category_id" id="match_category_id">
            <option value=""></option>
            @foreach ($matchCategories as $match_category)
                <option value="{{ $match_category->match_category_id }}" @selected($matchCategoryId == $match_category->match_category_id)>
                    {{ $match_category->match_category_name }}
                </option>
            @endforeach
        </select>
    </div>
</div>

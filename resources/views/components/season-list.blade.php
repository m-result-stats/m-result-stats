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
            @foreach ($seasons as $season)
                <option value="{{ $season->season_id }}" @selected($seasonId == $season->season_id)>
                    {{ $season->season_name }}
                </option>
            @endforeach
        </select>
    </div>
</div>

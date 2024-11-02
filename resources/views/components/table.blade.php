<div @class([
    'table-responsive',
])>
    <caption>{{ $title }}</caption>

    <table @class([
        'table',
        'table-hover',
        'caption-top',
    ])>
        <thead>
            <tr>
                {{ $header }}
            </tr>
        </thead>

        <tbody>
            {{ $body }}
        </tbody>
    </table>
</div>

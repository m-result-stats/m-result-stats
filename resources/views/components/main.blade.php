<!doctype html>
<html>

<x-header title="{{ $title }}" />

<x-sidebar />

<body data-bs-theme="dark" @class([
    'container-lg',
])>
    {{ $slot }}
</body>

</html>

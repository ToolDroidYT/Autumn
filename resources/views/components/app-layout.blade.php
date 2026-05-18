@props(['title' => 'AUTUMN'])
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} | {{ config('app.name', 'AUTUMN') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/autumn.css') }}">
</head>
<body data-toast="{{ session('toast') }}">
    <x-header />
    <main>{{ $slot }}</main>
    <x-footer />
    <div id="toast" class="toast" role="status" aria-live="polite"></div>
    <x-modal />
    <script src="{{ asset('assets/autumn.js') }}" defer></script>
</body>
</html>

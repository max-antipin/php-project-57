<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@lang('layouts.app.task_manager')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="csrf-param" content="_token" />
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">@lang('layouts.app.task_manager')</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link active" href="{{ route('tasks.index') }}">@lang('layouts.app.tasks')</a>
                <a class="nav-link" href="{{ route('statuses.index') }}">@lang('layouts.app.statuses')</a>
                <a class="nav-link" href="{{ route('labels.index') }}">@lang('layouts.app.labels')</a>
            </div>
        </div>
        @include('layouts.navigation')
    </div>
</nav>

<div class="container">
    <h1>@yield('header')</h1>
    <div>@yield('content')</div>
</div>

</body>
</html>

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <link href="{{ url('/css/core.css') }}" type="text/css" rel="stylesheet">
    @yield('styles')
</head>
<body>
<div id="root">
    @yield('body')
</div>
<script src="{{ url('/js/core.js') }}" type="application/javascript"></script>
@yield('scripts')
</body>
</html>

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover" name="viewport">
    <title>Laravel Web Scrapper</title>
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    <script src="{{ mix('/js/app.js') }}"  type="text/javascript" defer></script>
</head>
<body>
@include('layouts.nav')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-1"></div>
            <div class="col-md-10">
                @yield('content')
            </div>
        <div class="col-md-1"></div>
    </div>
</div>
</body>
</html>

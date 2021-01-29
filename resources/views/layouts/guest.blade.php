<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta content="text/css" http-equiv="Content-Type">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{config('app.subtitle')}}">
    <title>@yield('title') | {{ config('app.name') }}</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="stylesheet" href="{{asset('css/elements/nav.css')}}">
    <link rel="stylesheet" href="{{asset('css/elements/button.css')}}">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css"/>
    <link rel="icon" href="{{asset('img/donadores-compulsivos-icon.png')}}" sizes="56x56">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('stylesheets')
</head>
<body>
  <div id="app">
    <main class="py-4">
      @yield('content')
    </main>
  </div>
  @yield('scripts')
</body>
</html>

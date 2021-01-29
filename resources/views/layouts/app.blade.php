<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    {{-- <meta charset="utf-8"> --}}
    <meta content="text/css; charset=UTF-8" http-equiv="Content-Type">
    <meta content="application/javascript" http-equiv="Content-Type">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{config('app.subtitle')}}">
    <title>@yield('title') | {{ config('app.name') }}</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="stylesheet" href="{{asset('css/elements/nav.css')}}">
    <link rel="stylesheet" href="{{asset('css/elements/button.css')}}">
    <link rel="stylesheet" href="{{asset('css/elements/switch-toggle.css')}}">
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
    <nav class="navbar navbar-expand-md navbar-dark  bg-black shadow-sm">
      <div class="container">
        @guest
          <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{asset('img/donadores-logo.svg')}}" class="d-inline-block align-top" alt="">
          </a>
        @else
          <a class="navbar-brand" href="{{ url('/home') }}">
            <img src="{{asset('img/donadores-logo.svg')}}" class="d-inline-block align-top" alt="">
          </a>
        @endguest
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
          <span class="navbar-toggler-icon text-white"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            @auth
              @if(!Request::is('home') && Auth::user()->is_admin)
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                    {{__('Donors')}}
                  </a>
                  <div class="dropdown-menu">
                    <a class="dropdown-item text-dark text-center" href="{{route('donors.index')}}">{{__('Registered')}}</a>
                    <a class="dropdown-item text-dark text-center" href="{{route('temporal_donors.index')}}">{{__('Pre donor')}}</a>
                  </div>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{route('admins.index')}}">{{__('Admins')}}</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{route('campaigns.index')}}">{{__('Campaigns')}}</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{route('bloodbanks.index')}}">{{__('Blood banks')}}</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{route('reports.index')}}">{{__('Log files')}}</a>
                </li>
              @endif  
            @endauth
          </ul>
          <ul class="navbar-nav ml-auto">
            @guest
              <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('login') }}">{{ __('Login') }}</a>
              </li>
              @if (Route::has('register'))
                <li class="nav-item">
                  <a class="nav-link text-white" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
              @endif
            @else
              <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                  {{ Auth::user()->name }} <span class="caret"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="mailto:soporte2@jlmarketing.com.mx?subject=Reporte de problema de Donadores Compulsivos"><i class="fa fa-bug mx-1" aria-hidden="true"></i>{{__('Report bug')}} </a>
                  <a class="dropdown-item" href="#"><i class="fa fa-question mx-1" aria-hidden="true"></i>{{__('Help')}} </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out mx-1" aria-hidden="true"></i>{{ __('Logout') }}
                  </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                  </form>
                </div>
              </li>
            @endguest
          </ul>
        </div>
      </div>
    </nav>
    <main class="py-4">
      @yield('content')
    </main>
  </div>
  @yield('scripts')
</body>
</html>

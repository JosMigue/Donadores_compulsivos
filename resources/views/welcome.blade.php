<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="{{asset('img/donadores-compulsivos-icon.png')}}" sizes="56x56">
        <title>{{env('APP_NAME')}}</title>
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('css/elements/button.css')}}">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <style>
          html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
          }

          .full-height {
            height: 100vh;
          }

          .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
          }

          .position-ref {
            position: relative;
          }

          .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
          }

          .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
          }
          .txt-uppercase{
            text-transform: uppercase;
          }
        </style>
    </head>
    <body>
      <div class="flex-center position-ref full-height">
        @if (Route::has('login'))
        <div class="top-right links">
          @auth
          <a href="{{ url('/home') }}">{{__('Home')}}</a>
          @else
          <a href="{{ route('login') }}">{{__('Login')}}</a>
          @if (Route::has('register'))
          <a href="{{ route('register') }}">{{__('Register')}}</a>
          @endif
          @endauth
        </div>
        @endif
        <div class="container">
          <div class="row">
            <div class="col-12 d-flex justify-content-center">
            <h1>{{__('Welcome')}}</h1>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-lg-6 d-flex justify-content-center">
              <a class="is-panel-button is-btn-bg-dark txt-uppercase" href="{{ route('login') }}">{{__('Login')}}</a>
            </div>
            <div class="col-12 col-lg-6 d-flex justify-content-center">
              <a class="is-panel-button is-btn-bg-red txt-uppercase" href="{{ route('donor.register') }}">{{__('Sign Up')}}</a>
            </div>
          </div>
        </div>
      </div>
    </body>
</html>

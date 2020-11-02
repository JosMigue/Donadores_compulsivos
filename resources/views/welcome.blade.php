<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="{{config('app.subtitle')}}">
        <title>{{ config('app.name')}}</title>
        <link rel="icon" href="{{asset('img/donadores-compulsivos-icon.png')}}" sizes="56x56">
        <title>{{env('APP_NAME')}}</title>
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link  href="{{asset('css/elements/body.css')}}" rel="stylesheet">
        <link href="{{ asset('css/elements/button.css') }}" rel="stylesheet">
    </head>
    <body>
      <div class="container">
        @if (session('successMessage'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{__('Done!')}}</strong> {{session('successMessage')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @endif
        @if (session('information'))
          <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong>{{__('Whoops!')}}</strong> {{session('information')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @endif
        @if (session('errorMessage'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{__('Whoops!')}}</strong> {{session('errorMessage')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @endif
      </div>
      <div class="flex-center position-ref full-height">
        <div class="container">
          <div class="row">
            <div class="col-12 col-lg-4 mb-50 d-flex justify-content-center align-items-start">
              @auth
              <a class="is-btn-lg is-btn-bg-dark txt-uppercase" href="{{ route('home') }}">{{__('Go Home')}}</a>
              @else
              <a class="is-btn-lg is-btn-bg-dark txt-uppercase" href="{{ route('login') }}">{{__('Login')}}</a>
              @endauth
            </div>
            <div class="col-12 col-lg-4 mb-50 d-flex justify-content-center align-items-start">
              <a class="is-btn-lg is-btn-bg-red txt-uppercase" href="{{ route('donor.register') }}">{{__('Sign Up')}}</a>
            </div>
          </div>
        </div>
      </div>
    </body>
</html>

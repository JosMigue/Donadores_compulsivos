@extends('layouts.app')

@section('title', __('Login'))

@section('stylesheets')
  <link href="{{asset('css/theme/floating-labels.css')}}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
  @if (session('loginMessage'))
    <div class="alert alert-info" role="alert">
      {{session('loginMessage')}}
    </div>
  @endif
  <form class="form-signin" method="POST" action="{{ route('login') }}">
    @csrf
  <div class="mb-4 text-center">
    <img class="mb-4" src="{{asset('img/donadores-compulsivos-icon.png')}}" alt="" width="72" height="72">
    <h1 class="h3 mb-3 font-weight-normal">Donadores Compulsivos</h1>
    <p class="text-justify">Donadores Compulsivos somos todos los que, sin importar nuestras circunstancias, sentimos el deseo incontrolable de ayudar y contribuir a una causa de beneficio social.</p>
  </div>
  <div class="form-label-group">
    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email address" value="{{ old('email') }}" required autocomplete="email" autofocus>
    <label for="email">{{ __('E-Mail Address') }}</label>
  </div>
  @error('email')
  <span class="invalid-feedback d-block" role="alert">
    <strong>{{ $message }}</strong>
  </span>
  @enderror
  <div class="form-label-group">
    <input type="password" id="inputPassword" name="password" required class="form-control" placeholder="{{ __('Password') }}" required>
    <label for="inputPassword">{{ __('Password') }}</label>
  </div>
  @error('password')
  <span class="invalid-feedback d-block" role="alert">
    <strong>{{ $message }}</strong>
  </span>
  @enderror
  <div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
    <label class="form-check-label" for="remember">
      {{ __('Remember Me') }}
    </label>
  </div>
  <button class="btn btn-lg btn-primary btn-block" type="submit">{{ __('Login') }}</button>
  @if (Route::has('password.request'))
  <a class="btn btn-link" href="{{ route('password.request') }}">
    {{ __('Forgot Your Password?') }}
  </a>
  @endif
  <p class="mt-5 mb-3 text-muted text-center"> Todos los derechos Reservados &copy; Donadores Compulsivos - Un sitio realizado y patrocinado por <a class="btn btn-link" href="https://jlmarketing.com.mx/">JL Marketing</a></p>
  </form>
</div>
@endsection

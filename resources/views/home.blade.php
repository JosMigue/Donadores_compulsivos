@extends('layouts.app')

@section('title',__('Dashboard'))

@section('stylesheets')
  <link rel="stylesheet" href="{{asset('css/elements/button.css')}}">
@endsection

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">{{ __('Dashboard') }}</div>
        <div class="card-body">
          @if (session('status'))
            <div class="alert alert-success" role="alert">
              {{ session('status') }}
            </div>
          @endif
          {{ __('You are logged in!') }}
        </div>
        <div class="row d-flex align-content-center">
          <div class="col-lg-4 col-sm-8 col-12">
            <a class="is-menu-button is-btn-bg-red" href="{{route('donors.index')}}">{{__('Donors')}}</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

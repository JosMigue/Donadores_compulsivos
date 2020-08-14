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
        <div class="row">
          <div class="col-lg-4 col-sm-8 col-12 my-3 d-flex justify-content-center">
            <a class="is-menu-button is-btn-bg-red" href="{{route('donors.index')}}">{{__('Donors')}}<i class="fa fa-users mx-1" aria-hidden="true"></i></a>
          </div>
          <div class="col-lg-4 col-sm-8 col-12 my-3 d-flex justify-content-center">
            <a class="is-menu-button is-btn-bg-dark" href="{{route('admins.index')}}">{{__('Admins')}}<i class="fa fa-lock mx-1" aria-hidden="true"></i></a>
          </div>
          <div class="col-lg-4 col-sm-8 col-12 my-3 d-flex justify-content-center">
            <a class="is-menu-button is-btn-bg-red" href="{{route('bloodbanks.index')}}">{{__('Blood banks')}}<i class="fa fa-hospital-o mx-1" aria-hidden="true"></i></a>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4 col-sm-8 col-12 my-3 d-flex justify-content-center">
            <a class="is-menu-button is-btn-bg-dark" href="{{route('campaigns.index')}}">{{__('Campaigns')}}<i class="fa fa-bullhorn mx-1" aria-hidden="true"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

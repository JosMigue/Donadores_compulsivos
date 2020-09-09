@extends('layouts.app')

@section('title',__('Dashboard'))

@section('stylesheets')
  <link rel="stylesheet" href="{{asset('css/elements/button.css')}}">
  <link rel="stylesheet" href="{{asset('css/theme/info-box.css')}}">
@endsection

@section('content')
<div class="container">
  @if (session('errorMessage'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>{{session('errorMessage')}}</strong>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  @endif
  @if (session('successMessage'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>{{session('successMessage')}}</strong>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  @endif
  @if (session('information'))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
      <strong>{{session('information')}}</strong>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  @endif
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
            <div class="row">
              <div class="col-12 d-flex justify-content-center text-center">
                {{ __('You are logged in!') }}
                <br>
                {{__('Welcome')}} {{Auth::user()->name}}
              </div>
            </div>
        </div>
        @if (Auth::user()->is_admin)
{{--           <div class="row mbl info-box">
            <div class="col-12 col-md-6 col-lg-4">
              <div class="panel bg-danger">
                <div class="panel-body">
                  <p class="icon">
                    <i class="icon fa fa-users"></i>
                  </p>
                  <h4 class="value">
                    <span>812</span></h4>
                  <p class="description">{{__('Donors')}}</p>
                </div>
              </div>
            </div>
          </div> --}}
          <div class="row">
            <div class="col-lg-4 col-sm-8 col-12 my-3 d-flex justify-content-center">
              <a class="is-menu-button is-btn-bg-red is-btn-sm-block text-center" href="{{route('donors.index')}}">{{__('Donors')}}<i class="fa fa-users mx-1" aria-hidden="true"></i></a>
            </div>
            <div class="col-lg-4 col-sm-8 col-12 my-3 d-flex justify-content-center">
              <a class="is-menu-button is-btn-bg-dark is-btn-sm-block text-center" href="{{route('admins.index')}}">{{__('Admins')}}<i class="fa fa-lock mx-1" aria-hidden="true"></i></a>
            </div>
            <div class="col-lg-4 col-sm-8 col-12 my-3 d-flex justify-content-center">
              <a class="is-menu-button is-btn-bg-red is-btn-sm-block text-center" href="{{route('bloodbanks.index')}}">{{__('Blood banks')}}<i class="fa fa-hospital-o mx-1" aria-hidden="true"></i></a>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-4 col-sm-8 col-12 my-3 d-flex justify-content-center">
              <a class="is-menu-button is-btn-bg-dark is-btn-sm-block text-center" href="{{route('campaigns.index')}}">{{__('Campaigns')}}<i class="fa fa-bullhorn mx-1" aria-hidden="true"></i></a>
            </div>
            <div class="col-lg-4 col-sm-8 col-12 my-3 d-flex justify-content-center">
              <a class="is-menu-button is-btn-bg-red is-btn-sm-block text-center" href="{{route('reports.index')}}">{{__('Log files')}}<i class="fa fa-file-excel-o mx-1" aria-hidden="true"></i></i></a>
            </div>
          </div>
        @else
            <div class="row">
              <div class="col-12 my-3 d-flex justify-content-center">
                <a class="is-menu-button is-btn-bg-red is-btn-sm-block text-center" href="{{route('donors.show',Auth::user()->load('donor')->donor->id)}}">{{__('See my profile')}}<i class="fa fa-eye mx-1" aria-hidden="true"></i></a>
              </div>
            </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection

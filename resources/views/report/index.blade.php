@extends('layouts.app')

@section('title',__('Log files'))

@section('stylesheets')
    <link rel="stylesheet" href="{{asset('css/elements/button.css')}}">
    <link rel="stylesheet" href="{{asset('css/elements/div.css')}}">
@endsection

@section('content')
  <div class="container">
    <div class="panel-heading">
      <h3>{{__('Log files')}}</h3>
    </div>
    <div class="row">
      <div class="col-12 col-lg-4 my-3 d-flex justify-content-center">
        <a class="is-panel-button is-btn-bg-red is-btn-sm-block text-center" href="{{route('reports.donors')}}">{{__('Donors')}} <i class="fa fa-users mx-1" aria-hidden="true"></i></a>
      </div>
      <div class="col-12 col-lg-4 my-3 d-flex justify-content-center">
        <a class="is-panel-button is-btn-bg-dark is-btn-sm-block text-center" href="{{route('reports.bloodbanks')}}">{{__('Blood banks')}} <i class="fa fa-hospital-o mx-1" aria-hidden="true"></i></a>
      </div>
      <div class="col-12 col-lg-4 my-3 d-flex justify-content-center">
        <a class="is-panel-button is-btn-bg-red is-btn-sm-block text-center" href="{{route('reports.donations')}}">{{__('Donations')}} <i class="fa fa-tint mx-1" aria-hidden="true"></i></a>
      </div>
    </div>
    <div class="row">
      <div class="col-12 col-lg-4 my-3 d-flex justify-content-center">
        <a class="is-panel-button is-btn-bg-dark is-btn-sm-block text-center" href="{{route('reports.campaigns')}}">{{__('Campaigns')}} <i class="fa fa-bullhorn mx-1" aria-hidden="true"></i></a>
      </div>
    </div>
  </div>
@endsection
@extends('layouts.app')

@section('title', __('Donors on campaign'))

@section('stylesheets')
  <link rel="stylesheet" href="{{asset('css/elements/div.css')}}">
  <link rel="stylesheet" href="{{asset('css/elements/label.css')}}">
  <link rel="stylesheet" href="{{asset('css/elements/paragrams.css')}}">
@endsection

@section('content')
  <div class="container">
    <div class="emp-profile">
      <h1 class="text-center">{{__('Campaign information')}}</h1>
      <div class="row text-center text-lg-left">
        <div class="col-6 col-lg-4">
          <label>{{__('Name')}}</label>
          <p>{{$campaign->name}}</p>
        </div>
        <div class="col-6 col-lg-4">
          <label>{{__('Place')}}</label>
          <p>{{$campaign->place}}</p>
        </div>
        <div class="col-12 col-lg-4">
          <label>{{__('Description')}}</label>
          <p>{{$campaign->description}}</p>
        </div>
      </div>
      <div class="row text-center text-lg-left">
        <div class="col-6 col-lg-3">
          <label>{{__('Date start')}}</label>
          <p>{{$campaign->date_start}}</p>
        </div>
        <div class="col-6 col-lg-3">
          <label>{{__('Time start')}}</label>
          <p>{{$campaign->time_start}}</p>
        </div>
        <div class="col-6 col-lg-3">
          <label>{{__('Date finish')}}</label>
          <p>{{$campaign->date_finish}}</p>
        </div>
        <div class="col-6 col-lg-3">
          <label>{{__('Time finish')}}</label>
          <p>{{$campaign->time_finish}}</p>
        </div>
      </div>
    </div>
    <label for="">
      {{__('Subscribed donors')}}: {{$donors->total()}}
    </label>
    <table-campaigns-donors-component  v-bind:campaigndonorsarray="{{  json_encode($donors) }}" campaignid="{{$campaign->id}}" v-bind:bloodtypes="{{json_encode($bloodTypes)}}" v-bind:gendertypes="{{json_encode($genderTypes)}}"></table-campaigns-donors-component>
    <div class="links-section">
      {{$donors->links()}}
    </div>   
  </div>
@endsection

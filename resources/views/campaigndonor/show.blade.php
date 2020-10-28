@extends('layouts.app')

@section('title',__('Get involved ❤️'))

@section('stylesheets')
  <link rel="stylesheet" href="{{asset('css/elements/button.css')}}">
  <link rel="stylesheet" href="{{asset('css/elements/label.css')}}">
  <link rel="stylesheet" href="{{asset('css/elements/paragrams.css')}}">
@endsection

@section('content')
  <div class="container mt-md-5">
    <div class="shadow p-5 mb-5 bg-white rounded">
      <h1 class="text-center">
        {{__('Hello!')}} {{Auth::user()->name}}
      </h1>
      <h2 class="text-center">{{__('Campaign information')}}</h2>
      <div class="row">
        <div class="col-12 col-lg-3">
          <img src="{{asset($campaign->campaign_image)}}" alt="Campaign image" class="img-fluid">
        </div>
        <div class="col-12 col-lg-9">
          <div class="row d-flex justify-content-center text-center">
            <div class="col-12 col-md-6">
              <label for="">{{__('Campaign')}}</label>
              <p>{{$campaign->name}}</p>
            </div>
            @if ($campaign->campaigntype == 'c1')
              <div class="col-12 col-md-6">
                <label for="">{{__('Place')}}</label>
                <p>{{$campaign->place}}</p>
              </div>
            @else
            <div class="col-12 col-md-6">
              <label for="">{{__('Place')}}</label>
              <p>{{$campaign->bloodbank->name}}</p>
            </div>
            @endif
          </div>
          <div class="row text-center">
            <div class="col-12">
              <label for="">{{__('Description')}}</label>
              <p>{{$campaign->description}}</p>
            </div>
          </div>
          <div class="row text-center">
            <div class="col-12 col-md-6">
              <label>{{__('Date time start')}}</label>
              <p>{{$campaign->date_start}} : {{$campaign->time_start}}</p>
            </div>
            <div class="col-12 col-md-6">
              <label>{{__('Date time finish')}}</label>
              <p>{{$campaign->date_finish}} : {{$campaign->time_finish}}</p>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <p class="text-center">Al dar clic en el botón 'involucrarse' se registrará en la campaña aquí mostrada</p>
            </div>
          </div>
        </div>
      </div>
      <form method="POST" action="{{route('campaigndonors.store')}}">
        @csrf
        <input type="hidden" name="donor" value="{{Auth::user()->id}}">
        <input type="hidden" name="campaign" value="{{$campaign->id}}">
        <div class="d-flex flex-row flex-wrap justify-content-lg-end justify-content-center">
          <button class="is-panel-button is-btn-bg-red mx-2 is-btn-sm-block text-center mb-1" type="submit">{{__('Get involved ❤️')}}</button>
          <a class="is-panel-button is-btn-bg-dark mx-2 is-btn-sm-block text-center mb-1" href="{{route('home')}}">{{__('I dont want to get involved 💔')}}</a>
        </div>
      </form>
    </div>
  </div>
@endsection
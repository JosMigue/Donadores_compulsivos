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
        {{__('Hello!')}} {{$donor->name}} {{$donor->last_name}}
      </h1>
      <h2 class="text-center">{{__('Campaign information')}}</h2>
      <div class="row d-flex justify-content-center text-center">
        <div class="col-12 col-md-6">
          <label for="">{{__('Campaign')}}</label>
          <p>{{$campaign->name}}</p>
        </div>
        <div class="col-12 col-md-6">
          <label for="">{{__('Place')}}</label>
          <p>{{$campaign->place}}</p>
        </div>
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
      <p class="text-center">Al dar clic en el botón 'involucrarse' se registrará en la campaña aquí mostrada</p>
      <form method="POST" action="{{route('campaigndonors.store')}}">
        @csrf
        <input type="hidden" name="donor" value="{{$donor->id}}">
        <input type="hidden" name="campaign" value="{{$campaign->id}}">
        <div class="d-flex flex-row flex-wrap justify-content-center">
          <button class="is-panel-button is-btn-bg-red mx-2" type="submit">{{__('Get involved ❤️')}}</button>
          <a class="is-panel-button is-btn-bg-dark mx-2" href="{{route('home')}}">{{__('I dont want to get involved 💔')}}</a>
        </div>
      </form>
    </div>
  </div>
@endsection
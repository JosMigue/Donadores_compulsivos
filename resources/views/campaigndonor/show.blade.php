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
      @if ($errors->any())
      <div class="container">
        <div class="alert alert-danger">
        <h3>{{__('Whoops!')}}, {{__('We found some mistakes')}}: </h3>
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      </div>
      @endif
      @if (Auth::check())
        <h1 class="text-center">
          {{__('Hello!')}} {{Auth::user()->name}}
        </h1>
      @endif
      @if (session('information'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
          <strong>{{session('information')}}</strong>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      @endif
      @if (session('errorMessage'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>{{session('errorMessage')}}</strong>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      @endif
      <h2 class="text-center">{{__('Campaign information')}}</h2>
      <div class="row">
        <div class="col-12 col-lg-3">
          <img src="{{asset($campaign->campaign_image)}}" alt="Campaign image" class="img-fluid">
        </div>
        <div class="col-12 col-lg-9">
          <div class="row d-flex justify-content-center text-center">
            <div class="col-12 col-md-6">
              <label for="">{{__('Campaign')}}</label>
              <p>{{__($campaign->name)}}</p>
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
        </div>
      </div>
      <div class="row d-flex justify-content-center">
        <h5 class="text-center">Horas disponibles</h5>
      </div>
      <form method="POST" action="{{route('campaigndonors.store')}}">
        @csrf
        <label for="time_turn">Por favor elija un horario <i class="fa fa-clock-o"></i>:</label>
        <div class="row d-flex align-content-center my-2">
          @foreach ($availableHours as $hour)
            @if ($hour['times'] < $campaign->frecuency)
              <div class="col-lg-1 col-4">
                <label class="btn btn-danger btn-sm">
                  <input type="radio" name="time_turn" value="{{$hour['time']}}" id="time_turn" autocomplete="off" required>
                  {{$hour['time']}}
                </label>
              </div>
            @endif
          @endforeach
        </div>
        <input type="hidden" name="donor" value="{{$donorAuth}}" required>
        <input type="hidden" name="campaign" value="{{$campaign->id}}" required>
        <div class="row my-2">
          <div class="col-12">
            <p class="text-center">{{__('By clicking on the "get involved" button you will be registered in the campaign shown here')}}</p>
          </div>
        </div>
        <div class="d-flex flex-row flex-wrap justify-content-lg-end justify-content-center">
          <button class="is-panel-button is-btn-bg-red mx-2 is-btn-sm-block text-center mb-1" type="submit">{{__('Get involved ❤️')}}</button>
          @if (Auth::check())
            <a class="is-panel-button is-btn-bg-dark mx-2 is-btn-sm-block text-center mb-1" href="{{route('home')}}">{{__('I dont want to get involved 💔')}}</a>
          @else
            <a class="is-panel-button is-btn-bg-dark mx-2 is-btn-sm-block text-center mb-1" href="/">{{__('I dont want to get involved 💔')}}</a>
          @endif
        </div>
      </form>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{asset('js/campaign.js')}}" defer></script>    
@endsection
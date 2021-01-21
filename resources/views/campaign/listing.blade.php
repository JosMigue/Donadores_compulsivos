@extends('layouts.guest')

@section('title', __('Campaign listing'))

@section('content')
  <div class="row no-gutters">
    @foreach ($campaigns as $campaign)
      <div class="col-lg-4 col-12 px-lg-4 px-1">
        <div class="card rounded">
          <img class="card-img-top" src="{{asset($campaign->campaign_image)}}" alt="Campaign image">
          <div class="card-body">
            <h4 class="card-title">{{__($campaign->name)}}</h4>
            <p class="card-text">{{$campaign->description}}</p>
            <div class="row justify-content-between my-2">
              <div class="col">
                <label for="">{{__('Date start')}}</label> <br>
                {{$campaign->date_start}} : {{$campaign->time_start}}
              </div>
              <div class="col">
                <label for="">{{__('Date finish')}}</label> <br>
                {{$campaign->date_finish}} : {{$campaign->time_finish}}
              </div>
            </div>
            @if ($campaign->campaigntype == 'c1')
              <div class="row justify-content-between my-2">
                <div class="col">
                  <label for="">{{__('Place')}}:</label> <br>
                  {{$campaign->place}}
                </div>
                <div class="col">
                  <label for="">{{__('City')}} {{__('State')}}:</label> <br>
                  {{$campaign->city->name}} / {{$campaign->state->name}}
                </div>
              </div>
            @else
              <div class="row justify-content-between my-2">
                <div class="col">
                  <label for="">{{__('Blood bank')}}:</label> <br>
                  {{$campaign->bloodbank->name}}
                </div>
                <div class="col">
                  <label for="">{{__('Address')}}:</label> <br>
                  {{$campaign->bloodbank->address}}, {{$campaign->bloodbank->city->name}}, {{$campaign->bloodbank->state->name}}
                </div>
              </div>
            @endif
          </div>
            @if ($campaign->date_start > \Carbon\Carbon::now())
              <a href="{{route('quiz', $campaign->id)}}" class="btn btn-danger">Quiero participar</a>  
            @else
              <a href="#" class="btn btn-danger disabled" type="submit">No disponible</a>  
            @endif
        </div>
      </div>
    @endforeach  
  </div>
@endsection
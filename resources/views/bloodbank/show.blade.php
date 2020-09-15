@extends('layouts.app')

@section('title',__('Show Blood bank'))

@section('stylesheets')
  <link rel="stylesheet" href="{{asset('css/elements/div.css')}}">
  <link rel="stylesheet" href="{{asset('css/elements/label.css')}}">
  <link rel="stylesheet" href="{{asset('css/elements/paragrams.css')}}">
@endsection

@section('content')
  <div class="container">
    <div class="emp-profile">
      <h1 class="text-center">{{__('Blood bank information')}}</h1>
      <div class="row text-center text-lg-left">
        <div class="col-6 col-lg-4">
          <label>{{__('Name')}}</label>
          <p>{{$bloodbank->name}}</p>
        </div>
        <div class="col-6 col-lg-4">
          <label>{{__('Address')}}</label>
          <p>{{$bloodbank->address}} {{$bloodbank->postal_code}}</p>  
        </div>
        <div class="col-6 col-lg-4">
          <label>{{__('Contact person')}}</label>
          <p>{{$bloodbank->contact_person}}</p>
        </div>
      </div>
      <div class="row text-center text-lg-left">
        <div class="col-6 col-lg-3">
          <label>{{__('Phone')}}</label>
          <p>{{$bloodbank->phone}}</p>
        </div>
        <div class="col-6 col-lg-3">
          <label>{{__('E-Mail Address')}}</label>
          <p>{{$bloodbank->email}}</p>
        </div>
        <div class="col-6 col-lg-3">
          <label>{{__('City')}}</label>
          <p>{{$bloodbank->city->name}}</p>
        </div>
        <div class="col-6 col-lg-3">
          <label>{{__('State')}}</label>
          <p>{{$bloodbank->state->name}}</p>
        </div>
      </div>
    </div> 
    <div class="row">
      @foreach ($businessDays as $businessDay)
          @foreach ($businessDay as $day => $hours)
            <div class="col-6 col-lg-4">
              <div class="card" style="width: 18rem;">
                <div class="card-body">
                  <h5 class="card-title">{{$day}}</h5>
                  <h6 class="card-subtitle mb-2 text-muted">Horario</h6>
                  @foreach ($hours as $index => $hour)
                    @if ($index%2 == 0)
                         {{$hour}}
                    @else
                         - {{$hour}} <br>
                    @endif
                  @endforeach
                </div>
              </div>
            </div>
          @endforeach
      @endforeach
    </div> 
  </div>
@endsection
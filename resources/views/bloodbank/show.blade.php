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
      <div class="d-flex justify-content-end">
        <a class="btn btn-primary" target="__blank" href="https://www.google.com.mx/maps/place/{{$bloodbank->state->name}}" >{{__('See on Google Maps')}} <i class="fa fa-google"></i></a>
      </div>
      <div class="row text-center text-lg-left">
        <div class="col-12 col-lg-6">
          <label>{{__('Name')}}</label>
          <p>{{$bloodbank->name}}</p>
        </div>
        <div class="col-12 col-lg-6">
          <label>{{__('Address')}}</label>
          <p>{{$bloodbank->address}} {{$bloodbank->postal_code}}</p>  
        </div>
      </div>
      <div class="row text-center text-lg-left">
        <div class="col-6">
          <label>{{__('Contact person')}}</label>
          <p><a href="tel:{{$bloodbank->contact_person}}">{{$bloodbank->contact_person}}</a></p>
        </div>
        <div class="col-6">
          <label>{{__('Contact person mobile')}}</label>
          <p>{{$bloodbank->contact_person_mobile}}</p>
        </div>
      </div>
      <div class="row text-center text-lg-left">
        <div class="col-6 col-lg-3">
          <label>{{__('Phone')}}</label>
          <p><a href="tel:{{$bloodbank->phone}}">{{$bloodbank->phone}}</a> @if ($bloodbank->extension_number) Ext.{{$bloodbank->extension_number}}  @endif </p>
        </div>
        <div class="col-6 col-lg-3">
          <label>{{__('E-Mail Address')}}</label>
          <p><a href="mailto:{{$bloodbank->email}}">{{$bloodbank->email}}</a></p>
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
      <div class="row">
        <div class="col-12">
        @if ($bloodbank->hyperlink)
          <div class="d-flex justify-content-end">
            <a class="btn btn-link" target="_blank" href="http://{{$bloodbank->hyperlink}}">{{__('Visit site')}} <i class="fa fa-link mx-1"></i></a>
          </div>
        @endif
        </div>
      </div>
    </div> 
    <h2>{{__('Bussiness hours')}}</h2>
    <div class="row">
      @foreach ($businessDays as $businessDay)
          @foreach ($businessDay as $day => $hours)
            <div class="col-12 col-lg-4">
              <div class="card">
                <div class="card-body text-center text-lg-left">
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
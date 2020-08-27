@extends('layouts.app')

@section('title', __('Donors on campaign'))

@section('stylesheets')
  <link rel="stylesheet" href="{{asset('css/elements/div.css')}}">
  <link rel="stylesheet" href="{{asset('css/elements/label.css')}}">
  <link rel="stylesheet" href="{{asset('css/elements/paragrams.css')}}">
@endsection

@section('content')
  <div class="container">
    <h1>{{__('Campaign')}}</h1>
    <div class="emp-profile">
      <div class="row text-center text-lg-left">
        <div class="col-12 col-lg-4">
          <label>{{__('Name')}}</label>
          <p>{{$campaign->name}}</p>
        </div>
        <div class="col-12 col-lg-4">
          <label>{{__('Place')}}</label>
          <p>{{$campaign->place}}</p>
        </div>
        <div class="col-12 col-lg-4">
          <label>{{__('Description')}}</label>
          <p>{{$campaign->description}}</p>
        </div>
      </div>
    </div>
    <label for="">
      {{__('Subscribed donors')}}: {{$donors->count()}}
    </label>
    <div class="table-responsive">
      <table class="table table-hover table-striped table-sm text-center">
        <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">{{__('Name')}}</th>
            <th scope="col">{{__('Address')}}</th>
            <th scope="col">{{__('Blood type')}}</th>
            <th scope="col">{{__('Gender')}}</th>
            <th scope="col">{{__('Phone')}}</th>
            <th scope="col">{{__('E-Mail Address')}}</th>
          </tr>
        </thead>
        <tbody>
          @if ($donors->count() > 0)
            @foreach ($donors as $index => $donor)
              <tr>
                <th scope="row">{{$index + 1}}</th>
                <td>{{__($donor->name)}}</td>
                <td>{{__($donor->address)}}</td>
                <td>{{__($donor->getEnum('bloodtypes')[$donor->bloodtype])}}</td>
                <td>{{__($donor->getEnum('gendertypes')[$donor->gendertype])}}</td>
                <td> <a class="d-lg-none d-block" href="tel:{{__($donor->mobile)}}">{{__($donor->mobile)}}</a> <div class="d-lg-block d-none">{{__($donor->mobile)}}</div></td>
                <td>{{__($donor->email)}}</td>
              </tr>
            @endforeach
          @else
              <tr>
                <th colspan="7">
                  {{__('There is not nothing to show')}}
                </th>
              </tr>
          @endif

        </tbody>
      </table>
    </div>
    <div class="links-section">
      {{$donors->links()}}
    </div>   
  </div>
@endsection
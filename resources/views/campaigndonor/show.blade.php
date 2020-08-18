@extends('layouts.app')

@section('title',__('Get involved ❤️'))

@section('stylesheets')
  <link rel="stylesheet" href="{{asset('css/elements/button.css')}}">
@endsection

@section('content')
  <div class="container">
    {{__('Hello!')}} {{$donor->name}} {{$donor->last_name}}
    <form action="{{route('campaigndonors.store')}}">
      <input type="hidden" name="donor" value="{{$donor->id}}">
      <input type="hidden" name="campaign" value="{{$campaign->id}}">
      <button class="is-panel-button is-btn-bg-red" type="submit">{{__('Get involved ❤️')}}</button>
    </form>
  </div>
@endsection
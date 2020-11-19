@extends('layouts.app')

@section('title', __('Donors'))

@section('stylesheets')
  <link rel="stylesheet" href="{{asset('css/elements/div.css')}}">
  <link rel="stylesheet" href="{{asset('css/elements/button.css')}}">
  <link rel="stylesheet" href="{{asset('css/elements/icon.css')}}">
  <link rel="stylesheet" href="{{asset('css/theme/autocomplete.css')}}">
  <link rel="stylesheet" href="{{asset('css/list-transition.css')}}">
@endsection

@section('content')
  <div class="container">
    @if (session('successMessage'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>{{session('successMessage')}}</strong>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    @endif
    @if (session('errorMessage'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{session('errorMessage')}}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endif
    <div class="panel-heading">
      <h3>{{__('Donors')}}</h3>
      <a class="is-panel-button is-btn-bg-red" href="{{route('donors.create')}}">{{__('Add')}}<i class="fa fa-plus mx-1"></i></a>
    </div>
      <filters-donors-component v-bind:donorsArray="{{  json_encode($donors) }}" v-bind:bloodtypes="{{  json_encode($bloodTypes) }}" v-bind:gendertypes="{{  json_encode($genderTypes) }}" v-bind:donortypes="{{  json_encode($donorTypes) }}" v-bind:cities="{{  json_encode($cities) }}" v-bind:states="{{  json_encode($states) }}"></filters-donors-component>
    <div class="">
      {{$donors->onEachSide(1)->links()}}
    </div> 
  </div>
@endsection

@section('scripts')
  <script src="{{asset('js/utils/sweetAlert.js')}}"></script>
  <script src="{{asset('js/donor.js')}}"></script>
@endsection
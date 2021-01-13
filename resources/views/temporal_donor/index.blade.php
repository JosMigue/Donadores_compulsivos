@extends('layouts.app')

@section('title', __('Pre donors'))
    
@section('content')
  <div class="container">
    <div class="panel-heading">
      <h3>{{__('Pre donor')}}</h3>
    </div>
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
    <datatable-temporal-donors-component v-bind:bloodtypes="{{  json_encode($bloodTypes) }}" :gendertypes="{{  json_encode($genderTypes) }}" :donortypes="{{  json_encode($donorTypes) }}" :cities="{{  json_encode($cities) }}" :states="{{  json_encode($states) }}"></datatable-temporal-donors-component>
  </div>
@endsection

@section('scripts')
  <script src="{{asset('js/utils/sweetAlert.js')}}"></script>
@endsection
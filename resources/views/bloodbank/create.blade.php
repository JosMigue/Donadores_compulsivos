@extends('layouts.app')

@section('title', __('Add Blood bank'))
    
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
    <div class="row d-flex justify-content-center">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">{{__('Add Blood bank')}}</h4>
        </div>
        <div class="card-body">
          <form action="{{route('bloodbanks.store')}}" method="POST">
            @csrf
            <div class="row my-1">
              <div class="col-md-4 pr-md-1">
                <label>{{__('Name')}}</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="{{__('Name')}}" value="{{old('name')}}">
              </div>
              <div class="col-md-4 px-md-1">
                <label>{{__('E-Mail Address')}}</label>
                <input type="text" id="email" name="email" class="form-control" placeholder="{{__('E-Mail Address')}}" value="{{old('email')}}">
              </div>
              <div class="col-md-4 pl-md-1">
                <label>{{__('Phone')}}</label>
                <input type="text" id="phone" name="phone" class="form-control" placeholder="{{__('Phone')}}" value="{{old('phone')}}">
              </div>
            </div>
            <div class="row">
              <div class="col-md-8 pr-md-1">
                <label>{{__('Address')}}</label>
                <input type="text" id="address" name="address" class="form-control" placeholder="{{__('Type your address here')}}" value="{{old('address')}}">
              </div>
              <div class="col-md-4 pl-md-1">
                <label>{{__('Postal Code')}}</label>
                <input type="string" id="postal_code" name="postal_code" class="form-control" placeholder="{{__('Postal code')}}" value="{{old('postal_code')}}">
              </div>
            </div>
            <div class="row my-1">
              <div class="col-md-6 pr-md-1">
                <label>{{__('State')}}</label>
                <select id="state_id" name="state_id" class="form-control" onchange="getAllCitiesState(this)">
                  <option value="" selected disabled>{{__('Select...')}}</option>
                  @foreach ($states as $state)
                    <option value="{{$state->id}}">{{$state->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6 pl-md-1">
                <label>{{__('City')}}</label>
                <select id="city_id" name="city_id" class="form-control">
                  <option value="">{{__('Select state first')}}</option>
                </select>
              </div>
            </div>
            <div class="text-right my-2">
              <a class="btn btn-danger btn-fill" href="{{route('bloodbanks.index')}}">{{__('Cancel')}}</a>                
              <button type="submit" class="btn btn-success btn-fill">{{__('Add')}}</button>
            </div>
            <input name="user_id" type="hidden" value="{{Auth::user()->id}}">
          </form>
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
        </div>
      </div>
    </div>
  </div> 
@endsection

@section('scripts')
  <script src="{{asset('js/getDataOptions.js')}}"></script>
@endsection
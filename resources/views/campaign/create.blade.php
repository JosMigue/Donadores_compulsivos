@extends('layouts.app')

@section('title', __('Add Campaign'))

@section('content')
  <div class="container">
    <div class="row d-flex justify-content-center">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">{{__('Add Campaign')}}</h4>
        </div>
        <div class="card-body">
          <form action="{{route('campaigns.store')}}" method="POST">
            @csrf
            <div class="row my-1">
              <div class="col-md-4 pr-md-1">
                <label>{{__('Name')}}</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="{{__('Name')}}" value="{{old('name')}}">
              </div>
              <div class="col-md-8 pl-md-1">
                <label>{{__('Place')}}</label>
                <input type="text" id="place" name="place" class="form-control" placeholder="{{__('Place')}}" value="{{old('last_name')}}">
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 pr-md-1">
                <label>{{__('State')}}</label>
                <select id="state_id" name="state_id" class="form-control" onchange="getAllCitiesState(this)">
                  <option value="" selected disabled>{{__('Select...')}}</option>
                  @foreach ($states as $key => $state)
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
            <div class="row my-1">
              <div class="col-md-3 pr-md-1">
                <label>{{__('Date start')}}</label>
                <input type="date" id="date_start" name="date_start" class="form-control" placeholder="{{__('Date start')}}" value="{{old('date_start')}}">
              </div>
              <div class="col-md-3 px-md-1">
                <label>{{__('Time start')}}</label>
                <input type="time" id="time_start" name="time_start" class="form-control" placeholder="{{__('Date finish')}}" value="{{old('time_start')}}">
              </div>
              <div class="col-md-3 px-md-1">
                <label>{{__('Date finish')}}</label>
                <input type="date" id="date_finish" name="date_finish" class="form-control" placeholder="{{__('Date finish')}}" value="{{old('date_finish')}}">
              </div>
              <div class="col-md-3 pl-md-1">
                <label>{{__('Time finish')}}</label>
                <input type="time" id="time_finish" name="time_finish" class="form-control" placeholder="{{__('Time finish')}}" value="{{old('time_finish')}}">
              </div>
            </div>
            <div class="row my-1">
              <div class="col-12">
                <label>{{__('Description')}}</label>
                <textarea class="form-control"  id="description" name="description" rows="5" cols="100" placeholder="{{__('Type your description here')}}"></textarea>
              </div>
            </div>
            <div class="text-right my-2">
              <a class="btn btn-danger btn-fill" href="{{route('campaigns.index')}}">{{__('Cancel')}}</a>
              <button type="submit" class="btn btn-success btn-fill">{{__('Add')}}</button>
            </div>
            <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
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
  <script src="{{asset('js/campaign.js')}}"></script>
  <script src="{{asset('js/getDataOptions.js')}}"></script>
@endsection
@extends('layouts.app')

@section('title', __('Edit campaign'))

@section('content')
  <div class="container">
    <div class="row d-flex justify-content-center">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">{{__('Edit campaign')}}</h4>
        </div>
        <div class="card-body">
          <form action="{{route('campaigns.update',$campaign->id)}}" method="POST">
            @csrf
            @method('PATCH')
            <div class="row my-1">
              <div class="col-12">
                <label for="">{{__('Campaign type')}}</label>
                <div class="d-flex flex-row">
                  @foreach ($campaignTypes as $index => $campaignType)
                    <div class="form-check mr-3">
                      <input class="form-check-input" type="radio" name="campaigntype" onchange="toggleBloodbanksSection(this)"  id="campaigntype" value="{{$index}}" @if ($index == $campaign->campaigntype) checked  @endif>
                      <label class="form-check-label" for="campaigntype">
                        {{$campaignType}}
                      </label>
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
            <div class="row my-1">
              <div class="col-md-4 pr-md-1">
                <label>{{__('Name')}}</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="{{__('Name')}}" value="{{$campaign->name}}">
              </div>
              <div class="col-md-8 pr-md-1 {{$campaign->campaigntype != 'c1' ?  'd-none' : 'd:block'}}" id="place_section">
                <label>{{__('Place')}}</label>
                <input type="text" id="place" name="place" class="form-control" placeholder="{{__('Place')}}" value="{{$campaign->place}}">
              </div> 
              <div class="col-md-8 {{$campaign->campaigntype != 'c2' ?  'd-none' : 'd:block'}}" id="blood_bank_section">
                <label for="blood_bank_id">{{__('Blood bank')}}</label>
                <select class="form-control" name="blood_bank_id" id="blood_bank_id">
                  <option value="" selected disabled>{{__('Select blood bank')}}</option>
                  @foreach ($bloodBanks as $bloodBank)
                    <option value="{{$bloodBank->id}}" @if ($campaign->bloodbank && $bloodBank->id == $campaign->bloodbank->id) selected @endif>{{$bloodBank->name}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 pr-md-1">
                <label>{{__('State')}}</label>
                <select id="state_id" name="state_id" class="form-control" onchange="getAllCitiesState(this)">
                  <option value="" selected disabled>{{__('Select...')}}</option>
                  @foreach ($states as $key => $state)
                    <option value="{{$state->id}}" @if ($state->id ==$campaign->state_id) selected="selected" @endif>{{$state->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6 pl-md-1">
                <label>{{__('City')}}</label>
                <select id="city_id" name="city_id" class="form-control">
                  @foreach ($cities as $city)
                    <option value="{{$city->id}}" @if ($city->id == $campaign->city_id) selected="selected" @endif>{{$city->name}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="row my-1">
              <div class="col-md-3 pr-md-1">
                <label>{{__('Date start')}}</label>
                <input type="date" id="date_start" name="date_start" class="form-control" placeholder="{{__('Date start')}}" value="{{$campaign->date_start}}">
              </div>
              <div class="col-md-3 px-md-1">
                <label>{{__('Time start')}}</label>
                <input type="time" id="time_start" name="time_start" class="form-control" placeholder="{{__('Date finish')}}" value="{{$campaign->time_start}}">
              </div>
              <div class="col-md-3 px-md-1">
                <label>{{__('Date finish')}}</label>
                <input type="date" id="date_finish" name="date_finish" class="form-control" placeholder="{{__('Date finish')}}" value="{{$campaign->date_finish}}">
              </div>
              <div class="col-md-3 pl-md-1">
                <label>{{__('Time finish')}}</label>
                <input type="time" id="time_finish" name="time_finish" class="form-control" placeholder="{{__('Time finish')}}" value="{{$campaign->time_finish}}">
              </div>
            </div>
            <div class="row my-1">
              <div class="col-12">
                <label>{{__('Description')}}</label>
              <textarea class="form-control"  id="description" name="description" rows="5" cols="100" placeholder="{{__('Type your description here')}}">{{$campaign->description}}</textarea>
              </div>
            </div>
            <div class="text-right my-2">
              <a class="btn btn-danger btn-fill" href="{{route('campaigns.index')}}">{{__('Cancel')}}</a>
              <button type="submit" class="btn btn-success btn-fill">{{__('Update')}}</button>
            </div>
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
@extends('layouts.app')

@section('title', __('Add Campaign'))

@section('stylesheets')
  <link rel="stylesheet" href="{{asset('css/elements/div.css')}}">
@endsection

@section('content')
  <div class="container">
    <div class="row d-flex justify-content-center">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">{{__('Add Campaign')}}</h4>
        </div>
        <div class="card-body" >
          <form action="{{route('campaigns.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row my-1">
              <div class="col-12">
                <label for="">{{__('Campaign type')}}</label>
                <div class="d-flex flex-row">
                  @foreach ($campaignTypes as $index => $campaignType)
                    <div class="form-check mr-3">
                      <input class="form-check-input" type="radio" name="campaigntype" onchange="toggleBloodbanksSection(this)"  id="campaigntype" value="{{$index}}" @if ($index == 'c1') checked  @endif>
                      <label class="form-check-label" for="campaigntype">
                        {{$campaignType}}
                      </label>
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
            <div class="row my-1">
              <div class="col-md-4 pr-md-1" >
                <label>{{__('Name')}}</label>
                {{-- <input class="form-control" type="text" id="name" name="name" class="form-control" placeholder="{{__('Name')}}" value="{{old('name')}}"> --}}
                <select name="name" id="name" class="form-control" required>
                  <option value="" selected disabled>{{__('Select...')}}</option>
                  <option value="Donating love" @if(old('name')=='Donating love') selected @endif>{{__('Donating love')}}</option>
                  <option value="Donors students" @if(old('name')=='Donors students') selected @endif>{{__('Donors students')}}</option>
                  <option value="Donors workers" @if(old('name')=='Donors workers') selected @endif>{{__('Donors workers')}}</option>
                </select>
              </div>
              <div class="col-md-8 pr-md-1" id="place_section">
                <label>{{__('Place')}}</label>
                <input type="text" id="place" name="place" class="form-control" placeholder="{{__('Place')}}" value="{{old('place')}}">
              </div>
              <div class="col-md-8 d-none" id="blood_bank_section">
                <label for="blood_bank_id">{{__('Blood bank')}}</label>
                <select class="form-control" onchange="getBloodBankLocationInfo(this)" name="blood_bank_id" id="blood_bank_id">
                  <option value="" selected disabled>{{__('Select blood bank')}}</option>
                  @foreach ($bloodBanks as $bloodBank)
                    <option value="{{$bloodBank->id}}" data-city-name="{{$bloodBank->city->name}}" data-city-id="{{$bloodBank->city->id}}" data-state-name="{{$bloodBank->state->name}}" data-state-id="{{$bloodBank->state->id}}">{{$bloodBank->name}}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 pr-md-1">
                <label>{{__('State')}}</label>
                <select id="state_id" name="state_id" class="form-control" onchange="getAllCitiesState(this)" required>
                  <option value="" selected disabled>{{__('Select...')}}</option>
                  @foreach ($states as $key => $state)
                    <option value="{{$state->id}}">{{$state->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6 pl-md-1">
                <label>{{__('City')}}</label>
                <select id="city_id" name="city_id" class="form-control" required>
                  <option value="">{{__('Select state first')}}</option>
                </select>
              </div>
            </div>
            <div class="row my-1">
              <div class="col-md-3 pr-md-1">
                <label>{{__('Date start')}}</label>
                <input type="date" id="date_start" name="date_start" class="form-control" placeholder="{{__('Date start')}}" value="{{old('date_start')}}" min="{{date("Y")}}-01-01" max="{{date("Y")}}-12-31" required>
              </div>
              <div class="col-md-3 px-md-1">
                <label>{{__('Time start')}}</label>
                <input type="time" id="time_start" name="time_start" class="form-control" placeholder="{{__('Time start')}}" value="{{old('time_start')}}" required>
              </div>
              <div class="col-md-3 px-md-1">
                <label>{{__('Date finish')}}</label>
                <input type="date" id="date_finish" name="date_finish" class="form-control" placeholder="{{__('Date finish')}}" value="{{old('date_finish')}}" min="{{date("Y")}}-01-01" max="{{date("Y")}}-12-31" required>
              </div>
              <div class="col-md-3 pl-md-1">
                <label>{{__('Time finish')}}</label>
                <input type="time" id="time_finish" name="time_finish" class="form-control" placeholder="{{__('Time finish')}}" value="{{old('time_finish')}}" required>
              </div>
            </div>
            <div class="row my-1">
              <div class="col-12">
                <label>{{__('Description')}}</label>
                <textarea class="form-control"  id="description" name="description" rows="5" cols="100" placeholder="{{__('Type your description here')}}"></textarea>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <label for="campaign_image">{{__('Campaign picture')}}</label>
                <input class="form-control" type="file" name="campaign_image" id="campaign_image">
              </div>
            </div>
            <div id="frecuency-section my-1">
              <div class="row d-flex flex-column align-content-center">                
                <p class="text-center">{{__('Checkin frecuency')}}</p>
                <p class="text-dark text-center">{{__('If you don\'t type something in the next fields by default frequency will be one persons each 10 minutes')}}</p>
              </div>
              <div class="row">
                <div class="col-lg-6 col-12">
                  <label for="frecuency">{{__('Frecuency by donors')}}</label>
                  <input type="number" name="frecuency" id="frecuency" step="1" class="form-control">
                </div>
                <div class="col-lg-6 col-12">
                  <label for="frecuency_time">{{__('Frecuency time')}}</label>
                  <input type="number" name="frecuency_time" id="frecuency_time" step="1" class="form-control">
                </div>
              </div>
            </div>
            <div class="d-flex justify-content-center">
              <button class="btn btn-link" type="button" onclick="toggleFilters()">{{__('Would you like to add filter?')}} <i class="fa fa-filter mx-1" aria-hidden="true"></i></button>
            </div>
            <div id="filter-section" class="toggleable-content">
              <div class="row" >
                <div class="col-12">
                  <label>{{__('By State')}}</label>
                  <select id="state_id_filter" name="state_id_filter" class="form-control">
                    <option value="" selected disabled>{{__('Select...')}}</option>
                    @foreach ($states as $key => $state)
                      <option value="{{$state->id}}">{{$state->name}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <label>{{__('By Blood Type')}}</label>
                </div>
              </div>
              <div class="row">
                @foreach ($bloodTypes as $key => $bloodtype)
                  <div class="col">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="{{$key}}" id="blood_type_filter" name="blood_type_filter[]">
                      <label class="form-check-label" for="defaultCheck1">
                        {{$bloodtype}}
                      </label>
                    </div>
                  </div>
                @endforeach
              </div>
              <div class="row">
                <div class="col-12 d-flex justify-content-end">
                  <button class="btn btn-info btn-sm" type="button" onclick="showHelp()"> <i class="fa fa-question-circle" aria-hidden="true"></i></button>
                </div>
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
  <script src="{{asset('js/campaign.js')}}" defer></script>
  <script src="{{asset('js/getDataOptions.js')}}" defer></script>
@endsection
@extends('layouts.app')

@section('title', __('Donors on campaign'))

@section('stylesheets')
  <link rel="stylesheet" href="{{asset('css/elements/div.css')}}">
  <link rel="stylesheet" href="{{asset('css/elements/label.css')}}">
  <link rel="stylesheet" href="{{asset('css/elements/button.css')}}">
  <link rel="stylesheet" href="{{asset('css/elements/paragrams.css')}}">
  <link rel="stylesheet" href="{{asset('css/theme/profile.css')}}">
@endsection

@section('content')
  <div class="container">
    <div class="emp-profile">
      <h1 class="text-center">{{__('Campaign information')}}</h1>
      <div class="row">
        <div class="col-12 col-lg-4">
          <div class="profile-img" id="profile-img">
            <img src="{{asset($campaign->campaign_image)}}" alt="Campaign image">
            <div class="file btn btn-lg btn-primary">
              {{__('Change Photo')}}
              <form method="POST" action="{{route('campaigns.upload', $campaign->id)}}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <input type="file" id="campaign_image" name="campaign_image" onchange="updateCampaignImage()">
                <div class="toggleable-button" id="toggleable-button">
                  <button class="btn btn-success " type="submit">{{__('Upload')}}</button>
                  <button class="btn btn-danger" onclick="updateCampaignImage()" type="button">{{__('Cancel')}}</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-12 col-lg-8">
          <div class="row text-center text-lg-left mt-2">
            <div class="col-6 col-lg-4">
              <label>{{__('Name')}}</label>
              <p>{{$campaign->name}}</p>
            </div>
            <div class="col-6 col-lg-4">
              <label>{{__('Place')}}</label>
              @if ($campaign->campaigntype == 'c1')
                <p>{{$campaign->place}}</p>  
              @else
                <p>{{$campaign->bloodbank->name}}</p>  
              @endif
            </div>
            <div class="col-12 col-lg-4">
              <label>{{__('Description')}}</label>
              <p>{{$campaign->description}}</p>
            </div>
          </div>
          <div class="row text-center text-lg-left">
            <div class="col-6 col-lg-3">
              <label>{{__('Date start')}}</label>
              <p>{{$campaign->date_start}}</p>
            </div>
            <div class="col-6 col-lg-3">
              <label>{{__('Time start')}}</label>
              <p>{{$campaign->time_start}}</p>
            </div>
            <div class="col-6 col-lg-3">
              <label>{{__('Date finish')}}</label>
              <p>{{$campaign->date_finish}}</p>
            </div>
            <div class="col-6 col-lg-3">
              <label>{{__('Time finish')}}</label>
              <p>{{$campaign->time_finish}}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <label for="">
      {{__('Subscribed donors')}}: {{$donors->total()}}
    </label>
    <table-campaigns-donors-component  v-bind:campaigndonorsarray="{{  json_encode($donors) }}" campaignid="{{$campaign->id}}" v-bind:bloodtypes="{{json_encode($bloodTypes)}}" v-bind:gendertypes="{{json_encode($genderTypes)}}"></table-campaigns-donors-component>
    <div class="links-section">
      {{$donors->links()}}
    </div>   
  </div>
@endsection

@section('scripts')
  <script src="{{asset('js/campaign.js')}}"></script>
  <script src="{{asset('js/utils/sweetAlert.js')}}"></script>
@endsection

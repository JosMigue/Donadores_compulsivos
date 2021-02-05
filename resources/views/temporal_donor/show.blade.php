@extends('layouts.app')

@section('title', __('Show pre donor'))

@section('stylesheets')
<link rel="stylesheet" href="{{asset('css/theme/profile.css')}}">
<link rel="stylesheet" href="{{asset('css/elements/button.css')}}">
<link rel="stylesheet" href="{{asset('css/elements/label.css')}}">
@endsection

@section('content')
<div class="container emp-profile">
  @if (session('successMessage'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>{{session('successMessage')}}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif   
  @if (session('errorMessage'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>{{session('errorMessage')}}</strong>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  @endif  
  <div class="row">
    <div class="col-12 col-md-4">
      <div class="profile-img" id="profile-img">
        <img class="rounded" src="{{asset($temporalDonor->profile_picture)}}" alt="Profile picture for donor"/>
        <div class="file btn btn-lg btn-primary">
          {{__('Change Photo')}}
          <form method="POST" action="{{route('temporal_donors.upload', $temporalDonor->id)}}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <input type="file" name="profile_picture" onchange="updateProfilePicture()">
            <div class="toggleable-button" id="toggleable-button">
              <button class="btn btn-success " type="submit">{{__('Upload')}}</button>
              <button class="btn btn-danger" onclick="updateProfilePicture()" type="button">{{__('Cancel')}}</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-8">
      <div class="profile-head">
        <h5>
          {{$temporalDonor->name}} {{$temporalDonor->parental_surname}} {{$temporalDonor->maternal_surname}}
        </h5>
        <div class="d-flex justify-content-between">
          <h6>
            @if ($temporalDonor->first_time_donating)
              {{__('First time being donor')}}  
            @else
              {{__('Donor')}}  
            @endif
          </h6>
          @if (Auth::user()->is_admin)
            <h6>{{__('Pre identifier')}}: {{$temporalDonor->id}}</h6>
          @endif
        </div>
        @if (Auth::user()->is_admin)
          <div class="d-flex justify-content-between">
            <h6>
              @if ($temporalDonor->be_the_match)
                {{__('Be The Match')}}  <i class="fa fa-check text-success"></i>
              @else
              {{__('Be The Match')}}  <i class="fa fa-times text-danger"></i>
              @endif
            </h6>
            <h6>
              @if ($temporalDonor->letter)
                {{__('Letter')}}  <i class="fa fa-check text-success"></i>
              @else
                {{__('Letter')}}  <i class="fa fa-times text-danger"></i>
              @endif
            </h6>
          </div>
        @endif
        <div class="row d-flex justify-content-lg-end justify-content-center">
          <a class="is-panel-button is-btn-bg-red mx-2" href="{{route('temporal_donors.edit',$temporalDonor->id)}}">{{__('Edit')}}</a>
          <a class="is-panel-button is-btn-bg-dark mx-2" href="{{route('temporal_donors.index')}}" >{{__('Get back')}}</a>
        </div>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link is-red active" id="information" data-toggle="tab" href="#information-tab" role="tab" aria-controls="information" aria-selected="true" >{{__('Information')}}</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <div class="tab-content profile-tab" id="myTabContent">
    <div class="tab-pane fade show active" id="information-tab" role="tabpanel" aria-labelledby="information">
      <div class="row">
        <div class="col-12 col-md-4 mb-2">
          <p class="text-center">{{__('Get in touch')}}</p>
          <div class="profile-work d-flex flex-column justify-content-around">
            <a href="tel:{{$temporalDonor->mobile}}"><i class="fa fa-phone mx-1" aria-hidden="true"></i>{{$temporalDonor->mobile}}</a><br/>
            <a href="mailto:{{$temporalDonor->email}}"><i class="fa fa-envelope mx-1" aria-hidden="true"></i>{{$temporalDonor->email}}</a><br/>
          </div>
        </div>
        <div class="col-12 col-md-8">
          <div class="row">
            <div class="col-12 col-md-3">
              <label>{{__('Full name')}}</label>
              <p>{{$temporalDonor->name}} {{$temporalDonor->parental_surname}} {{$temporalDonor->maternal_surname}}</p>
            </div>
            <div class="col-12 col-md-4">
              <label>{{__('E-Mail Address')}}</label>
              <p>{{$temporalDonor->email}}</p>
            </div>
            <div class="col-12 col-md-2">
              <label>{{__('Phone')}}</label>
              <p>{{$temporalDonor->mobile}}</p>
            </div>
            <div class="col-12 col-md-3">
              <label>{{__('CURP')}}</label>
              <p>{{$temporalDonor->curp}}</p>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-md-3">
              <label>{{__('Predonor type')}}</label>
              <p>{{$temporalDonor->getEnum('donortype')[$temporalDonor->donortype]}}</p>
            </div>
            <div class="col-12 col-md-3">
              <label>{{__('City')}}</label>
              <p>{{$temporalDonor->city->name}}</p>
            </div>
            <div class="col-12 col-md-3">
              <label>{{__('State')}}</label>
              <p>{{$temporalDonor->state->name}}</p>
            </div>
            <div class="col-12 col-md-3">
              <label>{{__('Born date')}}</label>
              <p>{{$temporalDonor->born_date}}</p>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-md-4">
              <label>{{__('Age')}}</label>
              <p>{{$temporalDonor->age}}</p>
            </div>
            <div class="col-12 col-md-4">
              <label>{{__('Sing up date')}}</label>
              <p>{{$temporalDonor->created_at}}</p>
            </div>
            <div class="col-12 col-md-4">
              <label>{{__('Blood type')}}</label>
              <p>{{$temporalDonor->getEnum('bloodtype')[$temporalDonor->bloodtype]}}</p>
            </div>
          </div>
          <div class="row">
            <div class="col-6 col-md-6">
              <label>{{__('Gender')}}</label>
              @if ($temporalDonor->gendertype)
                <p>{{$temporalDonor->getEnum('gendertype')[$temporalDonor->gendertype]}}</p>
              @else
                <p>No se especifica</p>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
    <script src="{{asset('js/donor.js')}}"></script>
@endsection
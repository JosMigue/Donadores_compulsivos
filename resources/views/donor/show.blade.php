@extends('layouts.app')

@section('title', __('Show donor'))

@section('stylesheets')
  <link rel="stylesheet" href="{{asset('css/theme/profile.css')}}">
  <link rel="stylesheet" href="{{asset('css/elements/button.css')}}">
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
    <div class="row">
      <div class="col-12 col-md-4">
        <div class="profile-img" id="profile-img">
          <img src="{{asset($donor->profile_picture)}}" alt="Profile picture for donor"/>
          <div class="file btn btn-lg btn-primary">
            {{__('Change Photo')}}
            <form method="POST" action="{{route('donors.upload', $donor->id)}}" enctype="multipart/form-data">
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
      <div class="col-12 col-md-6">
        <div class="profile-head">
          <h5>
            {{$donor->name}} {{$donor->parental_surname}} {{$donor->maternal_surname}}
          </h5>
          <h6>
            {{__('Donor')}}
          </h6>
          <div class="d-flex justify-content-around">
            <p class="proile-rating">{{__('Donations')}} <i class="fa fa-heart mx-1" aria-hidden="true"></i>: <span>{{$numberOfDonations}}</span></p>
            <p class="proile-rating">{{__('Campaigns')}} <i class="fa fa-bullhorn mx-1" aria-hidden="true"></i>: <span>{{$campaigns->count()}}</span></p>
          </div>
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link is-red" id="information" data-toggle="tab" href="#information-tab" role="tab" aria-controls="information" aria-selected="true"  onClick="saveTabSelect(this)">{{__('Information')}}</a>
            </li>
            <li class="nav-item">
              <a class="nav-link is-red" id="campaigns" data-toggle="tab" href="#campaigns-tab" role="tab" aria-controls="campaigns" aria-selected="false" onClick="saveTabSelect(this)">{{__('Campaigns history')}}</a>
            </li>
          </ul>
        </div>
      </div>
      <div class="col-12 col-md-2 my-4 text-center text-lg-right">
        <a class="is-panel-button is-btn-bg-red" href="{{route('donors.edit',$donor->id)}}">{{__('Edit')}}</a>
        <a class="is-panel-button is-btn-bg-dark" href="{{route('donors.index')}}" >{{__('Get back')}}</a>
      </div>
    </div>
    <div class="row">
      <div class="col-12 col-md-4 mb-2">
        <p class="text-center">{{__('Get in touch')}}</p>
        <div class="profile-work d-flex justify-content-around">
          <a href="tel:{{$donor->mobile}}"><i class="fa fa-phone" aria-hidden="true"></i>{{$donor->mobile}}</a><br/>
          <a href="mailto:{{$donor->email}}"><i class="fa fa-envelope" aria-hidden="true"></i>{{$donor->email}}</a><br/>
        </div>
      </div>
      <div class="col-12 col-md-8">
        <div class="tab-content profile-tab" id="myTabContent">
          <div class="tab-pane fade show" id="information-tab" role="tabpanel" aria-labelledby="information">
            <div class="row">
              <div class="col-12 col-md-4">
                <label>{{__('Full name')}}</label>
                <p>{{$donor->name}} {{$donor->parental_surname}} {{$donor->maternal_surname}}</p>
              </div>
              <div class="col-12 col-md-4">
                <label>{{__('E-Mail Address')}}</label>
                <p>{{$donor->email}}</p>
              </div>
              <div class="col-12 col-md-4">
                <label>{{__('Mobile')}}</label>
                <p>{{$donor->mobile}}</p>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-4">
                <label>{{__('Address')}}</label>
                <p>{{$donor->address}} {{$donor->postal_code}}</p>
              </div>
              <div class="col-12 col-md-4">
                <label>{{__('City')}}</label>
                <p>{{$donor->city->name}}</p>
              </div>
              <div class="col-12 col-md-4">
                <label>{{__('State')}}</label>
                <p>{{$donor->state->name}}</p>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-4">
                <label>{{__('Born date')}}</label>
                <p>{{$donor->born_date}}</p>
              </div>
              <div class="col-12 col-md-4">
                <label>{{__('Age')}}</label>
                <p>{{$donor->age}}</p>
              </div>
              <div class="col-12 col-md-4">
                <label>{{__('Sing up date')}}</label>
                <p>{{$donor->created_at}}</p>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-3">
                <label>{{__('Weight')}}</label>
                <p>{{$donor->weight}}</p>
              </div>
              <div class="col-12 col-md-3">
                <label>{{__('Height')}}</label>
                <p>{{$donor->height}}</p>
              </div>
              <div class="col-12 col-md-3">
                <label>{{__('Blood type')}}</label>
                <p>{{$donor->getEnum('bloodtype')[$donor->bloodtype]}}</p>
              </div>
              <div class="col-12 col-md-3">
                <label>{{__('Gender')}}</label>
                <p>{{$donor->getEnum('gendertype')[$donor->gendertype]}}</p>
              </div>
            </div>
          </div>
          <div class="tab-pane fade show" id="campaigns-tab" role="tabpanel" aria-labelledby="campaigns">
            <div class="row">
              <div class="col">
                <i class="fa fa-check text-success"></i> <span>Asistió</span>
                <br>
                <i class="fa fa-times text-danger"></i> <span>No Asistió</span>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-hover table-striped table-sm">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">{{__('Name')}}</th>
                    <th scope="col">{{__('Place')}}</th>
                    <th scope="col">{{__('Date time start')}}</th>
                    <th scope="col">{{__('Date time finish')}}</th>
                    <th scope="col">{{__('Status')}}</th>
                    <th scope="col">{{__('Donation date')}}</th>
                    <th scope="col">{{__('Registration date')}}</th>
                  </tr>
                </thead>
                <tbody>
                  @if($campaigns->count() > 0)
                    @foreach ($campaigns as $index => $campaign)
                      <tr>
                        <th scope="row">{{$index+1}}</th>
                        <td>{{$campaign->name}}</td>
                        <td>{{$campaign->place}}</td>
                        <td>{{$campaign->date_start}} {{$campaign->time_start}}</td>
                        <td>{{$campaign->date_finish}} {{$campaign->time_finish}}</td>
                        <td>
                          @if ($campaign->pivot->donor_donated)
                            <i class="fa fa-check text-success" aria-hidden="true"></i>
                          @else
                            <i class="fa fa-times text-danger" aria-hidden="true"></i>
                          @endif
                        </td>
                        <td>{{$campaign->pivot->donation_date}}</td>
                        <td>{{$campaign->pivot->created_at}}</td>
                      </tr>
                    @endforeach
                  @else
                      <tr>
                        <td class="text-center" colspan="6">{{__('There is not nothing to show')}}</td>
                      </tr>
                  @endif
                </tbody>
              </table>
            </div>
            {{$campaigns->links()}}
          </div>
        </div>
      </div>
    </div>  
  </div>
@endsection

@section('scripts')
    <script src="{{asset('js/donor.js')}}"></script>
    <script src="{{asset('js/utils/sweetAlert.js')}}"></script>
@endsection
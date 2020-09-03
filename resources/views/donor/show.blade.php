@extends('layouts.app')

@section('title', __('Show donor'))

@section('stylesheets')
  <link rel="stylesheet" href="{{asset('css/theme/profile.css')}}">
  <link rel="stylesheet" href="{{asset('css/elements/button.css')}}">
@endsection

@section('content')
  <div class="container emp-profile">    
    <div class="row">
      <div class="col-12 col-md-4">
        <div class="profile-img">
          <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS52y5aInsxSm31CvHOFHWujqUx_wWTS9iM6s7BAm21oEN_RiGoog" alt=""/>
          <div class="file btn btn-lg btn-primary">
            {{__('Change Photo')}}
            <input type="file" name="profile_picture"/>
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
            <p class="proile-rating">{{__('Donations')}} <i class="fa fa-heart mx-1" aria-hidden="true"></i>: <span>#</span></p>
            <p class="proile-rating">{{__('Campaigns')}} <i class="fa fa-bullhorn mx-1" aria-hidden="true"></i>: <span>{{$campaigns->count()}}</span></p>
          </div>
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active is-red" id="information-tab" data-toggle="tab" href="#information" role="tab" aria-controls="information" aria-selected="true">{{__('Information')}}</a>
            </li>
            <li class="nav-item">
              <a class="nav-link is-red" id="campaigns-tab" data-toggle="tab" href="#campaigns" role="tab" aria-controls="campaigns" aria-selected="false">{{__('Campaigns history')}}</a>
            </li>
            <li class="nav-item">
              <a class="nav-link is-red" id="donations-tab" data-toggle="tab" href="#donations" role="tab" aria-controls="donations" aria-selected="false">{{__('Donations history')}}</a>
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
          <div class="tab-pane fade show active" id="information" role="tabpanel" aria-labelledby="information-tab">
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
          <div class="tab-pane fade" id="campaigns" role="tabpanel" aria-labelledby="campaigns-tab">
            <div class="table-responsive">
              <table class="table table-hover table-striped table-sm">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">{{__('Name')}}</th>
                    <th scope="col">{{__('Place')}}</th>
                    <th scope="col">{{__('Date time start')}}</th>
                    <th scope="col">{{__('Date time finish')}}</th>
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
          </div>
          <div class="tab-pane fade" id="donations" role="tabpanel" aria-labelledby="donations-tab">
            <div class="table-responsive">
              
            </div>
          </div>
        </div>
      </div>
    </div>  
  </div>
@endsection
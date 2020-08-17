@extends('layouts.app')

@section('title', __('Show donor'))

@section('stylesheets')
  <link rel="stylesheet" href="{{asset('css/theme/profile.css')}}">
  <link rel="stylesheet" href="{{asset('css/elements/button.css')}}">
@endsection

@section('content')
  <div class="container emp-profile">
    <form method="post">
      <div class="row">
        <div class="col-md-4">
          <div class="profile-img">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS52y5aInsxSm31CvHOFHWujqUx_wWTS9iM6s7BAm21oEN_RiGoog" alt=""/>
            <div class="file btn btn-lg btn-primary">
              {{__('Change Photo')}}
              <input type="file" name="file"/>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="profile-head">
            <h5>
              {{$donor->name}} {{$donor->last_name}}
            </h5>
            <h6>
              {{__('Donor')}}
            </h6>
            <p class="proile-rating">{{__('Donations')}} : <span>#</span></p>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active is-red" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">{{__('Information')}}</a>
              </li>
              <li class="nav-item">
                <a class="nav-link is-red" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">{{__('Campaigns history')}}</a>
              </li>
            </ul>
          </div>
        </div>
        <div class="col-md-2">
          <a class="is-panel-button is-btn-bg-red" href="{{route('donors.edit',$donor->id)}}">{{__('Edit')}}</a>
          <a class="is-panel-button is-btn-bg-dark" href="{{route('donors.index')}}" >{{__('Get back')}}</a>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="profile-work">
            <p>{{__('Get in touch')}}</p>
            <a href="tel:{{$donor->mobile}}"><i class="fa fa-phone mx-1" aria-hidden="true"></i>{{$donor->mobile}}</a><br/>
            <a href="mailto:{{$donor->email}}"><i class="fa fa-envelope mx-1" aria-hidden="true"></i>{{$donor->email}}</a><br/>
          </div>
        </div>
        <div class="col-md-8">
          <div class="tab-content profile-tab" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
              <div class="row">
                <div class="col-6 col-md-4">
                  <label>{{__('Full name')}}</label>
                  <p>{{$donor->name}} {{$donor->last_name}}</p>
                </div>
                <div class="col-6 col-md-4">
                  <label>{{__('E-Mail Address')}}</label>
                  <p>{{$donor->email}}</p>
                </div>
                <div class="col-6 col-md-4">
                  <label>{{__('Mobile')}}</label>
                  <p>{{$donor->mobile}}</p>
                </div>
              </div>
              <div class="row">
                <div class="col-6 col-md-4">
                  <label>{{__('Address')}}</label>
                  <p>{{$donor->address}} {{$donor->postal_code}}</p>
                </div>
                <div class="col-6 col-md-4">
                  <label>{{__('City')}}</label>
                  <p>{{$donor->city->name}}</p>
                </div>
                <div class="col-6 col-md-4">
                  <label>{{__('State')}}</label>
                  <p>{{$donor->state->name}}</p>
                </div>
              </div>
              <div class="row">
                <div class="col-6 col-md-4">
                  <label>{{__('Born date')}}</label>
                  <p>{{$donor->born_date}}</p>
                </div>
                <div class="col-6 col-md-4">
                  <label>{{__('Age')}}</label>
                  <p>{{$donor->age}}</p>
                </div>
                <div class="col-6 col-md-4">
                  <label>{{__('Sing up date')}}</label>
                  <p>{{$donor->created_at}}</p>
                </div>
              </div>
              <div class="row">
                <div class="col-6 col-md-3">
                  <label>{{__('Weight')}}</label>
                  <p>{{$donor->weight}}</p>
                </div>
                <div class="col-6 col-md-3">
                  <label>{{__('Height')}}</label>
                  <p>{{$donor->height}}</p>
                </div>
                <div class="col-6 col-md-3">
                  <label>{{__('Blood type')}}</label>
                  <p>{{$donor->getEnum('bloodtype')[$donor->bloodtype]}}</p>
                </div>
                <div class="col-6 col-md-3">
                  <label>{{__('Gender')}}</label>
                  <p>{{$donor->getEnum('gendertype')[$donor->gendertype]}}</p>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
              <div class="row">
                <table class="table table-hover table-striped table-sm">
                  <thead class="thead-dark">
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">{{__('Name')}}</th>
                      <th scope="col">{{__('Place')}}</th>
                      <th scope="col">{{__('Description')}}</th>
                      <th scope="col">{{__('Date time start')}}</th>
                      <th scope="col">{{__('Date time finish')}}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($campaigns as $index => $campaign)
                      <tr>
                        <th scope="row">{{$index+1}}</th>
                        <td>{{$campaign->name}}</td>
                        <td>{{$campaign->place}}</td>
                        <td>{{$campaign->description}}</td>
                        <td>{{$campaign->date_start}} {{$campaign->time_start}}</td>
                        <td>{{$campaign->date_finish}} {{$campaign->time_finish}}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>           
  </div>
@endsection
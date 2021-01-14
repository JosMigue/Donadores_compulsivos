@extends('layouts.app')

@section('title', __('Update Blood bank'))
    
@section('content')
  <div class="container">
    <div class="row d-flex justify-content-center">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">{{__('Update Blood bank')}}</h4>
        </div>
        <div class="card-body">
          <form action="{{route('bloodbanks.update', $bloodbank->id)}}" method="POST">
            @csrf
            @method('PATCH')
            <div class="row my-1">
              <div class="col-md-6 pr-md-1">
                <label>{{__('Name')}}</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="{{__('Name')}}" value="{{$bloodbank->name}}">
              </div>
              <div class="col-md-6 pl-md-1">
                <label>{{__('E-Mail Address')}}</label>
                <input type="text" id="email" name="email" class="form-control" placeholder="{{__('E-Mail Address')}}" value="{{$bloodbank->email}}">
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-1 pr-md-1">
                <label>Ext.</label>
                <input type="text" class="form-control" name="extension_number" id="extension_number" value="{{$bloodbank->extension_number}}">
              </div>
              <div class="col-12 col-md-3 px-md-1">
                <label>{{__('Phone')}}</label>
                <input type="text" id="phone" name="phone" class="form-control" min="10" max="10" placeholder="{{__('Phone')}}" value="{{$bloodbank->phone}}" required>
              </div>
              <div class="col-md-4 px-md-1">
                <label>{{__('Contact person')}}</label>
                <input type="text" id="contact_person" name="contact_person" class="form-control" value="{{$bloodbank->contact_person}}">
              </div>
              <div class="col-md-4 pl-md-1">
                <label>{{__('Contact person mobile')}}</label>
                <input type="string" id="contact_person_mobile" name="contact_person_mobile" class="form-control" placeholder="{{__('Postal code')}}" value="{{$bloodbank->contact_person_mobile}}">
              </div>
            </div>
            <div class="row">
              <div class="col-md-8 pr-md-1">
                <label>{{__('Address')}}</label>
                <input type="text" id="address" name="address" class="form-control" placeholder="{{__('Type your address here')}}" value="{{$bloodbank->address}}">
              </div>
              <div class="col-md-4 pl-md-1">
                <label>{{__('Postal Code')}}</label>
                <input type="string" id="postal_code" name="postal_code" class="form-control" placeholder="{{__('Postal code')}}" value="{{$bloodbank->postal_code}}">
              </div>
            </div>
            <div class="row my-1">
              <div class="col-md-6 pr-md-1">
                <label>{{__('State')}}</label>
                <select id="state_id" name="state_id" class="form-control" onchange="getAllCitiesState(this)">
                  @foreach ($states as $state)
                    <option value="{{$state->id}}"@if ($state->id == $bloodbank->state_id) selected="selected" @endif>{{$state->name}}</option>
                  @endforeach
                </select>
            </div>
            <div class="col-md-6 pl-md-1">
                <label>{{__('City')}}</label>
                <select id="city_id" name="city_id" class="form-control">
                    @foreach ($cities as $city)
                      <option value="{{$city->id}}" @if ($city->id == $bloodbank->city_id) selected="selected" @endif>{{$city->name}}</option>
                    @endforeach
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <label for="hyperlink">{{__('Hyperlink')}}</label>
                <input class="form-control" type="text" name="hyperlink" id="hyperlink" value="{{ old('hyperlink') ? old('hyperlink'):$bloodbank->hyperlink}}">
              </div>
            </div>
            <div class="row">
              <div class="col-12 d-flex justify-content-end">
                <button class="btn btn-info btn-sm" type="button" onclick="showInfoMessage()"> <i class="fa fa-question-circle" aria-hidden="true"></i></button>
              </div>
            </div>
            <dayofweek-component v-bind:businessdays="{{  json_encode($days) }}"></dayofweek-component>
            <div class="text-right my-2">
              <a class="btn btn-danger btn-fill" href="{{route('bloodbanks.index')}}">{{__('Cancel')}}</a>                
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
  <script src="{{asset('js/getDataOptions.js')}}"></script>
  <script src="{{asset('js/bloodBank.js')}}"></script>
@endsection
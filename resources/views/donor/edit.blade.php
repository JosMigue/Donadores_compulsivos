@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row d-flex justify-content-center">
      <div class="card">
        <div class="card-header">
          @if (Auth::user()->is_admin)
            <h4 class="card-title">{{__('Update donor')}}</h4>
          @else
          <h4 class="card-title">{{__('Edit profile')}}</h4>
          @endif
        </div>
        <div class="card-body">
          <form action="{{route('donors.update', $donor->id)}}" method="POST">
            @csrf
            @method('PATCH')
            <div class="row my-1">
              <div class="col-12 col-md-4 pr-md-1">
                <label>{{__('Name')}}</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="{{__('Name')}}" value="{{$donor->name}}">
              </div>
              <div class="col-12 col-md-4 px-md-1">
                <label>{{__('Parental Surname')}}</label>
                <input type="text" id="parental_surname" name="parental_surname" class="form-control" placeholder="{{__('Parental Surname')}}" value="{{$donor->parental_surname}}">
              </div>
              <div class="col-12 col-md-4 pl-md-1">
                <label>{{__('Maternal Surname')}}</label>
                <input type="text" id="maternal_surname" name="maternal_surname" class="form-control" placeholder="{{__('Maternal Surname')}}" value="{{$donor->maternal_surname}}">
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6 pr-md-1">
                <div class="form-group">
                  <label>{{__('Blood type')}}</label>
                  <select class="form-control" name="bloodtype" id="bloodtype">
                    @foreach ($bloodTypes as $key => $bloodtype)
                      <option @if ($donor->bloodtype == $key) selected @endif value="{{$key}}">{{$bloodtype}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-12 col-md-6 pl-md-1">
                <div class="form-group">
                  <label>{{__('Donor type')}}</label>
                  <select class="form-control" name="donortype" id="donortype">
                    @foreach ($donorTypes as $key => $donorType)
                      <option @if ($donor->donortype == $key) selected @endif value="{{$key}}">{{$donorType}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-8 pr-md-1">
                <label>{{__('Address')}}</label>
                <input type="text" id="address" name="address" class="form-control" placeholder="{{__('Type your address here')}}" value="{{$donor->address}}">
              </div>
              <div class="col-12 col-md-4 pl-md-1">
                <label>{{__('State')}}</label>
                <select type="text" id="state_id" name="state_id" class="form-control"  onchange="getAllCitiesState(this)">
                  @foreach ($states as $state)
                    <option value="{{$state->id}}" @if ($donor->state_id == $state->id) selected='selected' @endif>{{$state->name}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="row my-1">
              <div class="col-md-4 pr-md-1">
                <label>{{__('City')}}</label>
                <select type="text" id="city_id" name="city_id" class="form-control" placeholder="{{__('City')}}">
                  @foreach ($cities as $city)
                    <option @if ($city->id == $donor->city_id) selected='selected' @endif value="{{$city->id}}">{{$city->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-4 px-md-1">
                <label>{{__('Postal Code')}}</label>
                <input type="number" id="postal_code" name="postal_code" class="form-control" placeholder="{{__('Postal code')}}" value="{{$donor->postal_code}}">
              </div>
              <div class="col-md-4 pl-md-1">
                <label>{{__('Born date')}}</label>
                <input type="date" onchange="calculateAge(this)" id="born_date" name="born_date" class="form-control" value="{{$donor->born_date}}">
              </div>
            </div>
            <div class="row my-1">
              <div class="col-12 col-md-4 pr-md-1">
                <label>{{__('E-Mail Address')}}</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="{{__('E-Mail Address')}}" value="{{$donor->email}}">
              </div>
              <div class="col-12 col-md-4 px-md-1">
                <label>{{__('Mobile')}}</label>
                <input type="tel" id="mobile" name="mobile" class="form-control" placeholder="{{__('Mobile')}}" value="{{$donor->mobile}}">
              </div>
              <div class="col-12 col-md-4 pl-md-1">
                <label>{{__('Weight')}}</label>
                <input class="form-control" type="number" id="weight" name="weight" step="any" value="{{$donor->weight}}">
              </div>
            </div>
            <div class="row my-1">
              <div class="col-6 col-md-5 pr-md-1">
                <label>{{__('Height')}}</label>
                <input class="form-control" type="number" id="height" name="height" step="any" value="{{$donor->height}}">
              </div>
              <div class="col-6 col-md-2 px-md-1">
                <label>{{__('Age')}}</label>
                <input type="text" id="age" name="age" class="form-control" readonly placeholder="{{__('Age')}}" value="{{$donor->age}}">
              </div>
              <div class="col-6 col-md-5 pl-md-1">
                <label>{{__('Gender')}}</label>
                <select id="gendertype" name="gendertype" class="form-control">
                  <option value="" disabled selected> {{__('Select...')}}</option>
                  @foreach ($genderTypes as $key => $genderType)
                    <option @if ($donor->gendertype == $key) selected @endif value="{{$key}}">{{$genderType}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            @if (Auth::user()->is_admin)
              <div class="row">
                <div class="col-12">
                  <label for="observations">{{__('Observations')}}</label>
                  <textarea class="form-control" name="observations" id="observations" cols="30" rows="5">{{$donor->observations}}</textarea>
                </div>
              </div>
            @endif
            <div class="text-right my-2">
              <a class="btn btn-danger btn-fill" href="{{route('donors.index')}}">{{__('Cancel')}}</a>
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
  <script src="{{asset('js/donor.js')}}"></script>
  <script src="{{asset('js/getDataOptions.js')}}"></script>
@endsection
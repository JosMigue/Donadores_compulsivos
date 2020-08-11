@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row d-flex justify-content-center">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">{{__('Update donor')}}</h4>
        </div>
        <div class="card-body">
          <form action="{{route('donors.update', $donor->id)}}" method="POST">
            @csrf
            @method('PATCH')
            <div class="row my-1">
              <div class="col-md-4 pr-md-1">
                <label>{{__('Name')}}</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="{{__('Name')}}" value="{{$donor->name}}">
              </div>
              <div class="col-md-4 px-md-1">
                <label>{{__('Last Name')}}</label>
                <input type="text" id="last_name" name="last_name" class="form-control" placeholder="{{__('Last Name')}}" value="{{$donor->last_name}}">
              </div>
              <div class="col-md-4 pl-md-1">
                <div class="form-group">
                  <label>{{__('Blood type')}}</label>
                  <select class="form-control" name="bloodtype" id="bloodtype">
                    @foreach ($bloodTypes as $key => $bloodtype)
                      <option @if ($donor->bloodtype == $key) selected @endif value="{{$key}}">{{$bloodtype}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <label>{{__('Address')}}</label>
                <input type="text" id="address" name="address" class="form-control" placeholder="{{__('Type your address here')}}" value="{{$donor->address}}">
              </div>
            </div>
            <div class="row my-1">
              <div class="col-md-4 pr-md-1">
                <label>{{__('State')}}</label>
                <select type="text" id="state_id" name="state_id" class="form-control"  onchange="getAllCitiesState(this)">
                  @foreach ($states as $state)
                    <option value="{{$state->id}}" @if ($donor->state_id == $state->id) selected='selected' @endif>{{$state->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-4 px-md-1">
                <label>{{__('City')}}</label>
                <select type="text" id="city_id" name="city_id" class="form-control" placeholder="{{__('City')}}">
                  @foreach ($cities as $city)
                    <option @if ($city->id == $donor->city_id) selected='selected' @endif value="{{$city->id}}">{{$city->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-4 pl-md-1">
                <label>{{__('Postal Code')}}</label>
                <input type="number" id="postal_code" name="postal_code" class="form-control" placeholder="{{__('Postal code')}}" value="{{$donor->postal_code}}">
              </div>
            </div>
            <div class="row my-1">
              <div class="col-md-4 pr-md-1">
                <label>{{__('Born date')}}</label>
                <input type="date" onchange="calculateAge(this)" id="born_date" name="born_date" class="form-control" value="{{$donor->born_date}}">
              </div>
              <div class="col-md-4 pl-md-1">
                <label>{{__('E-Mail Address')}}</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="{{__('E-Mail Address')}}" value="{{$donor->email}}">
              </div>
              <div class="col-md-4 pl-md-1">
                <label>{{__('Mobile')}}</label>
                <input type="tel" id="mobile" name="mobile" class="form-control" placeholder="{{__('Mobile')}}" value="{{$donor->mobile}}">
              </div>
            </div>
            <div class="row my-1">
              <div class="col-6 col-md-4 pr-md-1">
                <label>{{__('Weight')}}</label>
                <input class="form-control" type="number" id="weight" name="weight" step="any" value="{{$donor->weight}}">
              </div>
              <div class="col-6 col-md-4 px-md-1">
                <label>{{__('Height')}}</label>
                <input class="form-control" type="number" id="height" name="height" step="any" value="{{$donor->height}}">
              </div>
              <div class="col-6 col-md-1 px-md-1">
                <label>{{__('Age')}}</label>
                <input type="text" id="age" name="age" class="form-control" readonly placeholder="{{__('Age')}}" value="{{$donor->age}}">
              </div>
              <div class="col-6 col-md-3 pl-md-1">
                <label>{{__('Gender')}}</label>
                <select id="gendertype" name="gendertype" class="form-control">
                  <option value="" disabled selected> {{__('Select...')}}</option>
                  @foreach ($genderTypes as $key => $genderType)
                    <option @if ($donor->gendertype == $key) selected @endif value="{{$key}}">{{$genderType}}</option>
                  @endforeach
                </select>
              </div>
            </div>
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
  <script src="{{asset('js/getDataOptions.js')}}"></script>
@endsection
@extends('layouts.app')

@section('title', __('Add donor'))

@section('content')
  <div class="container">
    @if (session('successMessage'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{session('successMessage')}}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endif
    @if (session('errorMessage'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{session('errorMessage')}}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endif
    <div class="row d-flex justify-content-center">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">{{__('Add donor')}}</h4>
        </div>
        <div class="card-body">
          <form action="{{route('donors.store')}}" method="POST">
            @csrf
            <div class="row my-1">
              <div class="col-md-4 pr-md-1">
                <label>{{__('Name')}}</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="{{__('Name')}}" value="{{old('name')}}">
              </div>
              <div class="col-md-4 px-md-1">
                <label>{{__('Last Name')}}</label>
                <input type="text" id="last_name" name="last_name" class="form-control" placeholder="{{__('Last Name')}}" value="{{old('last_name')}}">
              </div>
              <div class="col-md-4 pl-md-1">
                <div class="form-group">
                  <label>{{__('Blood type')}}</label>
                  <select class="form-control" name="bloodtype" id="bloodtype">
                    <option value="" selected disabled>{{__('Select...')}}</option>
                    @foreach ($bloodTypes as $key => $bloodtype)
                      <option @if (old('bloodtype')==$key) selected @endif value="{{$key}}">{{$bloodtype}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <label>{{__('Address')}}</label>
                <input type="text" id="address" name="address" class="form-control" placeholder="{{__('Type your address here')}}" value="{{old('address')}}">
              </div>
            </div>
            <div class="row my-1">
              <div class="col-md-4 pr-md-1">
                <label>{{__('State')}}</label>
                <select id="state_id" name="state_id" class="form-control" onchange="getAllCitiesState(this)">
                  <option value="" selected disabled>{{__('Select...')}}</option>
                  @foreach ($states as $state)
                    <option value="{{$state->id}}">{{$state->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-4 px-md-1">
                <label>{{__('City')}}</label>
                <select id="city_id" name="city_id" class="form-control">
                  <option value="">{{__('Select state first')}}</option>
                </select>
              </div>
              <div class="col-md-4 pl-md-1">
                <label>{{__('Postal Code')}}</label>
                <input type="number" id="postal_code" name="postal_code" class="form-control" placeholder="{{__('Postal code')}}" value="{{old('postal_code')}}">
              </div>
            </div>
            <div class="row my-1">
              <div class="col-md-4 pr-md-1">
                <label>{{__('Born date')}}</label>
                <input type="date" onchange="calculateAge(this)" id="born_date" name="born_date" class="form-control" value="{{old('born_date')}}">
              </div>
              <div class="col-md-4 pl-md-1">
                <label>{{__('E-Mail Address')}}</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="{{__('E-Mail Address')}}" value="{{old('email')}}">
              </div>
              <div class="col-md-4 pl-md-1">
                <label>{{__('Mobile')}}</label>
                <input type="tel" id="mobile" name="mobile" class="form-control" placeholder="{{__('Mobile')}}" value="{{old('mobile')}}">
              </div>
            </div>
            <div class="row my-1">
              <div class="col-6 col-md-4 pr-md-1">
                <label>{{__('Weight')}}</label>
                <input class="form-control" type="number" id="weight" name="weight" step="any" value="{{old('weight')}}">
              </div>
              <div class="col-6 col-md-4 px-md-1">
                <label>{{__('Height')}}</label>
                <input class="form-control" type="number" id="height" name="height" step="any" value="{{old('height')}}">
              </div>
              <div class="col-6 col-md-1 px-md-1">
                <label>{{__('Age')}}</label>
                <input type="text" id="age" name="age" class="form-control" readonly placeholder="{{__('Age')}}" value="{{old('age')}}">
              </div>
              <div class="col-6 col-md-3 pl-md-1">
                <label>{{__('Gender')}}</label>
                <select id="gendertype" name="gendertype" class="form-control">
                  <option value="" disabled selected> {{__('Select...')}}</option>
                  @foreach ($genderTypes as $key => $genderType)
                    <option @if (old('gendertype')==$key) selected @endif value="{{$key}}">{{$genderType}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="text-right my-2">
              <a class="btn btn-danger btn-fill" href="{{route('donors.index')}}">{{__('Cancel')}}</a>
              <button type="submit" class="btn btn-success btn-fill">{{__('Add')}}</button>
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
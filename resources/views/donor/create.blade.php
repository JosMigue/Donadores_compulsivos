@extends('layouts.app')

@section('title', __('Add donor'))

@section('content')
  <div class="container">
    <div class="row d-flex justify-content-center">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">{{__('Add donor')}}</h4>
        </div>
        <div class="card-body">
          <form>
            <div class="row">
              <div class="col-md-4 pr-md-1">
                <label>{{__('Name')}}</label>
                <input type="text" class="form-control" placeholder="{{__('Name')}}">
              </div>
              <div class="col-md-4 px-md-1">
                <label>{{__('Last Name')}}</label>
                <input type="text" class="form-control" placeholder="{{__('Last Name')}}">
              </div>
              <div class="col-md-4 pl-md-1">
                <div class="form-group">
                  <label>{{__('Blood type')}}</label>
                  <select class="form-control" name="bloodtype" id="bloodtype">
                    <option value="" selected disabled>{{__('Select...')}}</option>
                    @foreach ($bloodTypes as $key => $bloodtype)
                      <option value="{{$key}}">{{$bloodtype}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <label>{{__('Address')}}</label>
                <input type="text" class="form-control" placeholder="{{__('Type your address here')}}">
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 pr-md-1">
                <label>{{__('City')}}</label>
                <input type="text" class="form-control" placeholder="{{__('City')}}">
              </div>
              <div class="col-md-4 px-md-1">
                <label>{{__('State')}}</label>
                <input type="text" class="form-control" placeholder="{{__('State')}}">
              </div>
              <div class="col-md-4 pl-md-1">
                <label>{{__('Postal Code')}}</label>
                <input type="number" class="form-control" placeholder="ZIP Code">
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 pr-md-1">
                <label>{{__('Born date')}}</label>
                <input type="date" onchange="calculateAge(this)" id="born_date" name="born_date" class="form-control">
              </div>
              <div class="col-md-6 pl-md-1">
                <label>{{__('E-Mail Address')}}</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="{{__('E-Mail Address')}}">
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 pr-md-1">
                <label>{{__('Weight')}}</label>
                <input class="form-control" type="number" id="weight" name="weight">
              </div>
              <div class="col-md-4 px-md-1">
                <label>{{__('Age')}}</label>
                <input type="text" id="age" name="age" disabled class="form-control" placeholder="{{__('Age')}}">
              </div>
              <div class="col-md-4 pl-md-1">
                <label>{{__('Height')}}</label>
                <input class="form-control" type="number" id="height" name="height" >
              </div>
            </div>
            <div class="text-right my-2">
              <a class="btn btn-danger btn-fill" href="{{route('donors.index')}}">{{__('Cancel')}}</a>
              <button type="submit" class="btn btn-success btn-fill">{{__('Add')}}</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>    
@endsection

@section('scripts')
  <script src="{{asset('js/donor.js')}}"></script>
@endsection
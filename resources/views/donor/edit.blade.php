@extends('layouts.app')

@if (Auth::user()->is_admin)
  @section('title',__('Update donor'))  
@else
  @section('title',__('Edit profile')) 
@endif

@section('content')
  <div class="container">
    <div class="row d-flex justify-content-center">
      <div class="card"  style="width: 60rem">
        <div class="card-header">
          @if (Auth::user()->is_admin)
            <h4 class="card-title">{{__('Update donor')}}</h4>
          @else
            <h4 class="card-title">{{__('Edit profile')}}</h4>
          @endif
        </div>
        <div class="card-body">
          <div class="row m-1">
            <p>{{__('Required fields')}} <span class="text-danger">*</span></p>
          </div>
          <form action="{{route('donors.update', $donor->id)}}" method="POST">
            @csrf
            @method('PATCH')
            <div class="row my-1">
              <div class="col-12 col-md-4 pr-md-1">
                <label>{{__('Name')}} <span class="text-danger text-sm">*</span></label>
                <input type="text" id="name" name="name" class="form-control" placeholder="{{__('Name')}}" value="{{$donor->name}}">
              </div>
              <div class="col-12 col-md-4 px-md-1">
                <label>{{__('Parental Surname')}} <span class="text-danger text-sm">*</span></label>
                <input type="text" id="parental_surname" name="parental_surname" class="form-control" placeholder="{{__('Parental Surname')}}" value="{{$donor->parental_surname}}">
              </div>
              <div class="col-12 col-md-4 pl-md-1">
                <label>{{__('Maternal Surname')}} </label>
                <input type="text" id="maternal_surname" name="maternal_surname" class="form-control" placeholder="{{__('Maternal Surname')}}" value="{{$donor->maternal_surname}}">
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-4 pr-md-1">
                <div class="form-group">
                  <label>CURP <span class="text-danger text-sm">*</span></label>
                  <input class="form-control" maxlength="18" type="text" id="curp" name="curp" value="{{$donor->curp}}" placeholder="Ingrese su curp">
                </div>
              </div>
              <div class="col-12 col-md-4 px-md-1">
                <div class="form-group">
                  <label>{{__('Blood type')}} <span class="text-danger text-sm">*</span></label>
                  <select class="form-control" name="bloodtype" id="bloodtype">
                    @foreach ($bloodTypes as $key => $bloodtype)
                      <option @if ($donor->bloodtype == $key) selected @endif value="{{$key}}">{{$bloodtype}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-12 col-md-4 pl-md-1">
                <div class="form-group">
                  <label>{{__('Donor type')}} <span class="text-danger text-sm">*</span></label>
                  <select class="form-control" name="donortype" id="donortype">
                    @foreach ($donorTypes as $key => $donorType)
                      <option @if ($donor->donortype == $key) selected @endif value="{{$key}}">{{$donorType}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-4 pr-md-1">
                <label>{{__('State')}} <span class="text-danger text-sm">*</span></label>
                <select type="text" id="state_id" name="state_id" class="form-control"  onchange="getAllCitiesState(this)">
                  @foreach ($states as $state)
                    <option value="{{$state->id}}" @if ($donor->state_id == $state->id) selected='selected' @endif>{{$state->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-4 px-md-1">
                <label>{{__('City')}} <span class="text-danger text-sm">*</span></label>
                <select type="text" id="city_id" name="city_id" class="form-control" placeholder="{{__('City')}}">
                  @foreach ($cities as $city)
                    <option @if ($city->id == $donor->city_id) selected='selected' @endif value="{{$city->id}}">{{$city->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-4 pl-md-1">
                <label>{{__('Born date')}} <span class="text-danger text-sm">*</span></label>
                <input type="date" onchange="calculateAge(this)" id="born_date" name="born_date" class="form-control" value="{{$donor->born_date}}">
              </div>
            </div>
            <div class="row my-1">
              <div class="col-12 col-md-6 pr-md-1">
                <label>{{__('E-Mail Address')}}</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="{{__('E-Mail Address')}}" value="{{$donor->email}}">
              </div>
              <div class="col-12 col-md-6 pl-md-1">
                <label>{{__('Mobile')}}</label>
                <input type="tel" id="mobile" name="mobile" class="form-control" placeholder="{{__('Mobile')}}" value="{{$donor->mobile}}">
              </div>
            </div>
            <div class="row my-1">
              <div class="col-6 col-md-4 pr-md-1">
                <label>{{__('Age')}} <span class="text-danger text-sm">*</span></label>
                <input type="text" id="age" name="age" class="form-control" readonly placeholder="{{__('Age')}}" value="{{$donor->age}}">
              </div>
              <div class="col-6 col-md-8 pl-md-1">
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
            <div class="row my-4">
              <div class="col-12">
                <camera-driver-component></camera-driver-component>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-4 col-12">
                <div class="form-check">
                  <input type="hidden" value="0" name="first_time_donating">
                  <input class="form-check-input" value="1" type="checkbox" @if($donor->first_time_donating == 1) checked @endif name="first_time_donating">
                  <label class="form-check-label" for="first_time_donating">
                    {{__('I have already donated before')}}
                  </label>
                </div>
              </div>
              <div class="col-lg-4 col-12">
                <div class="form-check">
                  <input type="hidden" value="0" name="be_the_match">
                  <input class="form-check-input" value="1" type="checkbox" @if($donor->be_the_match == 1) checked @endif name="be_the_match">
                  <label class="form-check-label" for="be_the_match">
                    Be The Match
                  </label>
                </div>
              </div>
              <div class="col-lg-4 col-12">
                <div class="form-check">
                  <input type="hidden" value="0" name="letter">
                  <input class="form-check-input" value="1" type="checkbox" @if($donor->letter == 1) checked @endif name="letter">
                  <label class="form-check-label" for="letter">
                    {{__('Letter')}}
                  </label>
                </div>
              </div>
            </div>
            <div class="text-right my-2">
              <a class="btn btn-danger btn-fill" href="{{ url()->previous() }}">{{__('Cancel')}}</a>
              <button type="submit" class="btn btn-success btn-fill">{{__('Update')}}</button>
            </div>
          </form>
          @if (Auth::user()->is_admin)
            <p class="text-danger">ADVERTENCIA: Tenga mucho cuidado al momento de quitar un correo al usuario, en caso de hacerlo el usuario perderá el acceso al sistema por completo. JLMarketing se libra de toda responsabilidad al momento de que un administrador proceda con lo antes mencionado. ESTA ACCIÓN NO SE PUEDE CORREGIR.</p>
          @endif
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
  <script src="{{asset('js/utils/sweetAlert.js')}}"></script>
@endsection
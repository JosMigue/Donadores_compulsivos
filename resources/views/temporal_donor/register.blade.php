@extends('layouts.app')

@section('title', __('Sign Up'))

@section('content')
  <div class="container">
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
          <h4 class="card-title">{{__('Register as pre donor')}}</h4>  
        </div>
        <div class="card-body">
          <div class="row m-1">
            <p>{{__('Required fields')}} <span class="text-danger">*</span></p>
          </div>
          <form action="{{route('temporal_donors.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row my-1">
              <div class="col-12 col-md-4 pr-md-1">
                <label>{{__('Name')}} <span class="text-danger text-sm">*</span></label>
                <input type="text" id="name" name="name" autofocus="true" class="form-control" placeholder="{{__('Name')}}" value="{{old('name')}}" required>
              </div>
              <div class="col-12 col-md-4 px-md-1">
                <label>{{__('Parental Surname')}} <span class="text-danger text-sm">*</span></label>
                <input type="text" id="parental_surname" name="parental_surname" class="form-control" placeholder="{{__('Parental Surname')}}" value="{{old('parental_surname')}}" required>
              </div>
              <div class="col-12 col-md-4 pl-md-1">
                <label>{{__('Maternal Surname')}}</label>
                <input type="text" id="maternal_surname" name="maternal_surname" class="form-control" placeholder="{{__('Maternal Surname')}}" value="{{old('maternal_surname')}}" required>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-4 pr-md-1">
                <label>CURP <span class="text-danger text-sm">*</span></label>
                <input type="text" maxlength="18" class="form-control" id="curp" name="curp" placeholder="Ingrese su curp" value="{{old('curp')}}">
              </div>
              <div class="col-12 col-md-4 px-md-1">
                <label>{{__('Blood type')}} <span class="text-danger text-sm">*</span></label>
                <select class="form-control" name="bloodtype" id="bloodtype" required>
                  <option value="" selected disabled>{{__('Select...')}}</option>
                  @foreach ($bloodTypes as $key => $bloodtype)
                    <option @if (old('bloodtype')==$key) selected @endif value="{{$key}}">{{$bloodtype}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-12 col-md-4 pl-md-1">
                <label>{{__('Donor type')}} <span class="text-danger text-sm">*</span></label>
                <select class="form-control" name="donortype" id="donortype" required>
                  <option value="" selected disabled>{{__('Select...')}}</option>
                  @foreach ($donorTypes as $key => $donortype)
                    <option @if (old('donortype')==$key) selected @endif value="{{$key}}">{{$donortype}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 pr-md-1">
                <label>{{__('State')}} <span class="text-danger text-sm">*</span></label>
                <select id="state_id" name="state_id" class="form-control" onchange="getAllCitiesState(this)" required>
                  <option value="" selected disabled>{{__('Select...')}}</option>
                  @foreach ($states as $state)
                    <option value="{{$state->id}}">{{$state->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-12 col-md-4 px-md-1">
                <label>{{__('City')}} <span class="text-danger text-sm">*</span></label>
                <select id="city_id" name="city_id" class="form-control" required>
                  <option value="">{{__('Select state first')}}</option>
                </select>
              </div>
              <div class="col-12 col-md-4 pl-md-1">
                <label>{{__('Born date')}} <span class="text-danger text-sm">*</span></label>
                <input type="date" onchange="calculateAge(this)" id="born_date" name="born_date" class="form-control" value="{{old('born_date')}}" required>
              </div>
            </div>
            <div class="row my-1">
              <div class="col-12 col-md-4 pr-md-1">
                <label>{{__('E-Mail Address')}}</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="{{__('E-Mail Address')}}" value="{{old('email')}}" >
              </div>
              <div class="col-12 col-md-4 px-md-1">
                <label>{{__('Mobile')}} <span class="text-danger text-sm">*</span></label>
                <input type="tel" id="mobile" name="mobile" class="form-control" placeholder="{{__('Mobile')}}" value="{{old('mobile')}}">
              </div>
              <div class="col-6 col-md-4 pl-md-1">
                <label>{{__('Age')}} <span class="text-danger text-sm">*</span></label>
                <input type="text" id="age" name="age" class="form-control" readonly placeholder="{{__('Age')}}" value="{{old('age')}}" required >
              </div>
            </div>
            <div class="row my-1">
              <div class="col-6 col-md-4 pr-md-1">
                <label>{{__('Gender')}} <span class="text-danger text-sm">*</span></label>
                <select id="gendertype" name="gendertype" class="form-control">
                  <option value="" disabled selected> {{__('Select...')}}</option>
                  @foreach ($genderTypes as $key => $genderType)
                    <option @if (old('gendertype')==$key) selected @endif value="{{$key}}">{{$genderType}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <label for="time_turn">Por favor elija un horario <i class="fa fa-clock-o"></i>: <span class="text-danger text-sm">*</span>({{__('Available hours in campaign')}})</label>
            <div class="row d-flex align-content-center my-2">
              @foreach ($availableHours as $hour)
                @if ($hour['times'] < $campaignFrecuency)
                  <div class="col-lg-1 col-4">
                    <label class="btn btn-danger btn-sm">
                      <input type="radio" name="time_turn" value="{{$hour['time']}}" id="time_turn" autocomplete="off" required>
                      {{$hour['time']}}
                    </label>
                  </div>
                @endif
              @endforeach
            </div>
            <div class="row my-4">
              <div class="col-12">
                <camera-driver-component></camera-driver-component>
              </div>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="1" name="first_time_donating" id="first_time_donating" checked readonly>
              <label class="form-check-label" for="first_time_donating">
                {{__('I have already donated before')}}
              </label>
            </div>
            <p class="text-danger">NOTA: </p>
            <P class="text-danger">El campo correo no es obligatorio, sin embargo es recomendable ingresarlo para que usted pueda recibir mensajes por correo electrónico. Saludos :)</P>
            <div class="text-center">
              {{__('You have already donated before?, please')}}<a href="{{route('login')}}" class="btn btn-link">{{__('login into your account')}}</a> {{'or'}}<a href="https://donadorescompulsivos.org/contacto/" class="btn btn-link">{{__('contact us')}}</a> {{__('for more information.')}}
            </div>
            <div class="text-right my-2">
              <a class="btn btn-danger btn-fill" href="/">{{__('Cancel')}}</a>                
              <button type="submit" class="btn btn-success btn-fill">{{__('Register')}}</button>
            </div>
            <input type="hidden" name="campaign" value="{{$campaignId}}">
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
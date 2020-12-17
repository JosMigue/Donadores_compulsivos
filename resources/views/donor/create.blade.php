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
      <div class="card" style="width: 60rem">
        <div class="card-header">
          <h4 class="card-title">{{__('Add donor')}}</h4>
        </div>
        <div class="card-body">
          <form action="{{route('donors.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row my-1">
              <div class="col-12 col-md-4 pr-md-1">
                <label>{{__('Name')}}</label>
                <input type="text" id="name" name="name" autofocus="true" class="form-control" placeholder="{{__('Name')}}" value="{{old('name')}}" required>
              </div>
              <div class="col-12 col-md-4 px-md-1">
                <label>{{__('Parental Surname')}}</label>
                <input type="text" id="parental_surname" name="parental_surname" class="form-control" placeholder="{{__('Parental Surname')}}" value="{{old('parental_surname')}}" required>
              </div>
              <div class="col-12 col-md-4 pl-md-1">
                <label>{{__('Maternal Surname')}}</label>
                <input type="text" id="maternal_surname" name="maternal_surname" class="form-control" placeholder="{{__('Maternal Surname')}}" value="{{old('maternal_surname')}}" required>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6 pr-md-1">
                <label>{{__('Blood type')}}</label>
                <select class="form-control" name="bloodtype" id="bloodtype" required>
                  <option value="" selected disabled>{{__('Select...')}}</option>
                  @foreach ($bloodTypes as $key => $bloodtype)
                    <option @if (old('bloodtype')==$key) selected @endif value="{{$key}}">{{$bloodtype}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-12 col-md-6 pl-md-1">
                <label>{{__('Donor type')}}</label>
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
                <label>{{__('State')}}</label>
                <select id="state_id" name="state_id" class="form-control" onchange="getAllCitiesState(this)" required>
                  <option value="" selected disabled>{{__('Select...')}}</option>
                  @foreach ($states as $state)
                    <option value="{{$state->id}}">{{$state->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-4 px-md-1">
                <label>{{__('City')}}</label>
                <select id="city_id" name="city_id" class="form-control" required>
                  <option value="">{{__('Select state first')}}</option>
                </select>
              </div>
              <div class="col-md-4 pl-md-1">
                <label>{{__('Born date')}}</label>
                <input type="date" onchange="calculateAge(this)" id="born_date" name="born_date" class="form-control" value="{{old('born_date')}}" required>
              </div>
            </div>
            <div class="row my-1">
              <div class="col-12 col-md-4 pr-md-1">
                <label>{{__('E-Mail Address')}}</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="{{__('E-Mail Address')}}" value="{{old('email')}}">
              </div>
              <div class="col-12 col-md-4 px-md-1">
                <label>{{__('Password')}}</label>
                <input type="password" id="password" name="password" value="1234567890" class="form-control" placeholder="{{__('Password')}}">
              </div>
              <div class="col-12 col-md-4 pl-md-1">
                <label for="password-confirm">{{ __('Confirm Password') }}</label>
                <input id="password-confirm" value="1234567890" type="password" class="form-control" name="password_confirmation" placeholder="{{__('Confirm Password')}}">
              </div>
            </div>
            <div class="row my-1">
              <div class="col-12 col-md-4 pr-md-1">
                <label>{{__('Mobile')}}</label>
                <input type="tel" id="mobile" name="mobile" class="form-control" placeholder="{{__('Mobile')}}" value="{{old('mobile')}}" >
              </div>
              <div class="col-6 col-md-4 px-md-1">
                <label>{{__('Age')}}</label>
                <input type="text" id="age" name="age" class="form-control" readonly placeholder="{{__('Age')}}" value="{{old('age')}}" required>
              </div>
              <div class="col-6 col-md-4 pl-md-1">
                <label>{{__('Gender')}}</label>
                <select id="gendertype" name="gendertype" class="form-control" required>
                  <option value="" disabled selected> {{__('Select...')}}</option>
                  @foreach ($genderTypes as $key => $genderType)
                    <option @if (old('gendertype')==$key) selected @endif value="{{$key}}">{{$genderType}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <label for="observations">{{__('Observations')}}</label>
                <textarea class="form-control" name="observations" id="observations" cols="30" rows="5"></textarea>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <label for="profile_picture">{{__('Profile picture')}}</label>
                <input type="file" class="form-control" name="profile_picture" id="profile_picture">
              </div>
            </div>
            <div class="row">
              <div class="col-lg-4 col-12">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="1" name="first_time_donating" id="first_time_donating">
                  <label class="form-check-label" for="first_time_donating">
                    {{__('I have already donated before')}}
                  </label>
                </div>
              </div>
              <div class="col-lg-4 col-12">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="1" name="be_the_match" id="be_the_match">
                  <label class="form-check-label" for="be_the_match">
                    Be The Match
                  </label>
                </div>
              </div>
              <div class="col-lg-4 col-12">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="1" name="letter" id="letter">
                  <label class="form-check-label" for="letter">
                    {{__('Letter')}}
                  </label>
                </div>
              </div>
            </div>
            <p class="text-justify text-danger">
              Nota al administrador: La contraseña por defecto es 1234567890, en caso de querer poner otra diferente modificar 
              el campo de contraseña y la confirmación de esta. Como consejo y por recomendaciones de Google no se deben utilizar 
              esta clase de contraseña, debido al nivel muy bajo de seguridad que cuentan. Se recomienda al donador que cambie la 
              contraseña una vez llegado el correo de confirmación. Atentamente: JLMarketing
            </p>
            <div class="text-right my-2">
              @guest
                <a class="btn btn-danger btn-fill" href="/">{{__('Cancel')}}</a>                
              @else
                @if (Auth::user()->is_admin == 1)
                  <a class="btn btn-danger btn-fill" href="{{route('donors.index')}}">{{__('Cancel')}}</a>
                @else
                  <a class="btn btn-danger btn-fill" href="{{route('home')}}">{{__('Cancel')}}</a>                
                @endif
              @endguest
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
@extends('layouts.app')

@section('title', __('Add pre donor'))

@section('content')
  <div class="container">
    <div class="row d-flex justify-content-center">
      <div class="card" style="width: 60rem">
        <div class="card-header">
          @if (Auth::check())
            <h4 class="card-title">{{__('Add pre donor')}}</h4>  
          @else
            <h4 class="card-title">{{__('Register as pre donor')}}</h4>  
          @endif
        </div>
        <div class="card-body">
          <div class="row m-1">
            <p class="text-dark">Campos obligatorios<span class="text-danger">*</span></p>
          </div>
          <form action="{{route('temporal_donors.single-store')}}" method="POST">
            @csrf
            <div class="row my-1">
              <div class="col-12 col-md-4 pr-md-1">
                <label>Nombre <span class="text-danger text-sm">*</span> </label>
                <input type="text" id="name" name="name" autofocus="true" class="form-control" value="{{old('name')}}" required>
              </div>
              <div class="col-12 col-md-4 px-md-1">
                <label>Apellido paterno <span class="text-danger text-sm">*</span></label>
                <input type="text" id="parental_surname" name="parental_surname" class="form-control" value="{{old('parental_surname')}}" required>
              </div>
              <div class="col-12 col-md-4 pl-md-1">
                <label>Apellido materno</label>
                <input type="text" id="maternal_surname" name="maternal_surname" class="form-control" value="{{old('maternal_surname')}}">
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-4 pr-md-1">
                <label>CURP <span class="text-danger text-sm">*</span></label>
                <input type="text" maxlength="18" class="form-control" id="curp" name="curp" placeholder="Ingrese su curp" value="{{old('curp')}}" required>
              </div>
              <div class="col-12 col-md-4 px-md-1">
                <label>Tipo de sangre <span class="text-danger text-sm">*</span></label>
                <select class="form-control" name="bloodtype" id="bloodtype"  required>
                  <option value="" selected disabled>Seleccione tipo de sangre...</option>
                  @foreach ($bloodTypes as $key => $bloodtype)
                    <option @if (old('bloodtype')==$key) selected @endif value="{{$key}}">{{$bloodtype}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-12 col-md-4 pl-md-1">
                <label>Tipo de donador <span class="text-danger text-sm">*</span></label>
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
                <label>Correo electrónico</label>
                <input type="email" class="form-control" id="email" name="email" value="{{old('email')}}">
              </div>
              <div class="col-md-4 px-md-1">
                <label>Estado <span class="text-danger text-sm">*</span></label>
                <select id="state_id" name="state_id" class="form-control" onchange="getAllCitiesState(this)" required>
                  <option value="" selected disabled >{{__('Select...')}}</option>
                  @foreach ($states as $state)
                    <option value="{{$state->id}}">{{$state->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-4 pl-md-1">
                <label>Municipio <span class="text-danger text-sm">*</span></label>
                <select id="city_id" name="city_id" class="form-control"  required>
                  <option value="">{{__('Select state first')}}</option>
                </select>
              </div>
            </div>
            <div class="row my-1">
              <div class="col-12 col-md-4 pr-md-1">
                <label>Fecha de nacimiento <span class="text-danger text-sm">*</span></label>
                <input type="date" onchange="calculateAge(this)" id="born_date" name="born_date" class="form-control" value="{{old('born_date')}}" required>
              </div>
              <div class="col-6 col-md-4 px-md-1">
                <label>Teléfono celular </label>
                <input type="tel" id="mobile" name="mobile" class="form-control" placeholder="{{__('Type your mobile')}}" value="{{old('mobile')}}" >
              </div>
              <div class="col-6 col-md-4 pl-md-1">
                <label>Edad <span class="text-danger text-sm">*</span></label>
                <input type="text" id="age" name="age" class="form-control" value="{{old('age')}}" readonly>
              </div>
            </div>
            <div class="row my-1">
              <div class="col-6 col-md-4 pr-md-1">
                <label>Género</label>
                <select id="gendertype" name="gendertype" class="form-control" required>
                  <option value="" disabled selected> {{__('Select...')}}</option>
                  @foreach ($genderTypes as $key => $genderType)
                    <option @if (old('gendertype')==$key) selected @endif value="{{$key}}">{{$genderType}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            @if (Auth::check())
                @if (Auth::user()->is_admin == 1)
                  <div class="row">
                    <div class="col-12 col-lg-4 pr-md-1">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" disabled checked name="first_time_donating" id="first_time_donating">
                        <label class="form-check-label" for="first_time_donating">
                          Donador primera vez
                        </label>
                      </div>
                    </div>
                    <div class="col-12 col-lg-4 px-md-1">
                      <div class="form-check">
                        <input class="form-check-input" value="0" type="checkbox" name="be_the_match" id="be_the_match">
                        <label class="form-check-label" for="be_the_match">
                          Be The Match
                        </label>
                      </div>
                    </div>
                    <div class="col-12 col-lg-4 pl-md-1">
                      <div class="form-check">
                        <input class="form-check-input" value="0" type="checkbox" name="letter" id="letter">
                        <label class="form-check-label" for="letter">
                          Carta
                        </label>
                      </div>
                    </div>
                  </div>
                @endif
            @else
              <p class="text-danger">NOTA: </p>
              <P class="text-danger">El campo correo no es obligatorio, sin embargo es recomendable ingresarlo para que usted pueda recibir mensajes por correo electrónico. Saludos :)</P>
            @endif
            <div class="row my-1">
              <div class="col-lg-12 d-flex justify-content-end">
                <button class="btn btn-success">Registrar</button>
              </div>
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
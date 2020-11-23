@extends('layouts.app')

@section('title',__('Filter results'))
@section('content')
  <div class="container">
    {{__('Applied filters')}} <br>
    @foreach (request()->except('page') as $key => $queryStringParam)
        @if ($key == 'bloodType')
          {{__('Blood type')}}: {{$bloodTypes[$queryStringParam]}} <br>
        @endif
        @if ($key == 'donorType')
          {{__('Donor type')}}: {{$donorTypes[$queryStringParam]}} <br>
        @endif
        @if ($key == 'stateId')
          {{__('State')}}: {{$states[$queryStringParam]->name}} <br>
        @endif
        @if ($key == 'cityId')
          {{__('City')}}: {{$cities[$queryStringParam]->name}} <br>
        @endif
    @endforeach
    <filters-component v-bind:bloodtypes="{{  json_encode($bloodTypes) }}" v-bind:gendertypes="{{  json_encode($genderTypes) }}" v-bind:donortypes="{{  json_encode($donorTypes) }}" v-bind:cities="{{  json_encode($cities) }}" v-bind:states="{{  json_encode($states) }}"></filters-component>
    <div class="row justify-content-center">
      <div class="row">
        <div class="col">
          <h2>{{__('Filters results')}}</h2>
          <span class="text-center">{{__('We found')}} {{$results->total()}} {{__('results')}}</span>
        </div>
      </div>
    </div>
    <div class="table-responsive">
      <table class="table table-hover table-striped">
        <thead class="thead-dark text-center">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nombre</th>
            <th scope="col">Ciudad</th>
            <th scope="col">Estado</th>
            <th scope="col">Tipo de sangre</th>
            <th scope="col">Tipo de donador</th>
            <th scope="col">Teléfono</th>
            <th scope="col">Correo</th>
            <th scope="col">Acciones</th>
          </tr>
        </thead>
        <tbody>
          @if ($results->count() > 0)
            @foreach ($results as $donor)
              <tr>
                <th>{{$donor->id}}</th>
                <td>{{$donor->name}} {{$donor->parental_surname}} {{$donor->maternal_surname}}</td>
                <td>{{$donor->city->name}}</td>
                <td>{{$donor->state->name}}</td>
                <td>{{$bloodTypes[$donor->bloodtype]}}</td>
                <td>{{$donorTypes[$donor->donortype]}}</td>
                <td>{{$donor->mobile}}</td>
                <td>{{$donor->email}}</td>
                <td>
                  <div class="btn-group dropleft">
                    <button class="btn btn-dark dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{__('Action')}} <i class="fa fa-cog mx-1" aria-hidden="true"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="{{route('donors.show',$donor->id)}}"><i class="fa fa-eye mx-1" aria-hidden="true"></i>{{__('Show')}}</a>
                    <a class="dropdown-item" href="{{route('donors.edit', $donor->id)}}"><i class="fa fa-pencil mx-1" aria-hidden="true"></i>{{__('Edit')}}</a>
                    <button class="dropdown-item" onclick="deleteDonor(this)" value="{{$donor->id}}"><i class="fa fa-trash mx-1" aria-hidden="true"></i>{{__('Destroy')}}</button>
                    </div>
                  </div>
                </td>
              </tr>
            @endforeach
          @else
            <tr>
              <td class="text-center" colspan="9">{{__('There is not nothing to show')}}</td>
            </tr>
          @endif
        </tbody>
      </table>  
    </div>
  </div>
  {{$results->appends(request()->except('page'))->links()}}
@endsection

@section('scripts')
  <script src="{{asset('js/donor.js')}}" defer></script>
  <script src="{{asset('js/utils/sweetAlert.js')}}" defer></script>
@endsection
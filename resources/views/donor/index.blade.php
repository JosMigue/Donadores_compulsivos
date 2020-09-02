@extends('layouts.app')

@section('title', __('Donors'))

@section('stylesheets')
  <link rel="stylesheet" href="{{asset('css/elements/div.css')}}">
  <link rel="stylesheet" href="{{asset('css/elements/button.css')}}">
  <link rel="stylesheet" href="{{asset('css/elements/icon.css')}}">
  <link rel="stylesheet" href="{{asset('css/theme/autocomplete.css')}}">
@endsection

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
    <div class="panel-heading">
      <h3>{{__('Donors')}}</h3>
      <a class="is-panel-button is-btn-bg-red" href="{{route('donors.create')}}">{{__('Add')}}<i class="fa fa-plus mx-1"></i></a>
    </div>
      <autocomplete-component></autocomplete-component>
    <div class="table-responsive">
      <table class="table table-hover table-striped table-sm">
        <thead class="thead-dark text-center">
          <tr>
            <th scope="col">#</th>
            <th scope="col">{{__('Name')}}</th>
            <th scope="col">{{__('City')}}</th>
            <th scope="col">{{__('State')}}</th>
            <th scope="col">{{__('Blood type')}}</th>
            <th scope="col">{{__('Donor type')}}</th>
            <th scope="col">{{__('Mobile')}}</th>
            <th scope="col">{{__('E-Mail Address')}}</th>
            <th scope="col">{{__('Actions')}}</th>
          </tr>
        </thead>
        <tbody>
          @if ($donors->count() > 0)
            @foreach ($donors as $index => $donor)
              <tr>
                <th>{{$index+1}}</th>
                <td>{{$donor->name}} {{$donor->parental_surname}} {{$donor->maternal_surname}}</td>
                <td>{{$donor->city->name}}</td>
                <td>{{$donor->state->name}}</td>
                <td>{{$donor->getEnum('bloodtypes')[$donor->bloodtype]}}</td>
                <td>{{$donor->getEnum('donortypes')[$donor->donortype]}}</td>
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
                <td class="table-info" colspan="10">{{__('There is not nothing to show')}}</td>
              </tr>
          @endif
        </tbody>
      </table>    
    </div>
    <div>
      {{$donors->onEachSide(1)->links()}}
    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{asset('js/utils/sweetAlert.js')}}"></script>
  <script src="{{asset('js/donor.js')}}"></script>
@endsection
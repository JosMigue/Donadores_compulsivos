@extends('layouts.app')

@section('title', __('Donors'))

@section('stylesheets')
  <link rel="stylesheet" href="{{asset('css/elements/div.css')}}">
  <link rel="stylesheet" href="{{asset('css/elements/button.css')}}">
  <link rel="stylesheet" href="{{asset('css/elements/icon.css')}}">
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
      <a class="is-panel-button" href="{{route('donors.create')}}">{{__('Add')}}<i class="fa fa-plus mx-1"></i></a>
    </div>
    <div class="table-responsive">
      <table class="table table-hover table-striped">
        <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">{{__('Name')}}</th>
            <th scope="col">{{__('Last Name')}}</th>
            <th scope="col">{{__('Address')}}</th>
            <th scope="col">{{__('City')}}</th>
            <th scope="col">{{__('State')}}</th>
            <th scope="col">{{__('Blood type')}}</th>
            <th scope="col">{{__('Born date')}}</th>
            <th scope="col">{{__('Age')}}</th>
            <th scope="col">{{__('Weight')}}</th>
            <th scope="col">{{__('Height')}}</th>
            <th scope="col">{{__('Date register')}}</th>
            <th scope="col">{{__('Actions')}}</th>
          </tr>
        </thead>
        <tbody>
          @if ($donors->count() > 0)
            @foreach ($donors as $index => $donor)
              <tr>
                <th>{{$index+1}}</th>
                <td>{{$donor->name}}</td>
                <td>{{$donor->last_name}}</td>
                <td>{{$donor->address}}</td>
                <td>{{$donor->city_id}}</td>
                <td>{{$donor->state_id}}</td>
                <td>{{$donor->getEnum('bloodtypes')[$donor->bloodtype]}}</td>
                <td>{{$donor->born_date}}</td>
                <td>{{$donor->age}}</td>
                <td>{{$donor->weight}}</td>
                <td>{{$donor->height}}</td>
                <td>{{$donor->created_at}}</td>
                <td class="d-flex flex-row justify-content-between">
                  <a class="btn btn-warning mx-1" href="{{route('donors.edit', $donor->id)}}"><i class="fa fa-pencil is-icon"></i></a>
                  <button class="btn btn-danger mx-1" ><i class="fa fa-trash is-icon"></i></button>
                </td>
              </tr>
            @endforeach
          @else
              <tr>
                <th class="table-primary text-center" colspan="11">No se encontarron registros </th>
              </tr>
          @endif
        </tbody>
      </table>    
    </div>
  </div>
@endsection
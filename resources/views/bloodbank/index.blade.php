@extends('layouts.app')

@section('title',__('Blood banks'))

@section('stylesheets')
  <link rel="stylesheet" href="{{asset('css/elements/div.css')}}">
  <link rel="stylesheet" href="{{asset('css/elements/button.css')}}">
@endsection
@section('content')
  <div class="container">
    @if (session('successMessage'))
      <div class="alert alert-success" role="alert">
        {{session('successMessage')}}
      </div>
    @endif
    @if (session('errorMessage'))
      <div class="alert alert-success" role="alert">
        {{session('errorMessage')}}
      </div>
    @endif
    <div class="panel-heading">
      <h3>{{__('Blood banks')}}</h3>
      <a class="is-panel-button is-btn-bg-red" href="{{route('bloodbanks.create')}}">{{__('Add')}}<i class="fa fa-plus mx-1"></i></a>
    </div>
    <div class="table-responsive">
      <table class="table table-hover table-striped table-sm">
        <thead class="thead-dark text-center">
          <tr>
            <th scope="col">#</th>
            <th scope="col">{{__('Name')}}</th>
            <th scope="col">{{__('E-Mail Address')}}</th>
            <th scope="col">{{__('Phone')}}</th>
            <th scope="col">{{__('Address')}}</th>
            <th scope="col">{{__('Postal Code')}}</th>
            <th scope="col">{{__('City')}}</th>
            <th scope="col">{{__('State')}}</th>
            <th scope="col">{{__('User')}}</th>
            <th scope="col">{{__('Actions')}}</th>
          </tr>
        </thead>
        <tbody>
          @if ($bloodBanks->count() > 0)
            @foreach ($bloodBanks as $index => $bloodBank)
              <tr>
                <th scope="row">{{$index + 1}}</th>
                <td>{{$bloodBank->name}}</td>
                <td>{{$bloodBank->email}}</td>
                <td>{{$bloodBank->phone}}</td>
                <td>{{$bloodBank->address}}</td>
                <td>{{$bloodBank->postal_code}}</td>
                <td>{{$bloodBank->city->name}}</td>
                <td>{{$bloodBank->state->name}}</td>
                <td>{{$bloodBank->user->name}}</td>
                <td>
                  <div class="btn-group dropleft">
                    <button class="btn btn-dark dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      {{__('Action')}} <i class="fa fa-cog mx-1" aria-hidden="true"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" href="{{route('bloodbanks.edit', $bloodBank->id)}}"><i class="fa fa-pencil mx-1" aria-hidden="true"></i>{{__('Edit')}}</a>
                      <a class="dropdown-item" href="{{route('bloodbanks.destroy', $bloodBank->id)}}"><i class="fa fa-trash mx-1" aria-hidden="true"></i>{{__('Delete')}}</a>
                  </div>
                </td>
              </tr>
            @endforeach
          @else
            <tr>
              <td  class="text-center" colspan="11">
                {{__('There is not nothing to show')}}
              </td>
            </tr>
          @endif
        </tbody>
      </table>    
    </div>
  </div>
@endsection


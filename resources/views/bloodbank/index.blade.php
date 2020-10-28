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
      <table class="table table-hover table-striped">
        <thead class="thead-dark text-center">
          <tr>
            <th scope="col">#</th>
            <th scope="col">{{__('Name')}}</th>
            <th scope="col">{{__('E-Mail Address')}}</th>
            <th scope="col">{{__('Phone')}}</th>
            <th scope="col">{{__('Contact person')}}</th>
            <th scope="col">{{__('Actions')}}</th>
          </tr>
        </thead>
        <tbody>
          @if ($bloodBanks->count() > 0)
            @foreach ($bloodBanks as $index => $bloodBank)
              <tr>
                <th scope="row">{{$index + 1}}</th>
                <td>{{$bloodBank->name}}</td>
                <td><a href="mailto:{{$bloodBank->email}}">{{$bloodBank->email}}</a></td>
                <td>{{$bloodBank->phone}}</td>
                <td>{{$bloodBank->contact_person}}</td>
                <td>
                  <div class="btn-group dropleft">
                    <button class="btn btn-dark dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      {{__('Action')}} <i class="fa fa-cog mx-1" aria-hidden="true"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" href="{{route('bloodbanks.show', $bloodBank->id)}}"><i class="fa fa-eye mx-1" aria-hidden="true"></i>{{__('Show')}}</a>
                      <a class="dropdown-item" href="{{route('bloodbanks.edit', $bloodBank->id)}}"><i class="fa fa-pencil mx-1" aria-hidden="true"></i>{{__('Edit')}}</a>
                      <button onclick="deleteBloodBank(this)" value="{{$bloodBank->id}}" class="dropdown-item" ><i class="fa fa-trash mx-1" aria-hidden="true"></i>{{__('Destroy')}}</button>
                    </div>
                  </div>
                </td>
              </tr>
            @endforeach
          @else
            <tr>
              <td  class="text-center" colspan="12">
                {{__('There is not nothing to show')}}
              </td>
            </tr>
          @endif
        </tbody>
      </table>    
    </div>
    <div >
      {{$bloodBanks->links()}}
    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{asset('js/bloodBank.js')}}"></script>
  <script src="{{asset('js/utils/sweetAlert.js')}}"></script>
@endsection


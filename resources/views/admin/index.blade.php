@extends('layouts.app')

@section('title',__('Admins'))

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
    @if (session('status'))
      <div class="alert alert-success" role="alert">
        {{ session('status') }}
      </div>
    @endif
    <div class="panel-heading">
      <h3>{{__('Admins')}}</h3>
      <a class="is-panel-button is-btn-bg-red" href="{{route('admins.create')}}">{{__('Add')}}<i class="fa fa-plus mx-1"></i></a>
    </div>
    <div class="table-responsive">
      <table class="table table-hover table-striped table-md">
        <thead class="thead-dark text-center">
          <tr>
            <th scope="col">#</th>
            <th scope="col">{{__('Name')}}</th>
            <th scope="col">{{__('E-Mail Address')}}</th>
            <th scope="col">{{__('Date register')}}</th>
            <th scope="col">{{__('Actions')}}</th>
          </tr>
        </thead>
        <tbody>
          @if ($admins->count() > 0)
            @foreach ($admins as $index => $admin)
              <tr>
                <th>{{$index+1}}</th>
                <th><div class="d-flex align-items-center"><img class="rounded-circle" src="{{asset($admin->image)}}" width="40"><span class="ml-2">{{$admin->name}}</span></div></th>
                <th>{{$admin->email}}</th>
                <th>{{$admin->created_at}}</th>
                <td>
                  <div class="btn-group dropleft">
                    @if (Auth::user()->is_super_admin == 1)
                        <button class="btn btn-dark dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          {{__('Action')}} <i class="fa fa-cog mx-1" aria-hidden="true"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="{{route('admins.edit', $admin->id)}}"><i class="fa fa-pencil mx-1" aria-hidden="true"></i>{{__('Edit')}}</a>
                          <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <input type="hidden" name="email" value="{{$admin->email}}">
                            <button class="dropdown-item"><i class="fa fa-unlock-alt mx-1" aria-hidden="true"></i>{{__('Reset Password')}}</button>
                          </form>
                          @if ($admin->id != Auth::user()->id)
                            <button class="dropdown-item" onclick="deleteAdmin(this)" value="{{$admin->id}}"><i class="fa fa-trash mx-1" aria-hidden="true"></i>{{__('Destroy')}}</button>
                          @endif
                        </div>
                      @else
                        @if ($admin->id == Auth::user()->id)
                          <button class="btn btn-dark dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{__('Action')}} <i class="fa fa-cog mx-1" aria-hidden="true"></i>
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{route('admins.edit', $admin->id)}}"><i class="fa fa-pencil mx-1" aria-hidden="true"></i>{{__('Edit')}}</a>
                            <form method="POST" action="{{ route('password.email') }}">
                              @csrf
                              <input type="hidden" name="email" value="{{$admin->email}}">
                              <button class="dropdown-item"><i class="fa fa-unlock-alt mx-1" aria-hidden="true"></i>{{__('Reset Password')}}</button>
                            </form>
                          </div>
                        @endif
                      @endif
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
      <div>
        {{$admins->links()}}
      </div>   
    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{asset('js/admin.js')}}"></script>
  <script src="{{asset('js/utils/sweetAlert.js ')}}"></script>
@endsection
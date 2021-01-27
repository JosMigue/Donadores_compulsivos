@extends('layouts.app')

@section('title',__('Edit admin'))

@section('stylesheets')
  <link rel="stylesheet" href="{{asset('css/elements/button.css')}}">
@endsection

@section('content')
  <div class="container">
    @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif
    <div class="row justify-content-center">
      <div class="card" style="width: 60rem">
        <div class="card-header bg-dark text-white">{{ __('Edit') }}</div>
        <div class="card-body">
          <form method="POST" action="{{route('admins.update',$user->id)}}" enctype="multipart/form-data">
            <div class="row">
              <div class="col-lg-6 col-12">
                <div class="text-center">
                  <img class="img-fluid rounded" width="250" height="250" src="{{asset($user->image)}}" alt="{{$user->name}}">
                </div>
              </div>
              <div class="col-lg-6 col-12">
                @csrf
                @method('PATCH')
                <div class="form-group row">
                  <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                  <div class="col-md-6">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" required autofocus value="{{$user->name}}">
                    @error('name')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                </div>
                <div class="form-group row">
                  <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                  <div class="col-md-6">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" required value="{{$user->email}}">
                    @error('email')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                </div>
              </div>
              <div class="col-12 my-4">
                <camera-driver-component></camera-driver-component>
                <div class="text-right">
                  <button type="submit" class="is-panel-button is-btn-bg-red">{{__('Edit')}}</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{asset('js/utils/sweetAlert.js')}}"></script>
@endsection
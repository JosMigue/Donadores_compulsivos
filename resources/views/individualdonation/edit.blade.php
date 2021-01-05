@extends('layouts.app')

@section('title', __('Edit inidividual donation'))
    
@section('content')
  <div class="container">
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
    <form method="POST" action="{{route('individual-donations.update',$individualDonation->id)}}">
      @csrf
      @method('PATCH')
      <div class="row">
        <div class="col-12 col-lg-6">
          <label for="">Lugar</label>
          <select class="form-control" onchange="getStateCityBloodbank(this)">
            @foreach ($bloodbanks as $bloodbank)
                <option value="{{$bloodbank}}" @if ($individualDonation->bloodbank_id == $bloodbank->id) selected @endif>{{$bloodbank->name}}</option>
            @endforeach
          </select>
        </div>
        <input type="hidden" id="bloodbank_id" name="bloodbank_id" value="{{$individualDonation->bloodbank_id}}">
        <div class="col-12 col-lg-6">
          <label for="">Estado</label>
          <input type="text" id="state" value="{{$individualDonation->bloodbank->state->name}}" class="form-control" readonly placeholder="Este campo es automatico">
        </div>
        <div class="col-12 col-lg-6">
          <label for="">Municipio</label>
          <input type="text" id="city" value="{{$individualDonation->bloodbank->city->name}}" class="form-control" readonly placeholder="Este campo es automatico">
        </div>
        <div class="col-12 col-lg-6">
          <label for="">Fecha de donación</label>
          <input type="date" name="date_donation" value="{{$individualDonation->date_donation}}" class="form-control">
        </div>
        <div class="col-12 col-lg-6">
          <label for="">Hora donación</label>
          <input type="time" name="time_donation" value="{{$individualDonation->time_donation}}" class="form-control">
        </div>
        <div class="col-12 col-lg-6">
          <label for="">Tipo de donación</label>
          <select class="form-control" name="donationtype" id="donationtype">
            <option @if ($individualDonation->donationtype == 'D1') selected @endif value="D1">Sangre</option>
            <option @if ($individualDonation->donationtype == 'D2') selected @endif value="D2">Aféresis</option>
          </select>
        </div>
      </div>
      <div class="text-right">
        <a href="{{route('donors.show', $individualDonation->donor_id)}}" class="btn btn-danger">{{__('Cancel')}}</a>
        <button type="submit" class="btn btn-success">{{__('Update')}}</button>
      </div>  
    </form>
  </div>
@endsection

@section('scripts')
  <script src="{{asset('js/bloodBank.js')}}" defer></script>
@endsection
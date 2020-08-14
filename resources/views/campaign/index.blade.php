@extends('layouts.app')

@section('title', __('Campaigns'))

@section('content')
  <div class="container">
    <div class="table-responsive">
      <table class="table table-striped table-hover">
        <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">{{__('Name')}}</th>
            <th scope="col">{{__('Place')}}</th>
            <th scope="col">{{__('Description')}}</th>
            <th scope="col">{{__('City')}}</th>
            <th scope="col">{{__('State')}}</th>
            <th scope="col">{{__('Date time start')}}</th>
            <th scope="col">{{__('Date time finish')}}</th>
            <th scope="col">{{__('User')}}</th>
            <th scope="col">{{__('Actions')}}</th>
          </tr>
        </thead>
        <tbody>
          @if ($campaigns->count() > 0)
            @foreach ($campaigns as $index => $campaign)
              <tr>
                <th scope="row">{{$index + 1}}</th>
                <td>{{$campaign->name}}</td>
                <td>{{$campaign->place}}</td>
                <td>{{$campaign->description}}</td>
                <td>{{$campaign->city->name}}</td>
                <td>{{$campaign->state->name}}</td>
                <td>{{$campaign->date_start}} {{$campaign->time_start}}</td>
                <td>{{$campaign->date_finish}} {{$campaign->time_finish}}</td>
                <td>{{$campaign->user->name}}</td>
                <td>
                  <div class="btn-group dropleft">
                    <button type="button" class="btn btn-dark btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      {{__('Action')}}
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="{{route('campaigns.show',$campaign->id)}}"><i class="fa fa-eye mx-1" aria-hidden="true"></i>{{__('Show')}}</a>
                      <a class="dropdown-item" href="{{route('campaigns.edit', $campaign->id)}}"><i class="fa fa-pencil mx-1" aria-hidden="true"></i>{{__('Edit')}}</a>
                      <button class="dropdown-item" onclick="deleteDonor(this)" value="{{$campaign->id}}"><i class="fa fa-trash mx-1" aria-hidden="true"></i>{{__('Destroy')}}</button>
                    </div>
                  </div>
                </td>
              </tr>
            @endforeach
          @else
            <tr>
              <td class="text-center" colspan="10">{{__('There is not nothing to show')}}</td>
            </tr>
          @endif
        </tbody>
      </table>
    </div>
  </div>
@endsection
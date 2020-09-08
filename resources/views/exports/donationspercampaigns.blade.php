<table class="table table-striped table-hover">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">{{__('Name')}}</th>
      <th scope="col">{{__('Place')}}</th>
      <th scope="col">{{__('City')}}</th>
      <th scope="col">{{__('State')}}</th>
      <th scope="col">{{__('Date time start')}}</th>
      <th scope="col">{{__('Date time finish')}}</th>
      <th scope="col">{{__('Subscribed donors')}}</th>
      <th scope="col">{{__('Donations')}}</th>
    </tr>
  </thead>
  <tbody>
    @if ($campaigns->count() > 0)
      @foreach ($campaigns as $index => $campaign)
        <tr>
          <th scope="row">{{$index + 1}}</th>
          <td>{{$campaign->name}}</td>
          <td>{{$campaign->place}}</td>
          <td>{{$campaign->city->name}}</td>
          <td>{{$campaign->state->name}}</td>
          <td>{{$campaign->date_start}} {{$campaign->time_start}}</td>
          <td>{{$campaign->date_finish}} {{$campaign->time_finish}}</td>
          <td>{{$donor->campaigndonors->count()}}</td>
          <td>{{$donor->campaigndonors->where('donor_donated',1)->count()}}</td>
        </tr>
      @endforeach
    @else
      <tr>
        <td class="text-center" colspan="10">{{__('There is not nothing to show')}}</td>
      </tr>
    @endif
  </tbody>
</table>
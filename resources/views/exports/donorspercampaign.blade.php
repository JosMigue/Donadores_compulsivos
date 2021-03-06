<tr>
  <th scope="col">
    Cantidad de donadores registrados en esta campaña
  </th>
</tr>
<tr>
  <th>
    {{$campaign->donors->count()}}
  </th>
</tr>
<tr>
  <th>Información de la camapaña</th>
</tr>
<table class="table table-striped table-hover">
  <thead class="thead-dark">
    <tr>
      <th scope="col">{{__('Name')}}</th>
      <th scope="col">{{__('Place')}}</th>
      <th scope="col">{{__('City')}}</th>
      <th scope="col">{{__('State')}}</th>
      <th scope="col">{{__('Date time start')}}</th>
      <th scope="col">{{__('Date time finish')}}</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>{{__($campaign->name)}}</td>
      @if ($campaign->campaigntype == 'c1')
        <td>{{$campaign->place}}</td>  
      @else
        <td>{{$campaign->bloodbank->name}}</td>  
      @endif
      <td>{{$campaign->city->name}}</td>
      <td>{{$campaign->state->name}}</td>
      <td>{{$campaign->date_start}} {{$campaign->time_start}}</td>
      <td>{{$campaign->date_finish}} {{$campaign->time_finish}}</td>
    </tr>
  </tbody>
</table>
<tr>
  <th>Donadores registrados</th>
</tr>
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
      <th scope="col">{{__('Turn time')}}</th>
      <th scope="col">{{__('Attended')}}</th>
      <th scope="col">{{__('Donated')}}</th>
    </tr>
  </thead>
  <tbody>
    @if ($campaign->donors->count() > 0)
      @foreach ($campaign->donors as $index => $donor)
        <tr>
          <th>{{$index+1}}</th>
          <td>{{$donor->name}} {{$donor->parental_surname}} {{$donor->maternal_surname}}</td>
          <td>{{$donor->city->name}}</td>
          <td>{{$donor->state->name}}</td>
          <td>{{$donor->getEnum('bloodtypes')[$donor->bloodtype]}}</td>
          <td>{{$donor->getEnum('donortypes')[$donor->donortype]}}</td>
          <td>{{$donor->mobile}}</td>
          <td>{{$donor->email}}</td>
  
          <td>{{$donor->campaigndonors->where('campaign_id', $campaign->id)->first()->time_turn}}</td>
          @if($donor->campaigndonors->where('campaign_id', $campaign->id)->first()->donor_attended == 1)
            <td>Sí</td>
          @else
            <td>No</td>
          @endif
          @if($donor->campaigndonors->where('campaign_id', $campaign->id)->first()->donor_donated == 1)
            <td>Sí</td>
          @else
            <td>No</td>
          @endif
        </tr>
      @endforeach
    @else
        <tr>
          <td class="table-info text-center" colspan="12">{{__('There is not nothing to show')}}</td>
        </tr>
    @endif
  </tbody>
</table> 

<tr>
  <th>Donadores pre registrados</th>
</tr>
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
      <th scope="col">{{__('Turn time')}}</th>
      <th scope="col">{{__('Attended')}}</th>
      <th scope="col">{{__('Donated')}}</th>
    </tr>
  </thead>
  <tbody>
    @if ($campaign->temporaldonors->count() > 0)
      @foreach ($campaign->temporaldonors as $index => $donor)
        <tr>
          <th>{{$index+1}}</th>
          <td>{{$donor->name}} {{$donor->parental_surname}} {{$donor->maternal_surname}}</td>
          <td>{{$donor->city->name}}</td>
          <td>{{$donor->state->name}}</td>
          <td>{{$donor->getEnum('bloodtypes')[$donor->bloodtype]}}</td>
          <td>{{$donor->getEnum('donortypes')[$donor->donortype]}}</td>
          <td>{{$donor->mobile}}</td>
          <td>{{$donor->email}}</td>
  
          <td>{{$donor->campaigntemporaldonors->where('campaign_id', $campaign->id)->first()->time_turn}}</td>
          @if($donor->campaigntemporaldonors->where('campaign_id', $campaign->id)->first()->donor_attended == 1)
            <td>Sí</td>
          @else
            <td>No</td>
          @endif
          @if($donor->campaigntemporaldonors->where('campaign_id', $campaign->id)->first()->donor_donated == 1)
            <td>Sí</td>
          @else
            <td>No</td>
          @endif
        </tr>
      @endforeach
    @else
        <tr>
          <td class="table-info text-center" colspan="12">{{__('There is not nothing to show')}}</td>
        </tr>
    @endif
  </tbody>
</table> 

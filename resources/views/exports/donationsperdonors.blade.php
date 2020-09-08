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
        <th scope="col">{{__('Donations')}}</th>
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
            <td>{{$donor->campaigndonors->where('donor_donated',1)->count()}}</td>
          </tr>
        @endforeach
      @else
          <tr>
            <td class="table-info text-center" colspan="10">{{__('There is not nothing to show')}}</td>
          </tr>
      @endif
    </tbody>
  </table>  
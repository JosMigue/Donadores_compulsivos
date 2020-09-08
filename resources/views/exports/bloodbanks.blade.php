<tr> <th scope="col"> Cantidad de bancos de sangre registrados</th></tr>
<tr>
  <td>
    {{$bloodBanks->count()}}
  </td>
</tr>
<table class="table table-hover table-striped">
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
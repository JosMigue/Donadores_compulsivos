<option value="" selected disabled>{{__('Select...')}}</option>
@foreach($cities as $city)
  <option value="{{$city->id}}">{{$city->name}}</option>
@endforeach
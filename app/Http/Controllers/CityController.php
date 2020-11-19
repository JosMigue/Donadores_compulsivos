<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\City;
use App\State;

class CityController extends Controller
{
  public function index(Request $request)
  {
      $state_id = $request->input('stateId');
      $cities = City::getCitiesByState($state_id);
      $view = \View::make('city/citiesOptions', [
          'cities' => $cities
      ]);

      return $html = $view->render();
  }

  public function citiesByState(Request $request)
  {
    $state = State::where('id',$request->input('stateId'))->first();
    return $state->cities;
  }
}

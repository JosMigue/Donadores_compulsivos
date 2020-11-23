<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Donor;
use App\State;
use App\City;

class DonorFilterController extends Controller
{
  public function __construct(){
    $this->middleware('auth');
  }

  public function filterByName($search){
    return Donor::where('name','LIKE','%'.$search.'%')->orWhere('parental_surname','LIKE','%'.$search.'%')->orWhere('maternal_surname','LIKE','%'.$search.'%')->with(['city', 'state', 'user'])->orderBy('id', 'ASC')->paginate(50);
  }

  public function filterById($id){
    return Donor::where('id',$id)->with(['city', 'state'])->paginate(50);
  }

  public function filter(Request $request){
    $donors = Donor::query();
    if($request->has('bloodType')){
      $donors->where('bloodtype', $request->input('bloodType'));
    }
    if($request->has('donorType')){
      $donors->where('donortype', $request->input('donorType'));
    }
    if($request->has('cityId')){
      $donors->where('city_id', $request->input('cityId'));
    }
    if($request->has('stateId')){
      $donors->where('state_id', $request->input('stateId'));
    }
    $bloodTypes = Donor::getEnum('bloodtype');
    $genderTypes = Donor::getEnum('gendertype');
    $donorTypes = Donor::getEnum('donortype');
    $states = State::all();
    $cities = City::orderBy('name', 'ASC')->get();
    $results = $donors->with(['city', 'state'])->orderBy('id', 'ASC')->paginate(15);
    return view('donor.filter',compact('results', 'bloodTypes', 'genderTypes', 'donorTypes','states', 'cities'));
  }
}

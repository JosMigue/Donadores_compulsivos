<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Donor;
use App\TemporalDonor;

class DonorFilterController extends Controller
{
  public function __construct(){
    $this->middleware('auth');
    $this->middleware('admin');
  }
  
  public function index(Request $request){
    return json_encode(array(
      'donors' => Donor::with(['city', 'state', 'user'])->where('is_active',1)->take($request->input('takeRecords'))->get(), 
      'countDonors' => Donor::count(),
      'inActiveDonors' => Donor::where('is_active',0)->get()->count(),
      'activeDonors' => Donor::where('is_active',1)->get()->count(),
    ));
  }

  public function temporalDonorsList(){
    return TemporalDonor::with(['city', 'state'])->get();
  }

  public function filter(Request $request){
    $donors = Donor::query();
    if($request->input('be_the_match') === 'true'){
      $donors->where('be_the_match', 1);
    }
    if($request->input('letter') === 'true'){
      $donors->where('letter', 1);
    }
    if($request->input('isFirstTimeDonor') === 'true'){
      $donors->where('first_time_donating', 1);
    }
    if($request->input('bloodType')){
      $donors->where('bloodtype', $request->input('bloodType'));
    }
    if($request->input('donorType')){
      $donors->where('donortype', $request->input('donorType'));
    }
    if($request->input('city')){
      $donors->where('city_id', $request->input('city'));
    }
    if($request->input('state')){
      $donors->where('state_id', $request->input('state'));
    }
    if($request->input('id')){
      $donors->where('id', $request->input('id'));
    }
    if($request->input('name')){
      $donors->where('name', 'LIKE', '%'.$request->input('name').'%')->orWhere('parental_surname','LIKE','%'.$request->input('name').'%')->orWhere('maternal_surname','LIKE','%'.$request->input('name').'%');
    }

    return $donors->with(['city', 'state'])->get();
  }

  public function temporalDonorsFilter(Request $request){
    $temporalDonors = TemporalDonor::query();
    if($request->input('bloodType')){
      $temporalDonors->where('bloodtype', $request->input('bloodType'));
    }
    if($request->input('donorType')){
      $temporalDonors->where('donortype', $request->input('donorType'));
    }
    if($request->input('city')){
      $temporalDonors->where('city_id', $request->input('city'));
    }
    if($request->input('state')){
      $temporalDonors->where('state_id', $request->input('state'));
    }
    if($request->input('id')){
      $temporalDonors->where('id', $request->input('id'));
    }
    if($request->input('name')){
      $temporalDonors->where('name', 'LIKE', '%'.$request->input('name').'%')->orWhere('parental_surname','LIKE','%'.$request->input('name').'%')->orWhere('maternal_surname','LIKE','%'.$request->input('name').'%');
    }

    return $temporalDonors->with(['city', 'state'])->get();
  }

  public function filterByName(Request $request){
    if($request->has('donorid')){
      return Donor::where('id', $request->input('donorid'))->with('city', 'state')->first();
    }else if($request->has('search')){
      return Donor::where('is_active',1)->where('name', 'LIKE', '%'.$request->input('search').'%')->orWhere('parental_surname','LIKE','%'.$request->input('search').'%')->orWhere('maternal_surname','LIKE','%'.$request->input('search').'%')->take(10)->with('city', 'state')->get();
    }
  }

  public function temporalDonorfilterByName(Request $request){
    if($request->has('donorid')){
      return TemporalDonor::where('id', $request->input('donorid'))->with('city', 'state')->first();
    }else if($request->has('search')){
      return TemporalDonor::where('name', 'LIKE', '%'.$request->input('search').'%')->orWhere('parental_surname','LIKE','%'.$request->input('search').'%')->orWhere('maternal_surname','LIKE','%'.$request->input('search').'%')->take(10)->with('city', 'state')->get();
    }
  }
}

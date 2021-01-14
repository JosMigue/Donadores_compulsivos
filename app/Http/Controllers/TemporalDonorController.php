<?php

namespace App\Http\Controllers;

use App\TemporalDonor;
use App\Campaign;
use App\CampaignDonor;
use App\State;
use App\City;
use App\Http\Requests\saveTemporalDonorRequest;
use App\Http\Requests\UpdateTemporalDonorRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TemporalDonorController extends Controller
{

  public function __construct(){
    $this->middleware('auth');
    $this->middleware('admin');
  }

  public function index()
  {
    $bloodTypes = TemporalDonor::getEnum('bloodtype');
    $genderTypes = TemporalDonor::getEnum('gendertype');
    $donorTypes = TemporalDonor::getEnum('donortype');
    $states = State::all();
    $cities = City::orderBy('name', 'ASC')->get();
    return view('temporal_donor.index', compact('bloodTypes', 'genderTypes', 'donorTypes', 'states', 'cities'));
  }
  
  public function create()
  {
    $bloodTypes = TemporalDonor::getEnum('bloodtype');
    $genderTypes = TemporalDonor::getEnum('gendertype');
    $donorTypes = TemporalDonor::getEnum('donortype');
    $states = State::all();
    $cities = City::all();
    return view('temporal_donor.create', compact('bloodTypes', 'genderTypes', 'donorTypes', 'states', 'cities'));
  }

  public function store(SaveTemporalDonorRequest $request)
  {
    $temporalDonor = TemporalDonor::create($request->validated());
    if($this->addNewDonorInCampaign($temporalDonor->id, $request->input('campaign'), $request)){
      return array('code'=> 200, 'message'=> __('Donor has been added successfully'));
    }else{
      return array('code'=> 500, 'message'=> __('Something went wrong, try again later'));
    }
  }

  public function singleStore(SaveTemporalDonorRequest $request){
    if(TemporalDonor::create($request->validated())){
      return redirect()->route('temporal_donors.index')->with('successMessage', __('Donor has been added successfully'));
    }else{
      return redirect()->route('temporal_donors.index')->with('errorMessage', __('Something went wrong, try again later'));
    }
  }

  private function addNewDonorInCampaign($donorId, $campaignId, $request){
    $campaign = Campaign::where('id',$campaignId)->with(['donors', 'temporaldonors'])->first();
    $currentTurn = $campaign->donors->count() + $campaign->temporaldonors->count();
    $currentTurn +=1;
    $campaignAt = Carbon::create($campaign->time_start);
    $timeTurn = $this->calculateTurn($currentTurn, $campaignAt, $campaign->frecuency, $campaign->frecuency_time);
    $campaigDonor = new CampaignDonor(['temporal_donor_id' => $donorId, 'turn' =>  $currentTurn,  'time_turn' => $timeTurn, 'ip_address' => $request->ip()]);
    $campaign->campaigndonors()->save($campaigDonor);
    return true;
  }

  private function saveUploadedPicture($temporalDonor, $request){
    if($request->has('profile_picture')){
      $request->validated()['profile_picture']->storeAs('avatars', $temporalDonor->id.'pf.jpg','profile_pictures');
      $temporalDonor->profile_picture = 'storage/profile/avatars/'.$temporalDonor->id.'pf.jpg';
    }else{
      if($temporalDonor->gendertype=='M'){
        $temporalDonor->profile_picture = 'img/default_avatar_man.jpg';
      }else if($temporalDonor->gendertype=='F'){
        $temporalDonor->profile_picture = 'img/default_avatar_woman.jpg';
      }else{
        $temporalDonor->profile_picture = 'img/default_avatar.jpg';
      }
    }
    return $temporalDonor;
  }

  private function calculateTurn($currentTurn, $campaignStartAt, $campaignFrecuencyDonors, $campaignFrecuencyTime){
    $calculated = $currentTurn/$campaignFrecuencyDonors;
    $rounded =  ceil($calculated);
    return $campaignStartAt->addMinutes(($campaignFrecuencyTime*$rounded)-$campaignFrecuencyTime);
  }

  public function show(TemporalDonor $temporalDonor)
  {
    return view('temporal_donor.show', compact('temporalDonor'));
  }

  public function edit(TemporalDonor $temporalDonor)
  {
    $bloodTypes = TemporalDonor::getEnum('bloodtype');
    $genderTypes = TemporalDonor::getEnum('gendertype');
    $donorTypes = TemporalDonor::getEnum('donortype');
    $states = State::all();
    $cities = City::where('state_id', $temporalDonor->state_id)->get();
    return view('temporal_donor.edit', compact('temporalDonor', 'bloodTypes', 'donorTypes', 'genderTypes', 'states', 'cities'));
  }

  public function update(UpdateTemporalDonorRequest $request, TemporalDonor $temporalDonor)
  {
    if($temporalDonor->update($request->validated())){
      return redirect()->route('temporal_donors.index')->with('successMessage',__('Donor has been updated successfully'));
    }else{
      return redirect()->route('temporal_donors.index')->with('errorMessage',__('Something went wrong, try againg later'));
    }
  }

  public function destroy(TemporalDonor $temporalDonor)
  {
    if($temporalDonor->delete()){
      return array('message' => __('Donor has been deleted successfully'), 'code' => 200);
    }else{
      return array('message' => __('Something went wrong, try again later'), 'code' => 500);
    }
  }
}

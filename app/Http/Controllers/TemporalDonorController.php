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
use Illuminate\Support\Facades\Auth;
use App\Notifications\SendTurnDonation;

class TemporalDonorController extends Controller
{

  public function __construct(){
    $this->middleware('auth')->except(['showregistreview', 'singleStore', 'create', 'store']);
    $this->middleware('admin')->except(['showregistreview', 'singleStore', 'create', 'store']);
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
    if($request->has('time_turn')){
      if($this->addNewTemporalDonorInCampaig($temporalDonor->id, $request->input('campaign'), $request, $request->input('time_turn'))){
        if($temporalDonor->email != null){
          $temporalDonor->notify(new SendTurnDonation($request->input('time_turn')));
        }
        return redirect()->route('welcome')->with('successMessage', __('Donor has been added successfully'))->with('information', __('If you typed an email we have sent you an email with information about yout time turn. Thanks for beign part of this.'));
      }else{
        return redirect()->route('welcome')->with('errorMessage', __('Something went wrong, try again later'));
      }
    }else if(Auth::check() && Auth::user()->is_admin == 1){
      if($this->addNewDonorInCampaign($temporalDonor->id, $request->input('campaign'), $request)){
        return array('code'=> 200, 'message'=> __('Donor has been added successfully'));
      }else{
        return array('code'=> 500, 'message'=> __('Something went wrong, try again later'));
      }
    }else{
      return response()->view('errors.500', [], 500);
    }
  }

  public function singleStore(SaveTemporalDonorRequest $request){
    if(TemporalDonor::create($request->validated())){
      if(Auth::check()){
        return redirect()->route('temporal_donors.index')->with('successMessage', __('Donor has been added successfully'));
      }else{
        return redirect()->route('welcome')->with('successMessage', __('Donor has been added successfully'))->with('information', __('Thanks for register, soon we will contact you. Thanks for beign an amazing person'));
      }
    }else{
      if(Auth::check()){
        return redirect()->route('temporal_donors.index')->with('errorMessage', __('Something went wrong, try again later'));
      }else{
        return redirect()->route('welcome')->with('errorMessage', __('Something went wrong, try again later'));
      }
    }
  }

  private function addNewTemporalDonorInCampaig($temporal_donorId, $campaignId, $request, $timeTurn){
    $campaign = Campaign::findOrFail($campaignId);
    $campaign = Campaign::where('id',$campaignId)->with(['donors', 'temporaldonors'])->first();
    $currentTurn = $campaign->donors->count() + $campaign->temporaldonors->count();
    $currentTurn +=1;
    $campaigDonor = new CampaignDonor(['temporal_donor_id' => $temporal_donorId, 'turn' =>  $currentTurn,  'time_turn' => $timeTurn, 'ip_address' => $request->ip()]);
    $campaign->campaigndonors()->save($campaigDonor);
    return true;
  }

  private function addNewDonorInCampaign($donorId, $campaignId, $request){
    $campaign = Campaign::findOrFail($campaignId);
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

  public function showregistreview($campaignId = null){
    if($campaignId){
      $campaign = Campaign::findOrFail($campaignId);
      $campaignFrecuency = $campaign->frecuency;
      $availableHours = $this->checkAvailableHours($campaign);
      $bloodTypes = TemporalDonor::getEnum('bloodtype');
      $genderTypes = TemporalDonor::getEnum('gendertype');
      $donorTypes = TemporalDonor::getEnum('donortype');
      $states = State::all();
      $cities = City::all();
      return view('temporal_donor.register', compact('bloodTypes', 'genderTypes', 'donorTypes', 'states', 'cities', 'availableHours','campaignFrecuency', 'campaignId', $campaign->id));
    }else{
      return redirect()->route('campaigns.listing');
    }
  }

  private function checkAvailableHours($campaign){
    $timeList = $this->createTimeArrayCampaign($campaign->id);
    $donorsCampaign = $campaign->donors()->get();
    $temporalDonorsCampaign = $campaign->temporaldonors()->get();
    foreach ($timeList as $keyh => $hour) {
      foreach ($donorsCampaign as $keyd => $donor) {
        if(Carbon::create($hour['time'])->format('H:i') == Carbon::create($donor->pivot->time_turn)->format('H:i')){
          $timeList[$keyh]['times'] = $timeList[$keyh]['times'] + 1;
        }
      }
      foreach ($temporalDonorsCampaign as $keyd => $donor) {
        if(Carbon::create($hour['time'])->format('H:i') == Carbon::create($donor->pivot->time_turn)->format('H:i')){
          $timeList[$keyh]['times'] = $timeList[$keyh]['times'] + 1;
        }
      }
    }
    return $timeList;
  }

  private function createTimeArrayCampaign($campaign){
    $currentCampaign = Campaign::findOrFail($campaign);
    $campaignEndat = Carbon::create($currentCampaign->time_finish);
    $step = $currentCampaign->frecuency_time;
    $timeList = array();
    $breaker = true;
    $count = 0;
    while($breaker){
      $time = Carbon::create($currentCampaign->time_start);
      $minutesToAdd = $count * $step;
      $time = $time->addMinutes($minutesToAdd);
      array_push($timeList,array('time'=>$time->format('H:i'), 'times'=>0));
      $count= $count + 1;
      if($campaignEndat->format('H:i') == $time->format('H:i') || $campaignEndat < $time){
        $breaker = false;
      }
    }
    return $timeList;
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

  public function changeLetterStatus(TemporalDonor $temporalDonor, $status){
    $temporalDonor->letter = $status;
    if($temporalDonor->save()){
      return json_encode(array('code' => '200', 'message' => __('Letter status changed')));
    }else{
      return json_encode(array('code' => '500', 'message' => __('Something went wrong, try again later')));
    }
  }
  
  public function changeBeTheMatchStatus(TemporalDonor $temporalDonor, $status){
    $temporalDonor->be_the_match = $status;
    if($temporalDonor->save()){
      return json_encode(array('code' => '200', 'message' => __('Be The Match status changed')));
    }else{
      return json_encode(array('code' => '500', 'message' => __('Something went wrong, try again later')));
    }
  }
}

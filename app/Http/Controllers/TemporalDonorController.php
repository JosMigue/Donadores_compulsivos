<?php

namespace App\Http\Controllers;

use App\TemporalDonor;
use App\Donor;
use App\User;
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
use Illuminate\Support\Facades\Storage;
use App\Notifications\NotifyDonorAccountNotification;

class TemporalDonorController extends Controller
{

  public function __construct(){
    $this->middleware('auth')->except(['showregistreview', 'singleStore', 'create', 'store']);
    $this->middleware('admin')->except(['showregistreview', 'singleStore', 'create', 'store']);
    $this->middleware('guest')->only(['showregistreview', 'store']);
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
    $temporalDonorArray = $this->saveUploadedPicture($request->validated(), $request);
    $temporalDonor = TemporalDonor::create($temporalDonorArray);
    if($request->has('time_turn')){
      if($this->addNewTemporalDonorInCampaig($temporalDonor->id, $request->input('campaign'), $request, $request->input('time_turn'))){
        if($temporalDonor->email != null){
          $temporalDonor->notify(new SendTurnDonation($request->input('time_turn')));
        }
        return redirect()->route('welcome')->with('successMessage', __('Donor has been added successfully'))->with('information', __('If you typed an email we have sent you an email with information about yout time turn. Thanks for beign part of this.'));
      }else{
        return redirect()->route('welcome')->with('errorMessage', __('Something went wrong, try again later'));
      }
    }
  }

  public function apiStore(SaveTemporalDonorRequest $request){
    $temporalDonorArray = $this->saveUploadedPicture($request->validated(), $request);
    $temporalDonor = TemporalDonor::create($temporalDonorArray);
    if(Auth::check() && Auth::user()->is_admin == 1){
      if($this->addNewDonorInCampaign($temporalDonor->id, $request->input('campaign'), $request)){
        return array('code'=> 200, 'message'=> __('Donor has been added successfully'));
      }else{
        return array('code'=> 500, 'message'=> __('Something went wrong, try again later'));
      }
    }else{
      return array('code'=> 500, 'message'=> __('Something went wrong, try again later'));
    }
  }

  public function singleStore(SaveTemporalDonorRequest $request){
    $temporalDataArray = $this->saveUploadedPicture($request->validated(), $request);
    if(TemporalDonor::create($temporalDataArray)){
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

  public function updateProfilePicture(TemporalDonor $temporalDonor, Request $request){
    $currentTime = time();
    if($request->has('profile_picture')){
      Storage::disk('predonor_profile_pictures')->delete('avatars/'.$temporalDonor->image);
      $request->file('profile_picture')->storeAs('avatars', $currentTime.'pf.jpg','predonor_profile_pictures');
      $temporalDonor->profile_picture = 'storage/predonor/avatars/'.$currentTime.'pf.jpg';
      $temporalDonor->image = $currentTime.'pf.jpg';
      $temporalDonor->save();
      return redirect()->route('temporal_donors.show', $temporalDonor->id)->with('successMessage', __('Profile picture updated successfully'));
    }else{
      return redirect()->route('home')->with('errorMessage', __('Something went wrong, try again later'));
    }
  }

  private function saveUploadedPicture($temporalDonor, $request){
    $currentTime = time();
    if($request->has('profile_picture')){
      $request->validated()['profile_picture']->storeAs('avatars', $currentTime.'pf.jpg','predonor_profile_pictures');
      $temporalDonor['profile_picture'] = 'storage/predonor/avatars/'.$currentTime.'pf.jpg';
      $temporalDonor['image'] = $currentTime.'pf.jpg';
    }else if($request->has('captured_image') && $request->captured_image != null){
      $data = explode(',',$request->validated()['captured_image']);
      $profile_picture = base64_decode($data[1]);
      Storage::disk('predonor_profile_pictures')->put('avatars/'.$currentTime.'pf.jpg', $profile_picture);
      $temporalDonor['profile_picture'] = 'storage/predonor/avatars/'.$currentTime.'pf.jpg';
      $temporalDonor['image'] = $currentTime.'pf.jpg';
    }else if(!array_key_exists('profile_picture', $temporalDonor)){
      if($temporalDonor['gendertype']=='M'){
        $temporalDonor['profile_picture'] = 'img/default_avatar_man.jpg';
      }else if($temporalDonor['gendertype']=='F'){
        $temporalDonor['profile_picture'] = 'img/default_avatar_woman.jpg';
      }else{
        $temporalDonor['profile_picture'] = 'img/default_avatar.jpg';
      }
    }
    return $temporalDonor;
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
    $updateTemporalDonorArray = $this->saveUploadedPicture($request->validated(), $request);
    if($temporalDonor->update($updateTemporalDonorArray)){
      return redirect()->route('temporal_donors.index')->with('successMessage',__('Donor has been updated successfully'));
    }else{
      return redirect()->route('temporal_donors.index')->with('errorMessage',__('Something went wrong, try againg later'));
    }
  }

  public function destroy(TemporalDonor $temporalDonor)
  {
    $image = $temporalDonor->image;
    if($temporalDonor->delete()){
      Storage::disk('predonor_profile_pictures')->delete('avatars/'.$image);
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

  public function changeTypeTemporalDonor(TemporalDonor $temporalDonor){
    $temporalDonor->donortype = 'D2';
    if($temporalDonor->save()){
      return json_encode(array('code' => '200', 'message' => __('Type predonor changed')));
    }else{
      return json_encode(array('code' => '500', 'message' => __('Something went wrong, try again later')));
    }
  }

  public function morphIntoDonor(Request $request){
    $temporalDonor = TemporalDonor::findOrFail($request->input('predonorId'));
    $temporalDonorDataArray = $temporalDonor->toArray();
    if($temporalDonor->email){
      $user = User::create(['name' => $temporalDonor->name, 'email'=> $temporalDonor->email, 'password'=>'$2y$10$LLck65rXlXmE4Ac.UmKqfuJv9zsSOh6YG2hB0bdwwrEMv4epi1/H6']);
      if($user->donor()->create($temporalDonorDataArray)){
        $temporalDonor->delete();
        $user->notify(new NotifyDonorAccountNotification());
        return json_encode(array('code'=> 200, 'message' => __('Donor has been added successfully')));
      }
    }else{
      Donor::create($temporalDonorDataArray);
      $temporalDonor->delete();
      return json_encode(array('code'=> 200, 'message' => __('Donor has been added successfully, but donor has not access to system beacuse donor has not an email')));
    }
  }
}

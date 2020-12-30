<?php

namespace App\Http\Controllers;

use App\Donor;
use App\Campaign;
use App\CampaignDonor;
use App\City;
use App\State;
use App\User;
use Excel;
use Carbon\Carbon;
use App\Exports\DonorsExport;
use Illuminate\Http\Request;
use App\Http\Requests\SaveDonorRequest;
use App\Http\Requests\UpdateDonorRequest;
use App\Http\Requests\UploadProfilePictureRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class DonorController extends Controller
{
  
  use RegistersUsers;

  public function __construct(){
    $this->middleware('auth')->except('store','showregistreview');
    $this->middleware('admin')->except('store', 'showregistreview', 'edit', 'show', 'update', 'updateProfilePicture');
    $this->middleware('iscurrentdonor')->only('show');
    $this->middleware('verified')->only('index');
  }
  
  public function index()
  {
    $bloodTypes = Donor::getEnum('bloodtype');
    $genderTypes = Donor::getEnum('gendertype');
    $donorTypes = Donor::getEnum('donortype');
    $states = State::all();
    $cities = City::orderBy('name', 'ASC')->get();
    return view('donor.index', compact('bloodTypes', 'genderTypes', 'donorTypes', 'states', 'cities'));
  }

  public function create()
  {
    $bloodTypes = Donor::getEnum('bloodtype');
    $genderTypes = Donor::getEnum('gendertype');
    $donorTypes = Donor::getEnum('donortype');
    $states = State::all();
    $cities = City::all();
    return view('donor.create', compact('bloodTypes', 'genderTypes', 'donorTypes', 'states', 'cities'));
  }

  public function store(SaveDonorRequest $request)
  {
    if($request->validated()['email'] != null){
      $user = $this->setUser($request); 
      $donor =  new Donor ($request->validated());
      $donor->profile_picture = '';
      $donor->user_id = $user->id;
      $identifier = $this->asignIdentifier();
      $donor->identifier = $identifier;
      $credentials = $request->only('email', 'password');
      $donor = $this->saveUploadedPicture($donor, $request);
      if($donor->save()){
        if (Auth::check()) {
          return redirect()->route('donors.create')->with('successMessage', __('Donor has been added successfully'));
        }else{
          if (Auth::attempt($credentials)) {
            return redirect()->intended('home');
          }else{
            return redirect()->route('login')->with('loginMessage', __('Something went wrong, try again later'));
          }
        }
      }else{
        return redirect()->route('donors.create')->with('errorMessage', __('Something went wrong, try again later'));
      }
    }else{
      if($this->saveDonorWithoutAccess($request)){
        return redirect()->route('donors.index')->with('successMessage', __('Donor has been added successfully'));
      }else{
        return redirect()->route('donors.index')->with('errorMessage', __('Something went wrong, try again later'));
      }
    }
  }

  public function changeStatus(Request $request){
    $donor = Donor::findOrFail($request->input('donor_id'));
    $donor->is_active = $request->input('status');
    if($donor->save()){
      return json_encode(array('code' => 200, 'message'=> __('Status updated')));
    }else{
      return json_encode(array('code' => 500, 'message'=> __('Something went wrong, try again later')));
    }
  }

  private function asignIdentifier(){
    $donor = Donor::latest()->first();
    return $donor->identifier +1;
  }

  public function apiStore(SaveDonorRequest $request){
    $donor = $this->saveDonorWithoutAccess($request);
    $donor->is_temporal = 1;
    $donor->save();
    if($this->addNewDonorInCampaign($donor->id, $request->input('campaign'), $request)){
      return array('code'=> 200, 'message'=> __('Donor has been added successfully'));
    }else{
      return array('code'=> 500, 'message'=> __('Something went wrong, try again later'));
    }
  }
  
  private function addNewDonorInCampaign($donorId, $campaignId, $request){
    $campaign = Campaign::where('id',$campaignId)->with(['donors'])->first();
    $currentTurn = $campaign->donors->count();
    $currentTurn +=1;
    $campaignAt = Carbon::create($campaign->time_start);
    $timeTurn = $this->calculateTurn($currentTurn, $campaignAt, $campaign->frecuency, $campaign->frecuency_time);
    $campaigDonor = new CampaignDonor(['donor_id' => $donorId, 'turn' =>  $currentTurn,  'time_turn' => $timeTurn, 'ip_address' => $request->ip()]);
    $campaign->campaigndonors()->save($campaigDonor);
    return true;
  }

  private function calculateTurn($currentTurn, $campaignStartAt, $campaignFrecuencyDonors, $campaignFrecuencyTime){
    $calculated = $currentTurn/$campaignFrecuencyDonors;
    $rounded =  ceil($calculated);
    return $campaignStartAt->addMinutes(($campaignFrecuencyTime*$rounded)-$campaignFrecuencyTime);
  }

  private function saveDonorWithoutAccess($request){
    $donor = new Donor ($request->validated());
    $donor->profile_picture = '';
    $donor->user_id = 0;
    $identifier = $this->asignIdentifier();
    $donor->identifier = $identifier;
    $donor = $this->saveUploadedPicture($donor, $request);
    $donor->save();
    return $donor;
  }

  public function updateProfilePicture(Donor $donor, UploadProfilePictureRequest $request){
    if($request->has('profile_picture')){
      $request->file('profile_picture')->storeAs('avatars', $donor->id.'pf.jpg','profile_pictures');
      $donor->profile_picture = 'storage/profile/avatars/'.$donor->id.'pf.jpg';
      $donor->save();
      return redirect()->route('donors.show', $donor->id)->with('successMessage', __('Profile picture updated successfully'));
    }else{
      return redirect()->route('home')->with('errorMessage', __('Something went wrong, try again later'));
    }
  }

  public function showregistreview(){
    $bloodTypes = Donor::getEnum('bloodtype');
    $genderTypes = Donor::getEnum('gendertype');
    $donorTypes = Donor::getEnum('donortype');
    $states = State::all();
    $cities = City::all();
    return view('donor.register', compact('bloodTypes', 'genderTypes', 'donorTypes', 'states', 'cities'));
  }

  private function saveUploadedPicture($donor, $request){
    if($request->has('profile_picture')){
      $request->validated()['profile_picture']->storeAs('avatars', $donor->id.'pf.jpg','profile_pictures');
      $donor->profile_picture = 'storage/profile/avatars/'.$donor->id.'pf.jpg';
    }else{
      if($donor->gendertype=='M'){
        $donor->profile_picture = 'img/default_avatar_man.jpg';
      }else if($donor->gendertype=='F'){
        $donor->profile_picture = 'img/default_avatar_woman.jpg';
      }else{
        $donor->profile_picture = 'img/default_avatar.jpg';
      }
    }
    return $donor;
  }

  private function setUser(Request $request){
    $this->validator($request->all())->validate();
    $user = $this->createUser($request->all());
    try{
        $user->sendEmailVerificationNotification();
        return $user;
    }catch(Exception $e){
        $user->delete();
        return redirect()->route('donors.create')->with('errorMessage', __('Something went wrong, try again later'));
    }
  }

  private function createUser($data){
    return User::create([
      'name' => $data['name'],
      'email' => $data['email'],
      'password' => Hash::make($data['password']),
    ]);
  }

  protected function validator(array $data)
  {
    return Validator::make($data, [
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);
  }

  public function show(Donor $donor)
  {
    $campaigns = $donor->campaigns()->latest()->paginate(3);
    $numberOfDonations = $donor->campaigndonors()->where('donor_donated', 1)->count();
    return view('donor.show', compact('donor', 'campaigns', 'numberOfDonations'));
  }

  public function export() 
  {
    return Excel::download(new DonorsExport, 'donors.xlsx');
  }

  public function edit(Donor $donor)
  {
    $bloodTypes = Donor::getEnum('bloodtype');
    $genderTypes = Donor::getEnum('gendertype');
    $donorTypes = Donor::getEnum('donortype');
    $states = State::all();
    $cities = City::where('state_id', $donor->state_id)->get();
    return view('donor.edit', compact('donor', 'bloodTypes', 'donorTypes', 'genderTypes', 'states', 'cities'));
  }

  public function update(UpdateDonorRequest $request, Donor $donor)
  {
    if($donor->update($request->validated())){
      if($donor->user_id != 0){
        $donor->user()->update(['email' => $request->validated()['email'], 'name' => $request->validated()['name']]);
      }
      if(Auth::user()->is_admin){
        return redirect()->route('donors.index')->with('successMessage', __('Donor has been updated successfully'));
      }else{
        return redirect()->route('home')->with('successMessage', __('Donor has been updated successfully'));
      }
    }else{
      return redirect()->route('donors.index')->with('errorMessage', __('Something went wrong, try again later'));
    }
  }

  public function destroy(Donor $donor)
  {
    $imageFile = $donor->id.'pf.jpg';
    if($donor->user){
      if($donor->delete() &  $donor->user()->delete()){
        Storage::disk('profile_pictures')->delete('avatars/'.$imageFile);
        return array('message' => __('Donor has been deleted successfully'), 'code' => 200);
      }else{
        return array('message' => __('Something went wrong, try again later'), 'code' => 500);
      }
    }else{
      if($donor->delete()){
        return array('message' => __('Donor has been deleted successfully'), 'code' => 200);
      }else{
        return array('message' => __('Something went wrong, try again later'), 'code' => 500);
      }
    }
  }
}

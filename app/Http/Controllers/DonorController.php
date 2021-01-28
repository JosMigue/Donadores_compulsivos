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
    $this->middleware('auth');
    $this->middleware('admin')->except('store', 'edit', 'show', 'update', 'updateProfilePicture');
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
      if($donor->save()){
        if (Auth::check()) {
          $donor = $this->saveUploadedPicture($donor, $request);
          $donor->save();
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

  private function saveDonorWithoutAccess($request){
    $donor = new Donor ($request->validated());
    $donor->profile_picture = '';
    $donor->user_id = 0;
    $identifier = $this->asignIdentifier();
    $donor->identifier = $identifier;
    $donor->save();
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

  private function saveUploadedPicture($donor, $request){
    if($request->has('profile_picture')){
      $request->validated()['profile_picture']->storeAs('avatars', $donor->id.'pf.jpg','profile_pictures');
      $donor->profile_picture = 'storage/profile/avatars/'.$donor->id.'pf.jpg';
    }else if($request->has('captured_image') && $request->captured_image != null){
      $data = explode(',',$request->validated()['captured_image']);
      $profile_picture = base64_decode($data[1]);
      Storage::disk('profile_pictures')->put('avatars/'.$donor->id.'pf.jpg', $profile_picture);
      $donor->profile_picture = 'storage/profile/avatars/'.$donor->id.'pf.jpg';
    }else if($donor->profile_picture == ''){
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
    $availablesCampaigns = Campaign::with('city', 'state')->where('date_start','>',Carbon::now())->orderBy('date_start', 'ASC')->limit(6)->get();
    $campaigns = $donor->campaigns()->latest()->paginate(3);
    $numberOfIndividualDonations = $donor->individualdonations()->count();
    $numberOfDonations = $donor->campaigndonors()->where('donor_donated', 1)->count();
    $donationsInTotal = $numberOfDonations + $numberOfIndividualDonations;
    return view('donor.show', compact('donor', 'campaigns', 'numberOfDonations', 'donationsInTotal', 'numberOfIndividualDonations', 'availablesCampaigns'));
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
      $donor = $this->saveUploadedPicture($donor, $request);
      $donor->save();
      if($donor->user_id != 0){
        $donor->user()->update(['email' => $request->validated()['email'], 'name' => $request->validated()['name']]);
      }else if($request->has('email') && $donor->email != null){
        $dataUser = ['name' => $donor->name, 'email' => $donor->email, 'password' => '$2y$10$LLck65rXlXmE4Ac.UmKqfuJv9zsSOh6YG2hB0bdwwrEMv4epi1/H6'];
        $user = User::create($dataUser);
        $donor->user_id = $user->id;
        if($donor->save()){
          \Session::flash('infoMessage', __('This donor now has access to the system, remind default password is 1234567890. JL Marketing recommend that you make to know to the donor must to change his password as soon as possible. email must to be confirmed.')); 
        }
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

  public function changeLetterStatus(Donor $donor, $status){
    $donor->letter = $status;
    if($donor->save()){
      return json_encode(array('code' => '200', 'message' => __('Letter status changed')));
    }else{
      return json_encode(array('code' => '500', 'message' => __('Something went wrong, try again later')));
    }
  }
  
  public function changeBeTheMatchStatus(Donor $donor, $status){
    $donor->be_the_match = $status;
    if($donor->save()){
      return json_encode(array('code' => '200', 'message' => __('Be The Match status changed')));
    }else{
      return json_encode(array('code' => '500', 'message' => __('Something went wrong, try again later')));
    }
  }
}

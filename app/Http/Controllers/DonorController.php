<?php

namespace App\Http\Controllers;

use App\Donor;
use App\City;
use App\State;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\SaveDonorRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;

class DonorController extends Controller
{
  
  use RegistersUsers;
  
  public function index()
  {
    $donors = Donor::with(['city', 'state'])->latest()->paginate(5);
    return view('donor.index', compact('donors'));
  }

  public function create()
  {
    $bloodTypes = Donor::getEnum('bloodtype');
    $genderTypes = Donor::getEnum('gendertype');
    $states = State::all();
    $cities = City::all();
    return view('donor.create', compact('bloodTypes', 'genderTypes', 'states', 'cities'));
  }

  public function store(SaveDonorRequest $request)
  {
    $user = $this->setUser($request);
    $donor =  new Donor ($request->validated());
    $donor->user_id = $user->id;
    if($donor->save()){
      return redirect()->route('donors.create')->with('successMessage', __('Donor has been added successfully'));
    }else{
      return redirect()->route('donors.create')->with('errorMessage', __('Something went wrong, try again later'));
    }
  }

  private function setUser(Request $request){
    $this->validator($request->all())->validate();
    event(new Registered($user = $this->createUser($request->all())));
    return $this->registered($request, $user) ? : $user;
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
    return view('donor.show', compact('donor'));
  }

  public function edit(Donor $donor)
  {
    $bloodTypes = Donor::getEnum('bloodtype');
    $genderTypes = Donor::getEnum('gendertype');
    $states = State::all();
    $cities = City::where('state_id', $donor->state_id)->get();
    return view('donor.edit', compact('donor', 'bloodTypes', 'genderTypes', 'states', 'cities'));
  }

  public function update(SaveDonorRequest $request, Donor $donor)
  {
    if($donor->update($request->validated())){
      return redirect()->route('donors.index')->with('successMessage', __('Donor has been updated successfully'));
    }else{
      return redirect()->route('donors.index')->with('errorMessage', __('Something went wrong, try again later'));
    }
  }

  public function destroy(Donor $donor)
  {
    if($donor->delete()){
      return array('message' => __('Donor has been deleted successfully'), 'code' => 200);
    }else{
      return array('message' => __('Something went wrong, try again later'), 'code' => 500);
    }
  }
}

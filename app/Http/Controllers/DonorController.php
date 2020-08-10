<?php

namespace App\Http\Controllers;

use App\Donor;
use App\City;
use App\State;
use Illuminate\Http\Request;
use App\Http\Requests\SaveDonorRequest;

class DonorController extends Controller
{

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
    if(Donor::create($request->validated())){
      return redirect()->route('donors.create')->with('successMessage', __('Donor has been added successfully'));
    }else{
      return redirect()->route('donors.create')->with('errorMessage', __('Something went wrong, try again later'));
    }
  }

  public function show(Donor $donor)
  {
      //
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
      //
  }
}

<?php

namespace App\Http\Controllers;

use App\BloodBank;
use App\City;
use App\State;
use Illuminate\Http\Request;
use App\Http\Requests\SaveBloodBankRequest;
use App\Http\Requests\UpdateBloodBankRequest;

class BloodBankController extends Controller
{

  public function __construct(){
    $this->middleware('auth');
    $this->middleware('admin');
  }

  public function index()
  {
    $bloodBanks = BloodBank::with('city','state','user')->latest()->paginate(5);
    return view('bloodbank.index',compact('bloodBanks'));
  }

  public function create()
  {
    $states = State::all();
    $cities = City::all();
    return view('bloodbank.create', compact('cities', 'states'));
  }

  public function store(SaveBloodBankRequest $request)
  {
    if(BloodBank::create($request->validated())){
      return redirect()->route('bloodbanks.index')->with('successMessage', __('Blood bank added successfully'));
    }else{
      return redirect()->route('bloodbanks.index')->with('errorMessage', __('Something went wrong, try again later'));
    }
  }

  public function show(BloodBank $bloodBank)
  {
      //
  }

  public function edit(BloodBank $bloodbank)
  {
    $cities = City::where('state_id',$bloodbank->state_id)->get();
    $states =  State::all();
    return view('bloodbank.edit', compact('bloodbank', 'cities', 'states'));
  }

  public function update(UpdateBloodBankRequest $request, BloodBank $bloodbank)
  {
    if($bloodbank->update($request->validated())){
      return redirect()->route('bloodbanks.index')->with('successMessage', __('Blood bank updated successfully'));
    }else{
      return redirect()->route('bloodbanks.index')->with('errorMessage', __('Something went wrong, try again later'));
    }
  }

  public function destroy(BloodBank $bloodbank)
  {
    if($bloodbank->delete()){
      return array('message' =>  __('Blood bank has been deleted succesfully'), 'code' => 200);
    }else{
      return array('message' =>  __('Something went wrong, try again later'), 'code' => 404);
    }
  }
}

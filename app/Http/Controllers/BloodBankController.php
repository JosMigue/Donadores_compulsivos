<?php

namespace App\Http\Controllers;

use App\BloodBank;
use App\City;
use App\State;
use Illuminate\Http\Request;
use App\Http\Requests\SaveBloodBankRequest;

class BloodBankController extends Controller
{

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

  /**
   * Display the specified resource.
   *
   * @param  \App\BloodBank  $bloodBank
   * @return \Illuminate\Http\Response
   */
  public function show(BloodBank $bloodBank)
  {
      //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\BloodBank  $bloodBank
   * @return \Illuminate\Http\Response
   */
  public function edit(BloodBank $bloodBank)
  {
      //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\BloodBank  $bloodBank
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, BloodBank $bloodBank)
  {
      //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\BloodBank  $bloodBank
   * @return \Illuminate\Http\Response
   */
  public function destroy(BloodBank $bloodBank)
  {
      //
  }
}

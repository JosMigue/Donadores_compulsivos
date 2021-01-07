<?php

namespace App\Http\Controllers;

use App\IndividualDonation;
use App\Donor;
use App\BloodBank;
use App\Http\Requests\SaveIndividualDonationRequest;
use App\Http\Requests\UpdateIndividualDonationRequest;
use Illuminate\Http\Request;

class IndividualDonationController extends Controller
{
  public function __construct(){
    $this->middleware('auth');
    $this->middleware('admin')->only(['store']);
  }

  public function show($donorId){
    $donor = Donor::where('id', $donorId)->first();
    $individualDonations = $donor->individualDonations()->with('bloodbank', 'bloodbank.city', 'bloodbank.state')->get();
    return json_encode(array('individualDonations' => $individualDonations));
  }

  public function edit($individual_donation){
    $individualDonation = IndividualDonation::where('id', $individual_donation)->with('bloodbank', 'bloodbank.city', 'bloodbank.state')->first();
    $bloodbanks = BloodBank::with('state','city')->get();
    return view('individualdonation.edit', compact('individualDonation', 'bloodbanks'));
  }

  public function update(UpdateIndividualDonationRequest $request, IndividualDonation $individual_donation){
    if($individual_donation->update($request->validated())){
      return redirect()->route('donors.show', $individual_donation->donor_id)->with('successMessage', __('Individual donation updated successfully'));
    }else{
      return redirect()->route('donors.show', $individual_donation->donor_id)->with('errorMessage', __('Something went wrong, try again later'));
    }

  }

  public function store(SaveIndividualDonationRequest $request)
  {
    if(IndividualDonation::create($request->validated())){
      return json_encode(array('code' => 200, 'message'=> __('Individual donation added successfully')));
    }else{
      return json_encode(array('code' => 500, 'message'=> __('Something went wrong, try again later')));
    }
  }
}

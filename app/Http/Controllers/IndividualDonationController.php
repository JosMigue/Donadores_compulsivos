<?php

namespace App\Http\Controllers;

use App\IndividualDonation;
use App\Donor;
use App\Http\Requests\SaveIndividualDonationRequest;
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

  public function store(SaveIndividualDonationRequest $request)
  {
    if(IndividualDonation::create($request->validated())){
      return json_encode(array('code' => 200, 'message'=> __('Individual donation added successfully')));
    }else{
      return json_encode(array('code' => 500, 'message'=> __('Something went wrong, try again later')));
    }
  }
}

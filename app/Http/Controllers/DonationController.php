<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Campaign;
use App\CampaignDonor;
use App\Donor;
use App\User;
use App\TemporalDonor;
use Carbon\Carbon;

class DonationController extends Controller
{
  public function __construct(){
    $this->middleware('auth');
    $this->middleware('admin');
  }
  
  public function update(Campaign $campaign, Request $request)
  {
    if($request->has('donor_id')){
      $currentDate = Carbon::now();
      $campaignDonor;
      $donor;
      if($request->donor_status == 1){
        $campaignDonor = $campaign->campaigndonors->where('donor_id', $request->donor_id)->first();
        $donor = Donor::findOrFail($request->donor_id );
      }else{
        $campaignDonor = $campaign->campaigndonors->where('temporal_donor_id', $request->donor_id)->first();
        $donor = TemporalDonor::findOrFail($request->donor_id );
      }
      if($request->attribute == 1){
        if($request->status){
          CampaignDonor::where('id',$campaignDonor->id)->update(['donor_attended'=> $request->status, 'donation_date' => $currentDate]);
        }else{
          CampaignDonor::where('id',$campaignDonor->id)->update(['donor_attended'=> $request->status, 'donor_donated'=> $request->status, 'donation_date' => $currentDate]);
        }
      }else{
        CampaignDonor::where('id',$campaignDonor->id)->update(['donor_donated'=> $request->status, 'donation_date' => $currentDate]);
        if($request->status == 1 && $request->donor_status == 0){
          $temporalDonorData = $donor->toArray();
          $donor->delete();
          $donor = $this->createDonor($temporalDonorData);
          $campaignDonor->donor_id = $donor->id;
          $campaignDonor->temporal_donor_id = null;
          $campaignDonor->save();
        }
      }
      if($request->status == 1 && $request->attribute == 2){
        $donor->last_donate_date = $currentDate;
        $donor->save();
      }else if($request->status == 0 && $request->attribute == 2){
        $donor->last_donate_date = null;
        $donor->save();
      }
    }
  }

  private function createDonor($dataDonor){
    $user = $this->createUser($dataDonor);
    if($user){
      array_push($dataDonor,array('user_id' => $user->id));
    }
    return $donor = Donor::create($dataDonor);
  }

  private function createUser($data){
    if($data['email']){
      $dataUser = ['name' => $data['name'], 'email' => $data['email'], 'password' => '$2y$10$LLck65rXlXmE4Ac.UmKqfuJv9zsSOh6YG2hB0bdwwrEMv4epi1/H6'];
      return User::create($dataUser);
    }else{
      return false;
    }

  }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Campaign;
use App\CampaignDonor;
use App\Donor;
use Carbon\Carbon;

class DonationController extends Controller
{
  public function update(Campaign $campaign, Request $request)
  {
    if($request->has('donor_id')){
      $currentDate = Carbon::now();
      $campaignDonor = $campaign->campaigndonors->where('donor_id', $request->donor_id)->first();
      if($request->attribute == 1){
        if($request->status){
          CampaignDonor::where('id',$campaignDonor->id)->update(['donor_attended'=> $request->status, 'donation_date' => $currentDate]);
        }else{
          CampaignDonor::where('id',$campaignDonor->id)->update(['donor_attended'=> $request->status, 'donor_donated'=> $request->status, 'donation_date' => $currentDate]);
        }
      }else{
        CampaignDonor::where('id',$campaignDonor->id)->update(['donor_donated'=> $request->status, 'donation_date' => $currentDate]);
      }
      $donor = Donor::find($request->donor_id);
      if($request->status == 1){
        $donor->last_donate_date = $currentDate;
        $donor->is_active = 1;
        $donor->save();
      }else{
        $donor->last_donate_date = null;
        $donor->is_active = 0;
        $donor->save();
      }
    }
  }
}

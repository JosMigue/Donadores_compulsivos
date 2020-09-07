<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Campaign;
use App\CampaignDonor;
use Carbon\Carbon;

class DonationController extends Controller
{
  public function update(Campaign $campaign, Request $request)
  {
    if($request->has('donor_id')){
      $campaignDonor = $campaign->campaigndonors->where('donor_id', $request->donor_id)->first();
      CampaignDonor::where('id',$campaignDonor->id)->update(['donor_donated'=> $request->status, 'donation_date' => Carbon::now()]);
    }
  }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\CampaignDonor;
use App\Campaign;
use App\Donor;

class CampaignDonorController extends Controller
{

  public function __construct(){
    $this->middleware('auth');
  }

  public function show(Campaign $campaign, Donor $donor){
    if($this->isCurrentCampaign($campaign)){
      if($donor->id == Auth::user()->id){
        return view('campaigndonor.show', compact('campaign', 'donor'));
      }else{
        return redirect()->route('home')->with('errorMessage',__('Something went wrong, try again later'));
      }
    }else{
      return redirect()->route('home')->with('errorMessage', __('This campaign is no longer available'));
    }
  }

  private function isCurrentCampaign($campaign){
    $dateTimeStart = Carbon::create($campaign->date_start.$campaign->time_start);
    $dateTimeFinish = Carbon::create($campaign->date_finish.$campaign->time_finish);
    $currentDate = Carbon::now();
    if($currentDate > $dateTimeStart & $currentDate < $dateTimeFinish){
     return true;
    }else{
      return false;
    }
  }

  public function store(Request $request){
    /* CampaignDonor::create(); */
  }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NotifyDonorCampaignError;
use App\Http\Requests\CampaignDonorRequest;
use Carbon\Carbon;
use App\CampaignDonor;
use App\Campaign;
use App\Donor;

class CampaignDonorController extends Controller
{

  public function __construct(){
    $this->middleware('auth');
  }

  public function show(Campaign $campaign){
    if($this->isCurrentCampaign($campaign)){
      return view('campaigndonor.show', compact('campaign'));
    }else{
      return redirect()->route('home')->with('errorMessage', __('This campaign is no longer available'));
    }
  }

  private function isCurrentCampaign($campaign){
    $dateTimeStart = Carbon::create($campaign->date_start.$campaign->time_start);
    $dateTimeFinish = Carbon::create($campaign->date_finish.$campaign->time_finish);
    $currentDate = Carbon::now();
    if($currentDate < $dateTimeStart){
     return true;
    }else{
      return false;
    }
  }

  public function store(CampaignDonorRequest $request){
    if($request->validated()['donor'] == Auth::user()->id){
      $campaign = Campaign::findOrFail($request->validated()['campaign']);
      $donor = Donor::where('user_id',$request->validated()['donor'])->first();
      $campaigDonor = new CampaignDonor(['donor_id' => $donor->id, 'ip_address' => $request->ip()]);
      if($campaign->campaigndonors()->save($campaigDonor)){
        return redirect()->route('home')->with('message', __('Thanks for get involved on this campaign'));
      }else{
        return redirect()->route('home')->with('errorMessage', __('Something went wrong, try again later'));
      }
    }else{
      return redirect()->route('home')->with('errorMessage', __('Something went wrong, try again later'));
    }
  }
}

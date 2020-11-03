<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NotifyDonorCampaignError;
use App\Http\Requests\CampaignDonorRequest;
use App\Notifications\SendTurnDonation;
use Carbon\Carbon;
use App\CampaignDonor;
use App\Campaign;
use App\Donor;

class CampaignDonorController extends Controller
{

  public function __construct(){
/*     $this->middleware('auth');
    $this->middleware('verified'); */
  }

  public function show(Campaign $campaign, Donor $donor){
    $donorAuth = $donor->id;
    if(Auth::check()){
      if(Auth::user()->is_admin){
        return redirect()->route('home')->with('errorMessage', __('An administrator cannot register for a campaign'));
      }else{
        if($this->isAvailableCampaign($campaign)){
          if($campaign->campaigndonors->where('donor_id',$donorAuth)->count() == 0){
            $donorAuth = Auth::user()->id;
            return view('campaigndonor.show', compact('campaign', 'donorAuth'));
          }else{
            return  redirect()->route('home')->with('information', __('It looks like you have already checked in on this campaign, please check your email'));
          }
        }else{
          return redirect()->route('home')->with('errorMessage', __('This campaign is no longer available'));
        } 
      }
    }else{
      if($this->isAvailableCampaign($campaign)){
        if($campaign->campaigndonors->where('donor_id',$donorAuth)->count() == 0){
          return view('campaigndonor.show', compact('campaign', 'donorAuth'));
        }else{
          return redirect('/')->with('information', __('It looks like you have already checked in on this campaign, please check your email'));
        }
      }else{
        return redirect('/')->with('errorMessage', __('This campaign is no longer available'));
      } 
    }
  }

  private function isAvailableCampaign($campaign){
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
    if(Auth::check()){
      if($request->validated()['donor'] == Auth::user()->id){
        $campaign = Campaign::where('id',$request->validated()['campaign'])->with(['donors'])->first();
        $donor = Donor::where('user_id',$request->validated()['donor'])->first();
        $currentTurn = $campaign->donors->count();
        $currentTurn +=1;
        $campaigDonor = new CampaignDonor(['donor_id' => $donor->id, 'turn' =>  $currentTurn, 'ip_address' => $request->ip()]);
        if($campaign->campaigndonors()->save($campaigDonor)){
          $this->sendEmailWithTurn($donor, $currentTurn);
          return redirect()->route('home')->with('successMessage', __('Thanks for get involved on this campaign'))->with('information', __('A email has been sent to you with information about your turn. Thanks for beign part of this ❤️'));
        }else{
          return redirect()->route('home')->with('errorMessage', __('Something went wrong, try again later'));
        }
      }else{
        return redirect()->route('home')->with('errorMessage', __('Something went wrong, try again later'));
      }
    }else{
      $campaign = Campaign::where('id',$request->validated()['campaign'])->with(['donors'])->first();
      $donor = Donor::where('id',$request->validated()['donor'])->first();
      $currentTurn = $campaign->donors->count();
      $currentTurn +=1;
      $campaigDonor = new CampaignDonor(['donor_id' => $donor->id, 'turn' =>  $currentTurn, 'ip_address' => $request->ip()]);
      if($campaign->campaigndonors()->save($campaigDonor)){
        $this->sendEmailWithTurn($donor, $currentTurn);
        return redirect('/')->with('successMessage', __('Thanks for get involved on this campaign'))->with('information', __('A email has been sent to you with information about your turn. Thanks for beign part of this ❤️'));
      }else{
        return redirect('/')->with('errorMessage', __('Something went wrong, try again later'));
      }
    }
  }
  
  private function sendEmailWithTurn($donor, $currentTurn){
    $donor->notify(new SendTurnDonation($currentTurn));
  }
}


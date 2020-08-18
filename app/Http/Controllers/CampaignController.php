<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\City;
use App\State;
use App\Donor;
use Illuminate\Http\Request;
use App\Http\Requests\SaveCampaignRequest;
use App\Http\Requests\UpdateCampaignRequest;
use App\Notifications\CampaignNotify;
use Illuminate\Support\Facades\Auth;

class CampaignController extends Controller
{

	public function __construct(){
		$this->middleware('auth');
		$this->middleware('admin');
	}

  public function index()
  {
    $campaigns = Campaign::with('user', 'state', 'city')->latest()->paginate(5);
    return view('campaign.index', compact('campaigns'));
	}
	
  public function create()
  {
    $cities = City::all();
    $states = State::all();
    return view('campaign.create', compact('cities', 'states'));
  }

  public function store(SaveCampaignRequest $request)
  {
		if($request->validated()['user_id']== Auth::user()->id){
      $campaign =Campaign::create($request->validated());
      $this->sendEmail($campaign);
			if($campaign){
				return redirect()->route('campaigns.index')->with('successMessage',__('Campaign added successfully'));
			}else{
				return redirect()->route('campaigns.index')->with('errorMessage',__('Something went wrong, try again later'));
			}
		}else{
			return redirect()->route('campaigns.index')->with('errorMessage',__('I know what you do ;)'));
		}
  }

  private function sendEmail($campaign){
    $donors = Donor::all();
    foreach ($donors as  $donor) {
      $donor->notify(new CampaignNotify($campaign, $donor));
    }
  }

  public function show(Campaign $campaign)
  {
    $campaign = $campaign->where('id', $campaign->id)->with('city','state')->first();
    $donors = $campaign->donors()->paginate(3);
    return view('campaign.show', compact('campaign', 'donors'));
  }

  public function edit(Campaign $campaign)
  {
		$cities = City::where('state_id', $campaign->state_id)->get();
		$states = State::all();
		return view('campaign.edit', compact('cities', 'states', 'campaign'));
  }

  public function update(UpdateCampaignRequest $request, Campaign $campaign)
  {
    if($campaign->update($request->validated())){
			return redirect()->route('campaigns.index')->with('successMessage',__('Campaign updated successfully'));
		}else{
			return redirect()->route('campaigns.index')->with('errorMessage',__('Something went wrong, try again later'));
		}
  }

  public function destroy(Campaign $campaign)
  {
    if($campaign->delete()){
			return array('message' =>  __('Campaign deleted successfully'), 'code' => 200);
		}else{
			return array('message' =>  __('Something went wrong, try again later'), 'code' => 404);
		}
  }
}

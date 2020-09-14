<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\City;
use App\State;
use App\Donor;
use App\BloodBank;
use Excel;
use App\Exports\CampaignsExport;
use Illuminate\Http\Request;
use App\Http\Requests\SaveCampaignRequest;
use App\Http\Requests\UpdateCampaignRequest;
use App\Notifications\CampaignNotify;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;


class CampaignController extends Controller
{

	public function __construct(){
		$this->middleware('auth');
    $this->middleware('admin');
    $this->middleware('verified');
	}

  public function index()
  {
    $campaigns = Campaign::with('user', 'state', 'city', 'bloodbank')->latest()->paginate(5);
    return view('campaign.index', compact('campaigns'));
	}
	
  public function create()
  {
    $bloodTypes = Donor::getEnum('bloodtype');
    $campaignTypes = Campaign::getEnum('campaigntype');
    $bloodBanks = BloodBank::all();
    $cities = City::all();
    $states = State::all();
    return view('campaign.create', compact('cities', 'states', 'bloodTypes', 'campaignTypes', 'bloodBanks'));
  }

  public function store(SaveCampaignRequest $request)
  {
 		if($request->validated()['user_id']== Auth::user()->id){
      $campaign = Campaign::create($request->validated());
      $this->sendEmail($campaign, $request);
			if($campaign){
				return redirect()->route('campaigns.index')->with('successMessage',__('Campaign added successfully'));
			}else{
				return redirect()->route('campaigns.index')->with('errorMessage',__('Something went wrong, try again later'));
			}
		}else{
			return redirect()->route('campaigns.index')->with('errorMessage',__('I know what you do ;)'));
		} 
  }

  public function export() 
  {
    return Excel::download(new CampaignsExport, 'campaigns.xlsx');
  }

  private function sendEmail($campaign, $request){
    $donors = Donor::all();
    $hasFilter = false;
    if($request->has('blood_type_filter')){
      $bloodTypes = $request->blood_type_filter;
      $donors  = Donor::whereIn('bloodtype', $bloodTypes);
      $hasFilter = true;
    }
    if($request->has('state_id_filter')){
      $state = $request->state_id_filter;
      $donors->where('state_id', $state);
      $hasFilter = true;
    }
    $hasFilter ? $donors = $donors->get() : '';
    Notification::send($donors, new CampaignNotify($campaign));
  }

  public function show(Campaign $campaign)
  {
    $campaign = $campaign->where('id', $campaign->id)->with('city','state')->first();
    $donors = $campaign->donors()->paginate(5);
    $bloodTypes = Donor::getEnum('bloodtype');
    $genderTypes = Donor::getEnum('gendertype');
    return view('campaign.show', compact('campaign', 'donors', 'bloodTypes', 'genderTypes'));
  }

  public function edit(Campaign $campaign)
  {
		$cities = City::where('state_id', $campaign->state_id)->get();
    $states = State::all();
    $campaignTypes = Campaign::getEnum('campaigntype');
    $bloodBanks = BloodBank::all();
		return view('campaign.edit', compact('cities', 'states', 'campaign', 'campaignTypes', 'bloodBanks'));
  }

  public function update(UpdateCampaignRequest $request, Campaign $campaign)
  {
    if($campaign->update($request->validated())){
      $campaign->campaigntype == 'c1' ? $campaign->blood_bank_id = null : $campaign->place = null; 
      $campaign->save();
			return redirect()->route('campaigns.index')->with('successMessage',__('Campaign updated successfully'));
		}else{
			return redirect()->route('campaigns.index')->with('errorMessage',__('Something went wrong, try again later'));
		}
  }

  public function destroy(Campaign $campaign)
  {
    $campaignDonor = $campaign->campaigndonors();
    if($campaign->delete()){
      $campaignDonor->delete();
			return array('message' =>  __('Campaign deleted successfully'), 'code' => 200);
		}else{
			return array('message' =>  __('Something went wrong, try again later'), 'code' => 404);
		}
  }
}

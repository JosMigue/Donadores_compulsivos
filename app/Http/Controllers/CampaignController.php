<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\City;
use App\State;
use Illuminate\Http\Request;
use App\Http\Requests\SaveCampaignRequest;
use App\Http\Requests\UpdateCampaignRequest;
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
			if(Campaign::create($request->validated())){
				return redirect()->route('campaigns.index')->with('successMessage',__('Campaign added successfully'));
			}else{
				return redirect()->route('campaigns.index')->with('errorMessage',__('Something went wrong, try again later'));
			}
		}else{
			return redirect()->route('campaigns.index')->with('errorMessage',__('I know what you do ;)'));
		}
  }

  public function show(Campaign $campaign)
  {
    
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

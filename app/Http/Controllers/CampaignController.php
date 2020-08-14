<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\City;
use App\State;
use Illuminate\Http\Request;
use App\Http\Requests\SaveCampaignRequest;
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
      //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Campaign  $campaign
   * @return \Illuminate\Http\Response
   */
  public function edit(Campaign $campaign)
  {
      //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Campaign  $campaign
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Campaign $campaign)
  {
      //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Campaign  $campaign
   * @return \Illuminate\Http\Response
   */
  public function destroy(Campaign $campaign)
  {
      //
  }
}

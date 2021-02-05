<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\City;
use App\State;
use App\Donor;
use App\BloodBank;
use Excel;
use Carbon\Carbon;
use App\Exports\CampaignsExport;
use Illuminate\Http\Request;
use App\Http\Requests\SaveCampaignRequest;
use App\Http\Requests\UpdateCampaignRequest;
use App\Http\Requests\UploadCampaignImageRequest;
use App\Notifications\CampaignNotify;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;


class CampaignController extends Controller
{

	public function __construct(){
		$this->middleware('auth')->except('showComingCampaigns');
    $this->middleware('admin')->except('showComingCampaigns');
    $this->middleware('verified')->except('showComingCampaigns');
	}

  public function index()
  {
    $campaigns = Campaign::with('user', 'state', 'city', 'bloodbank')->latest()->paginate(10);
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
      $campaign = new Campaign ($request->validated());
      $campaign->campaign_image = '';
			if($campaign->save()){
        $this->saveUploadedPicture($campaign, $request);
        $this->sendEmail($campaign, $request);
				return redirect()->route('campaigns.index')->with('successMessage',__('Campaign added successfully'));
			}else{
				return redirect()->route('campaigns.index')->with('errorMessage',__('Something went wrong, try again later'));
			}
		}else{
			return redirect()->route('campaigns.index')->with('errorMessage',__('I know what you do ;)'));
		} 
  }

  
  private function saveUploadedPicture($campaign, $request){
    if($request->has('campaign_image')){
      $request->validated()['campaign_image']->storeAs('images', $campaign->id.'cp.jpg','campaign_images');
      $campaign->campaign_image = 'storage/campaigns/images/'.$campaign->id.'cp.jpg';
      $campaign->save();
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
      $hasFilter ? $donors->where('state_id', $state) : $donors = Donor::where('state_id', $state);
      $hasFilter = true;
    }
    $hasFilter ? $donors = $donors->get() : '';
    try{
      Notification::send($donors, new CampaignNotify($campaign));
    }catch(\Swift_TransportException $e){
      if($e->getMessage()) {
        return redirect()->route('campaigns.index')->with('errorMessage',$e->getMessage());
      }
    }
    catch(Exception $e){
      return redirect()->route('campaigns.index')->with('errorMessage',__('Campaign has been added but the email has not been sent to donors, there was an error when trying to make conection with smtp server. Sorry for inconvenencies'));
    }
  }

  public function show(Campaign $campaign)
  {
    $campaign = $campaign->where('id', $campaign->id)->with('city','state')->first();
  /*   $donors = $campaign->donors()->paginate(5); */
    $bloodTypes = Donor::getEnum('bloodtype');
    $genderTypes = Donor::getEnum('gendertype');
    $donorTypes = Donor::getEnum('donortype');
    return view('campaign.show', compact('campaign', 'bloodTypes', 'genderTypes', 'donorTypes'));
  }

  public function showComingCampaigns(){
    $campaigns = Campaign::with('city', 'state')->where('date_start','>',Carbon::now())->orderBy('date_start', 'ASC')->limit(6)->get();
    return view('campaign.listing', compact('campaigns'));
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

  private function UpdateUploadedPicture($campaign, $request){
    if($request->has('campaign_image')){
      $request->campaign_image->storeAs('images', $campaign->id.'cp.jpg','campaign_images');
    }
  }

  public function destroy(Campaign $campaign)
  {
    $campaignDonor = $campaign->campaigndonors();
    $imageFile = $campaign->id.'pf.jpg';
    if($campaign->delete()){
      $campaignDonor->delete();
			return array('message' =>  __('Campaign deleted successfully'), 'code' => 200);
		}else{
			return array('message' =>  __('Something went wrong, try again later'), 'code' => 404);
		}
  }

  public function updateCampaignImage(Campaign $campaign, UploadCampaignImageRequest $request){
    if($request->has('campaign_image')){
      $request->validated()['campaign_image']->storeAs('images', $campaign->id.'cp.jpg','campaign_images');
      return redirect()->route('campaigns.show', $campaign->id)->with('successMessage', __('Image updated successfully'));
    }else{
      return redirect()->route('home')->with('errorMessage', __('Something went wrong, try again later'));
    }
  }

  public function createTimePicker($campaign){
    $currentCampaign = Campaign::findOrFail($campaign);
    $campaignEndat = Carbon::create($currentCampaign->time_finish);
    $step = $currentCampaign->frecuency_time;
    $timeList = [];
    $breaker = true;
    $count = 0;
    while($breaker){
      $time = Carbon::create($currentCampaign->time_start);
      $minutesToAdd = $count * $step;
      $time = $time->addMinutes($minutesToAdd);
      array_push($timeList,$time->format('H:i'));
      $count= $count + 1;
      if($campaignEndat->format('H:i') == $time->format('H:i') || $campaignEndat < $time){
        $breaker = false;
      }
    }
    return $timeList;
  }

  public function availableCampaigns($currentCampaign){
    return Campaign::with('city', 'state')->where('id','!=', $currentCampaign)->where('date_start','>',Carbon::now())->orderBy('date_start', 'ASC')->get();
  }
}

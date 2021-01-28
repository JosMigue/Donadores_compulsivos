<?php

namespace App\Http\Controllers;

use App\BloodBank;
use App\City;
use App\State;
use Excel;
use App\Exports\BloodBanksExport;
use Illuminate\Http\Request;
use App\Http\Requests\SaveBloodBankRequest;
use App\Http\Requests\UpdateBloodBankRequest;
use Illuminate\Support\Facades\Auth;

class BloodBankController extends Controller
{

  public function __construct(){
    $this->middleware('auth');
    $this->middleware('admin')->except(['getBloodBanksData']);
    $this->middleware('verified');
  }

  public function index()
  {
    $bloodBanks = BloodBank::with('city','state')->orderBy('state_id', 'asc')->paginate(30);
    return view('bloodbank.index',compact('bloodBanks'));
  }

  public function getBloodBanksData()
  {
    return BloodBank::with('city','state')->get();
  }

  public function create()
  {
    $states = State::all();
    $cities = City::all();
    return view('bloodbank.create', compact('cities', 'states'));
  }

  public function store(SaveBloodBankRequest $request)
  {
    $arrayOfDays = [];
    foreach($request->validated()['days'] as $index =>  $day){
      array_push($arrayOfDays, [$index => $day]);
    }
    $serializedArray = serialize($arrayOfDays);
    $bloodBank = $this->buildBloodBank($request, $serializedArray);
    if(BloodBank::create($bloodBank)){
      return redirect()->route('bloodbanks.index')->with('successMessage', __('Blood bank added successfully'));
    }else{
      return redirect()->route('bloodbanks.index')->with('errorMessage', __('Something went wrong, try again later'));
    }
  }

  private function buildBloodBank($request, $array){
    return [
      'name' => $request->validated()['name'],
      'email' => $request->validated()['email'],
      'extension_number' => $request->validated()['extension_number'],
      'phone' => $request->validated()['phone'],
      'contact_person' => $request->validated()['contact_person'],
      'contact_person_mobile' => $request->validated()['contact_person_mobile'],
      'address' => $request->validated()['address'],
      'postal_code' => $request->validated()['postal_code'],
      'city_id' => $request->validated()['city_id'],
      'state_id' => $request->validated()['state_id'],
      'user_id' => Auth::user()->id,
      'days' => $array,
      'hyperlink' => $this->purifyHiperlink($request->validated()['hyperlink']),
      'google_link' => $request->validated()['google_link']
    ];
  }

  private function purifyHiperlink($hyperlink){
    if (strpos($hyperlink, 'https://')!== false) {
      return str_replace('https://','', $hyperlink);
    }else if(strpos($hyperlink, 'http://')!== false){
      return str_replace('http://','', $hyperlink);
    }
    return $hyperlink;
  }

  public function show(BloodBank $bloodbank){
    $businessDays = unserialize($bloodbank->days);
    return view('bloodbank.show', compact('bloodbank', 'businessDays'));
  }

  public function export() 
  {
    return Excel::download(new BloodBanksExport, 'bloodbanks.xlsx');
  }

  public function edit(BloodBank $bloodbank)
  {
    $cities = City::where('state_id',$bloodbank->state_id)->get();
    $states =  State::all();
    $days = unserialize($bloodbank->days);
    return view('bloodbank.edit', compact('bloodbank', 'cities', 'states', 'days'));
  }

  public function update(UpdateBloodBankRequest $request, BloodBank $bloodbank)
  {
    $arrayOfDays = [];
    foreach($request->validated()['days'] as $index =>  $day){
      array_push($arrayOfDays, [$index => $day]);
    }
    $serializedArray = serialize($arrayOfDays);
    $bloodBankUpdated = $this->buildBloodBank($request, $serializedArray);
    if($bloodbank->update($bloodBankUpdated)){
      return redirect()->route('bloodbanks.index')->with('successMessage', __('Blood bank updated successfully'));
    }else{
      return redirect()->route('bloodbanks.index')->with('errorMessage', __('Something went wrong, try again later'));
    }
  }

  public function destroy(BloodBank $bloodbank)
  {
    $campaigns = $bloodbank->campaigns;
    if($bloodbank->delete()){
      $this->changeRelatedCampaignsWithBankBlood($campaigns);
      return array('message' =>  __('Blood bank has been deleted succesfully'), 'code' => 200);
    }else{
      return array('message' =>  __('Something went wrong, try again later'), 'code' => 404);
    }
  }

  private function changeRelatedCampaignsWithBankBlood($campaigns){
    foreach ($campaigns as $key => $campaign) {
      $campaign->campaigntype = 'c1';
      $campaign->place = __('Blood bank associated has been deleted.');
      $campaign->save();
    }
  }
}

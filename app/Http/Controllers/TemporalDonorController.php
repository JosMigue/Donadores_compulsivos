<?php

namespace App\Http\Controllers;

use App\TemporalDonor;
use App\Campaign;
use App\CampaignDonor;
use App\Http\Requests\saveTemporalDonorRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TemporalDonorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveTemporalDonorRequest $request)
    {
      $temporalDonor = TemporalDonor::create($request->validated());
      if($this->addNewDonorInCampaign($temporalDonor->id, $request->input('campaign'), $request)){
        return array('code'=> 200, 'message'=> __('Donor has been added successfully'));
      }else{
        return array('code'=> 500, 'message'=> __('Something went wrong, try again later'));
      }
    }

    private function addNewDonorInCampaign($donorId, $campaignId, $request){
      $campaign = Campaign::where('id',$campaignId)->with(['donors', 'temporaldonors'])->first();
      $currentTurn = $campaign->donors->count() + $campaign->temporaldonors->count();
      $currentTurn +=1;
      $campaignAt = Carbon::create($campaign->time_start);
      $timeTurn = $this->calculateTurn($currentTurn, $campaignAt, $campaign->frecuency, $campaign->frecuency_time);
      $campaigDonor = new CampaignDonor(['temporal_donor_id' => $donorId, 'turn' =>  $currentTurn,  'time_turn' => $timeTurn, 'ip_address' => $request->ip()]);
      $campaign->campaigndonors()->save($campaigDonor);
      return true;
    }

    private function saveUploadedPicture($temporalDonor, $request){
      if($request->has('profile_picture')){
        $request->validated()['profile_picture']->storeAs('avatars', $temporalDonor->id.'pf.jpg','profile_pictures');
        $temporalDonor->profile_picture = 'storage/profile/avatars/'.$temporalDonor->id.'pf.jpg';
      }else{
        if($temporalDonor->gendertype=='M'){
          $temporalDonor->profile_picture = 'img/default_avatar_man.jpg';
        }else if($temporalDonor->gendertype=='F'){
          $temporalDonor->profile_picture = 'img/default_avatar_woman.jpg';
        }else{
          $temporalDonor->profile_picture = 'img/default_avatar.jpg';
        }
      }
      return $temporalDonor;
    }

    private function calculateTurn($currentTurn, $campaignStartAt, $campaignFrecuencyDonors, $campaignFrecuencyTime){
      $calculated = $currentTurn/$campaignFrecuencyDonors;
      $rounded =  ceil($calculated);
      return $campaignStartAt->addMinutes(($campaignFrecuencyTime*$rounded)-$campaignFrecuencyTime);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TemporalDonor  $temporalDonor
     * @return \Illuminate\Http\Response
     */
    public function show(TemporalDonor $temporalDonor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TemporalDonor  $temporalDonor
     * @return \Illuminate\Http\Response
     */
    public function edit(TemporalDonor $temporalDonor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TemporalDonor  $temporalDonor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TemporalDonor $temporalDonor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TemporalDonor  $temporalDonor
     * @return \Illuminate\Http\Response
     */
    public function destroy(TemporalDonor $temporalDonor)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
  public function index()
  {
    $campaigns = Campaign::with('user', 'state', 'city')->latest()->paginate(5);
    return view('campaign.index', compact('campaigns'));
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
  public function store(Request $request)
  {
      //
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Campaign  $campaign
   * @return \Illuminate\Http\Response
   */
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

<?php

namespace App\Http\Controllers;

use App\BloodBank;
use Illuminate\Http\Request;

class BloodBankController extends Controller
{

  public function index()
  {
    $bloodBanks = BloodBank::with('city','state','user')->latest()->paginate(5);
    return view('bloodbank.index',compact('bloodBanks'));
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
   * @param  \App\BloodBank  $bloodBank
   * @return \Illuminate\Http\Response
   */
  public function show(BloodBank $bloodBank)
  {
      //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\BloodBank  $bloodBank
   * @return \Illuminate\Http\Response
   */
  public function edit(BloodBank $bloodBank)
  {
      //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\BloodBank  $bloodBank
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, BloodBank $bloodBank)
  {
      //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\BloodBank  $bloodBank
   * @return \Illuminate\Http\Response
   */
  public function destroy(BloodBank $bloodBank)
  {
      //
  }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\SaveAdminRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;

class AdminController extends Controller
{
  use RegistersUsers;

  public function __construct(){
    $this->middleware('auth');
    $this->middleware('admin')->except('destroy');
    $this->middleware('superadmin')->only('destroy');
  }

  public function index()
  {
    $admins = User::where('is_admin',1)->orWhere('is_admin',2)->latest()->get();
    return view('admin.index',compact('admins'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('admin.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(SaveAdminRequest $request)
  {
    $dataAdmin = [
      'name' => $request->validated()['name'],
      'email' => $request->validated()['email'],
      'password' => Hash::make($request->validated()['password']),
      'is_admin' => 1
    ];
    event(new Registered($user = User::create($dataAdmin)));
    return $this->registered($request, $user) ? : redirect()->route('admins.index')->with('successMessage', __('Admin has been added successfully') .' | '.__('We have sent a link to verify the email typed'));
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
      //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
      //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
      //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
      //
  }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\SaveAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;

class AdminController extends Controller
{
  use RegistersUsers;

  public function __construct(){
    $this->middleware('auth');
    $this->middleware('admin')->except('destroy');
    $this->middleware('superadmin')->only('destroy');
    $this->middleware('verified');
  }

  public function index()
  {
    $admins = User::where('is_admin',1)->orWhere('is_admin',2)->latest()->paginate(5);
    return view('admin.index',compact('admins'));
  }

  public function create()
  {
    return view('admin.create');
  }

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

  public function edit(User $user)
  {
    return view('admin.edit', compact('user'));
  }

  public function update(UpdateAdminRequest $request, User $user)
  {
    if($user->update($request->validated())){
      return redirect()->route('admins.index')->with('successMessage', __('Admin has been updated succesfully'));
    }else{
      return redirect()->route('admins.index')->with('errorMessage', __('Something went wrong, try again later'));
    }
  }

  public function destroy(User $user)
  {
    if($user->delete()){
      return array('message' =>  __('Admin has been deleted succesfully'), 'code' => 200);
    }else{
      return array('message' =>  __('Something went wrong, try again later'), 'code' => 404);
    }
  }
}

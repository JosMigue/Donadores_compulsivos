<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\SaveAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;

class AdminController extends Controller
{
  use RegistersUsers;

  public function __construct(){
    $this->middleware('auth');
    $this->middleware('admin')->except('destroy');
    $this->middleware('superadmin')->only('destroy');
    $this->middleware('iscurrentadmin')->only('edit');
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
    $dataAdmin = new User([
      'name' => $request->validated()['name'],
      'email' => $request->validated()['email'],
      'password' => Hash::make($request->validated()['password']),
      'is_admin' => 1,
      'image' => ''
    ]);
    if($dataAdmin->save()){
      $this->saveImageAdmin($request, $dataAdmin);
      $dataAdmin->sendEmailVerificationNotification();
      return redirect()->route('admins.index')->with('successMessage', __('Admin has been added successfully') .' | '.__('We have sent a link to verify the email typed'));
    }else{
      return redirect()->route('admins.index')->with('errorMessage', __('Something went worng, try again later'));

    }
  }

  private function saveImageAdmin($request, $admin){
    if($request->has('captured_image')){
      $data = explode(',',$request->validated()['captured_image']);
      $profile_picture = base64_decode($data[1]);
      Storage::disk('admin_picture')->put($admin->id.'pfAdmin.jpg', $profile_picture);
      $admin->image = 'storage/admins/'.$admin->id.'pfAdmin.jpg';
      $admin->save();
    }else if($request->has('profile_picture')){
      $request->validated()['profile_picture']->storeAs('/',$admin->id.'pfAdmin.jpg','admin_picture');
      $admin->image = 'storage/admins/'.$admin->id.'pfAdmin.jpg';
      $admin->save();
    }
  }

  public function edit(User $user)
  {
    return view('admin.edit', compact('user'));
  }

  public function update(UpdateAdminRequest $request, User $user)
  {
    
    if($user->update($this->createUpdateArrayAdmin($request))){
      $this->saveImageAdmin($request, $user);
      return redirect()->route('admins.index')->with('successMessage', __('Admin has been updated succesfully'));
    }else{
      return redirect()->route('admins.index')->with('errorMessage', __('Something went wrong, try again later'));
    }
  }

  private function createUpdateArrayAdmin($request){
    return [
      'name' => $request->validated()['name'],
      'email' => $request->validated()['email']
    ];
  }

  public function destroy(User $user)
  {
    $adminId = $user->id;
    if($user->delete()){
      Storage::disk('admin_picture')->delete($adminId.'pfAdmin.jpg');
      return array('message' =>  __('Admin has been deleted succesfully'), 'code' => 200);
    }else{
      return array('message' =>  __('Something went wrong, try again later'), 'code' => 404);
    }
  }
}

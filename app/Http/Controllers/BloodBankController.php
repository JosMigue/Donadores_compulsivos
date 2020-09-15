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

class BloodBankController extends Controller
{

  public function __construct(){
    $this->middleware('auth');
    $this->middleware('admin');
    $this->middleware('verified');
  }

  public function index()
  {
    $bloodBanks = BloodBank::with('city','state','user')->latest()->paginate(5);
    return view('bloodbank.index',compact('bloodBanks'));
  }

  public function create()
  {
    $states = State::all();
    $cities = City::all();
    return view('bloodbank.create', compact('cities', 'states'));
  }

  public function store(SaveBloodBankRequest $request)
  {
    $arrayOfDays = array();
    foreach($request->validated()['days'] as $index =>  $day){
      array_push($arrayOfDays, array($index => $day));
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
      'phone' => $request->validated()['phone'],
      'contact_person' => $request->validated()['contact_person'],
      'address' => $request->validated()['address'],
      'postal_code' => $request->validated()['postal_code'],
      'city_id' => $request->validated()['city_id'],
      'state_id' => $request->validated()['state_id'],
      'user_id' => $request->validated()['user_id'],
      'days' => $array,
      'hyperlink' => $request->validated()['hyperlink'],
    ];
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
    $daysOfWeek = BloodBank::getEnum('Dayofweektypes');
    return view('bloodbank.edit', compact('bloodbank', 'cities', 'states', 'daysOfWeek'));
  }

  public function update(UpdateBloodBankRequest $request, BloodBank $bloodbank)
  {
    if($bloodbank->update($request->validated())){
      return redirect()->route('bloodbanks.index')->with('successMessage', __('Blood bank updated successfully'));
    }else{
      return redirect()->route('bloodbanks.index')->with('errorMessage', __('Something went wrong, try again later'));
    }
  }

  public function destroy(BloodBank $bloodbank)
  {
    if($bloodbank->delete()){
      return array('message' =>  __('Blood bank has been deleted succesfully'), 'code' => 200);
    }else{
      return array('message' =>  __('Something went wrong, try again later'), 'code' => 404);
    }
  }
}

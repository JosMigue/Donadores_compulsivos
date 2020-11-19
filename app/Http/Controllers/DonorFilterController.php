<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Donor;

class DonorFilterController extends Controller
{
    public function filterByName($search){
      return Donor::where('name','LIKE','%'.$search.'%')->orWhere('parental_surname','LIKE','%'.$search.'%')->orWhere('maternal_surname','LIKE','%'.$search.'%')->with(['city', 'state', 'user'])->latest()->get();
    }

    public function filterById($id){
      return Donor::where('id',$id)->with(['city', 'state', 'user'])->get();
    }

    public function filter(Request $request){
      $donors = Donor::query();
      if($request->input('bloodType') != ''){
        $donors->where('bloodtype', $request->input('bloodType'));
      }
      if($request->input('donorType') != ''){
        $donors->where('donortype', $request->input('donorType'));
      }
      if($request->input('city') != ''){
        $donors->where('city_id', $request->input('city'));
      }
      if($request->input('state') != ''){
        $donors->where('state_id', $request->input('state'));
      }
      return $donors->with(['city', 'state'])->latest()->get();
    }
}

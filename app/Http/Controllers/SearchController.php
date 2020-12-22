<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Donor;

class SearchController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function donors($search){
        return Donor::where('name', 'like', '%'.$search.'%')->orWhere('maternal_surname', 'like', '%'.$search.'%')->orWhere('parental_surname', 'like', '%'.$search.'%')->take(15)->get();
    }
}

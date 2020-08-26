<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Donor;

class SearchController extends Controller
{
    public function donors($search){
        return Donor::where('name', 'like', '%'.$search.'%')->get();
    }
}

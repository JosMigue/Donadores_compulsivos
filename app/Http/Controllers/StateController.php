<?php

namespace App\Http\Controllers;

use App\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function index()
    {
      return State::with('cities')->get();
    }
}

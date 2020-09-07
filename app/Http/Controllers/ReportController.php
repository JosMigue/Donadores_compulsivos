<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
  public function __construct(){
    $this->middleware('auth');
    $this->middleware('admin');
  }


  public function create(){
    return view('report.create');
  }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Donor;
use App\Campaign;
use Excel;
use App\Exports\DonationsExport;

class ReportController extends Controller
{
  public function __construct(){
    $this->middleware('auth');
    $this->middleware('admin');
    $this->middleware('verified');
  }


  public function index(){
    return view('report.index');
  }

  public function create(){
    return Excel::download(new DonationsExport, 'campaigns.xlsx');
  } 
}

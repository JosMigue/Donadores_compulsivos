<?php

namespace App\Exports;

use App\BloodBank;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class BloodBanksExport implements FromView, WithTitle
{
  public function view(): View
  {
    return view('exports.bloodbanks', [
      'bloodBanks' => BloodBank::with('state', 'city')->get()
    ]);
  }
  
  public function title(): string
  {
    return __('Blood banks');
  }
}
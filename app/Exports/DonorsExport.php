<?php

namespace App\Exports;

use App\Donor;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class DonorsExport implements FromView, WithTitle
{
  public function view(): View
  {
    return view('exports.donors', [
      'donors' => Donor::with('state', 'city')->get()
    ]);
  }
  public function title(): string
  {
    return __('Donors');
  }
}

<?php

namespace App\Exports;

use App\Donor;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class DonorDonationsExport implements FromView, WithTitle
{
    public function view(): View
    {
      return view('exports.donationsperdonors', [
        'donors' => Donor::with('state', 'city', 'campaigndonors')->get()
      ]);
    }
  
    public function title(): string
    {
      return __('Donations per donor');
    }
}

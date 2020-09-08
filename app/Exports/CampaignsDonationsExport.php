<?php

namespace App\Exports;

use App\Campaign;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class CampaignsDonationsExport implements FromView, WithTitle
{
    public function view(): View
    {
      return view('exports.donationspercampaigns', [
        'campaigns' => Campaign::with('state', 'city', 'campaigndonors')->get()
      ]);
    }
  
    public function title(): string
    {
      return __('Donations per campaign');
    }
}

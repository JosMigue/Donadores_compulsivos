<?php

namespace App\Exports;

use App\Campaign;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class CampaignsExport implements FromView, WithTitle
{
  public function view(): View
  {
    return view('exports.campaigns', [
      'campaigns' => Campaign::with('state', 'city')->get()
    ]);
  }

  public function title(): string
  {
    return __('Campaigns');
  }
}

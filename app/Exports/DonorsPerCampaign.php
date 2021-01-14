<?php

namespace App\Exports;
use App\Campaign;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class DonorsPerCampaign implements FromView, WithTitle
{
    public function __construct($campaign){
        $this->campaignid = $campaign;
    }

    public function view(): View
    {
      $campaign = Campaign::where('id', $this->campaignid)->with('donors', 'temporaldonors')->first();
      return view('exports.donorspercampaign', [
        'campaign' => $campaign
      ]);
    }
    public function title(): string
    {
      return 'Donadores por campaña';
    }
}

<?php

namespace App\Exports;

use App\Campaign;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CampaignsExport implements FromView
{
    public function view(): View
    {
        return view('exports.campaigns', [
            'campaigns' => Campaign::with('state', 'city')->get()
        ]);
    }
}

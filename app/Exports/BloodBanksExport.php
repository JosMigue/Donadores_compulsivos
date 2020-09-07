<?php

namespace App\Exports;

use App\BloodBank;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class BloodBanksExport implements FromView
{
    public function view(): View
    {
        return view('exports.bloodbanks', [
            'bloodBanks' => BloodBank::with('state', 'city')->get()
        ]);
    }
}
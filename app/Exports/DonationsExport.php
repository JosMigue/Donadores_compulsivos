<?php

namespace App\Exports;
use App\Exports\DonorDonationsExport;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class DonationsExport implements WithMultipleSheets
{
    use Exportable;

    public function sheets(): array
    {
        $sheets = [];
        $sheets[] = new DonorDonationsExport;
        $sheets[] = new CampaignsDonationsExport;

        return $sheets;
    }
}

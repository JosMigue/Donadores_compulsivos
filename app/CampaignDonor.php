<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignDonor extends Model
{
    protected $fillable= [
        'campaign_id',
        'donor_id',
        'ip_address'
    ];

    protected $table = 'campaign_donors';
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignDonor extends Model
{
    protected $fillable= [
        'campaign_id',
        'donor_id',
        'turn',
        'ip_address'
    ];

    protected $table = 'campaign_donors';
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignDonor extends Model
{
    protected $fillable= [
        'campaign_id',
        'donor_id',
        'temporal_donor_id',
        'is_confirmed',
        'donor_attended',
        'turn',
        'time_turn',
        'ip_address'
    ];

    protected $table = 'campaign_donors';
}

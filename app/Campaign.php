<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Enums;

class Campaign extends Model
{
    protected $table = 'campaigns'; 

    protected $fillable = [
        'name',
        'place',
        'city_id',
        'state_id',
        'date_start',
        'time_start',
        'date_finish',
        'time_finish',
        'campaigntype',
        'blood_bank_id',
        'frecuency',
        'frecuency_time',
        'description',
        'user_id',
        'campaign_image'
    ];

    use Enums;

    protected $enumCampaigntypes = [
        'c1' => 'Externa',
        'c2' => 'En banco de sangre',
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function city(){
        return $this->belongsTo('App\City');
    }

    public function state(){
        return $this->belongsTo('App\State');
    }

    public function donors(){
        return $this->belongsToMany('App\Donor', 'campaign_donors')->withPivot(['id','created_at', 'turn', 'time_turn', 'donor_donated', 'donor_attended', 'reason_not_donation']);
    }

    public function campaigndonors(){
        return $this->hasMany('App\CampaignDonor');
    }

    public function bloodbank(){
        return $this->belongsTo('App\BloodBank', 'blood_bank_id');
    }
}

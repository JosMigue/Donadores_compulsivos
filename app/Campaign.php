<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = [
        'name',
        'place',
        'city_id',
        'state_id',
        'date_start',
        'time_start',
        'date_finish',
        'time_finish',
        'description',
        'user_id'
    ];

    protected $table = 'campaigns';

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
        return $this->belongsToMany('App\Donor', 'campaign_donors')->withPivot(['created_at', 'turn', 'donor_donated']);
    }

    public function campaigndonors(){
        return $this->hasMany('App\CampaignDonor');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Enums;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Donor extends Authenticatable implements MustVerifyEmail
{
    use Notifiable; 

    protected $fillable = [
        'name',
        'parental_surname',
        'maternal_surname',
        'address',
        'postal_code',
        'city_id',
        'state_id',
        'bloodtype',
        'gendertype',
        'donortype',
        'born_date',
        'first_time_donating',
        'email',
        'password',
        'mobile',
        'age',
        'observations',
        'profile_picture'
    ];

    protected $hidden = [
        'password'
    ];

    use Enums;

    protected $enumBloodtypes = [
        'b1' => 'A+',
        'b2' => 'B+',
        'b3' => 'O+',
        'b4' => 'AB+',
        'b5' => 'A-',
        'b6' => 'B-',
        'b7' => 'O-',
        'b8' => 'AB-',
    ];

    protected $enumGendertypes = [
        'F' => 'Femenino',
        'M' => 'Masculino',
        'PNR' => 'Prefiero no responder'
    ];

    protected $enumDonortypes = [
        'D1' => 'Sangre',
        'D2' => 'Aféresis'
    ];

    public function city(){
        return $this->belongsTo('App\City');
    }

    public function state(){
        return $this->belongsTo('App\State');
    }

    public function campaigns(){
        return $this->belongsToMany('App\Campaign', 'campaign_donors')->withPivot(['created_at', 'turn', 'donor_donated', 'donation_date']);
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function campaigndonors(){
        return $this->hasMany('App\CampaignDonor');
    }
}

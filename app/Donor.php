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
        'last_name',
        'address',
        'postal_code',
        'city_id',
        'state_id',
        'bloodtype',
        'born_date',
        'email',
        'password',
        'mobile',
        'weight',
        'height',
        'age',
        'gendertype'
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

    public function city(){
        return $this->belongsTo('App\City');
    }

    public function state(){
        return $this->belongsTo('App\State');
    }

    public function campaigns(){
        return $this->belongsToMany('App\Campaign', 'campaign_donors')->withPivot(['created_at']);
    }
}

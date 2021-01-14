<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BloodBank extends Model
{
    protected $fillable = [
        'name',
        'email',
        'extension_number',
        'phone',
        'contact_person',
        'contact_person_mobile',
        'address',
        'postal_code',
        'city_id',
        'state_id',
        'user_id',
        'days',
        'hyperlink',
    ];

    protected $table = 'blood_banks';

    public function city(){
        return $this->belongsTo('App\City');
    }

    public function state(){
        return $this->belongsTo('App\State');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function campaigns(){
        return $this->hasMany('App\Campaign', 'blood_bank_id');
    }
}

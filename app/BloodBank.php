<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Enums;

class BloodBank extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'postal_code',
        'city_id',
        'state_id',
        'user_id',
        'dayofweektype',
        'bussines_hours_start',
        'bussines_hours_end'
    ];

    use Enums;

    protected $enumDayofweektypes = [
        'dow1' => 'Monday - Fryday',
        'dow2' => 'Monday - Saturday',
        'dow3' => 'Monday - Sunday',
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
}

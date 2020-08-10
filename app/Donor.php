<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Enums;

class Donor extends Model
{
    protected $fillable = [
        'name',
        'last_name',
        'address',
        'city_id',
        'state_id',
        'blood_type',
        'born_date',
        'age',
        'email',
        'weight',
        'height'
    ];

    use Enums;

    protected $enumBloodtypes = [
        '1' => 'A+',
        '2' => 'B+',
        '3' => 'O+',
        '4' => 'AB+',
        '5' => 'A-',
        '6' => 'B-',
        '7' => 'O-',
        '8' => 'AB-',
    ];
}

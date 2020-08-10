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
        'postal_code',
        'city_id',
        'state_id',
        'blood_type',
        'born_date',
        'email',
        'mobile',
        'weight',
        'height',
        'age',
        'gender'
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

    protected $enumGendertypes = [
        '1' => 'Femenino',
        '2' => 'Masculino',
        '3' => 'Prefiero no responder'
    ];
}

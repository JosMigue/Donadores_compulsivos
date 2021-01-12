<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TemporalDonor extends Model
{
    protected $fillable = [
        'name',
        'parental_surname',
        'maternal_surname',
        'curp',
        'city_id',
        'state_id',
        'bloodtype',
        'donortype',
        'gendertype',
        'born_date',
        'first_time_donating',
        'be_the_match',
        'letter',
        'age',
        'email',
        'mobile'
    ];

    protected $table = 'temporal_donors';
}

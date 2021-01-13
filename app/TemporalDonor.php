<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Enums;

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
        'd9' => 'No lo sé'
    ];

    protected $enumGendertypes = [
        'NR'=> 'Prefiero no responder',
        'F' => 'Femenino',
        'M' => 'Masculino'
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
    public function campaigntemporaldonors(){
        return $this->hasMany('App\CampaignDonor');
    }
}

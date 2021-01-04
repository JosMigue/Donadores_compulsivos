<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IndividualDonation extends Model
{
    protected $table='individual_donations';

    protected $fillable = [
        'bloodbank_id',
        'donor_id',
        'date_donation',
        'time_donation',
        'donationtype'
    ];


    public function bloodbank(){
        return $this->belongsTo('App\BloodBank');
    }

}

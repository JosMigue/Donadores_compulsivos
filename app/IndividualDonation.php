<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class IndividualDonation extends Model
{
    protected $table='individual_donations';

    protected $dateFormat = 'd-m-Y';

    protected $fillable = [
        'bloodbank_id',
        'donor_id',
        'time_donation',
        'donationtype'
    ];
    
    
    protected $dates = [
        'date_donation',
        'created_at',
        'updated_at'
    ];
    
    public function bloodbank(){
        return $this->belongsTo('App\BloodBank');
    }

}

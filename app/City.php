<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
  protected $table = 'cities'; 

  protected $fillable = ['name'];

  public $timestamps = false;
   
  public static function getCitiesByState($state){
   return City::where('state_id', $state)
   ->select('cities.id', 'cities.name')
   ->get(); 
  }

  public function state(){
    return $this->hasOne('App\State');
  }
}

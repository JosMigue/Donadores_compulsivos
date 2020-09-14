<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
  protected $table = "states";

  protected $fillable = ['name'];

  public $timestamps = false;

  public function cities(){
      return $this->hasMany('App\City');
  }

  public function donors(){
      return $this->belongsToMany('App\Donor');
  }
}

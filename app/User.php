<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\Enums;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use Enums;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'is_admin', 'image',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $enumUsertypes = [
        '0' => 'Donor',
        '1' => 'Administrator',
        '2' => 'Super Administrator',
    ];

    public function donor(){
        return $this->hasOne('App\Donor');
    }
}

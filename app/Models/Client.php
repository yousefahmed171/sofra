<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Client extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'clients';

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'address', 'pin_code', 'api_token', 'region_id',
    ];

    public function reviews()
    {
        return $this->hasMany('App\Models\Review');
    }
    
    public function orders()
    {
        return $this->hasMany('App\Models\Product');
    }

    public function region()
    {
        return $this->belongsTo('App\Models\Region');
    }

    public function notifications()
    {
        return $this->morphMany('App\Models\Notification', 'notificationable');
    }

    public function tokens()
    {
        return $this->morphMany('App\Models\Token', 'tokenable');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token', 'pin_code' 
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}

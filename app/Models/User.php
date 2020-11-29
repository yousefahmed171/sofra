<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model 
{

    protected $table = 'users';
    public $timestamps = true;
    protected $fillable = array('name', 'email', 'phone', 'password', 'address', 'pin_code', 'api_token', 'region_id');

    public function reviews()
    {
        return $this->belongsToMany('App\Models\Restaurant', 'restaurant_id');
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

}
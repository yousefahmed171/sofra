<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
    

class Restaurant extends Authenticatable 
{

    use Notifiable;
    
    protected $table = 'restaurants';
    public $timestamps = true;
    protected $fillable = array('name', 'email', 'password', 'phone', 'whatsapp', 'image', 'status', 'minimum_order', 'delivery_cost', 'activated', 'pin_code', 'api_token', 'region_id');

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    public function region()
    {
        return $this->belongsTo('App\Models\Region');
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\Review');
    }

    public function offers()
    {
        return $this->hasMany('App\Models\Offer');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function notifications()
    {
        return $this->morphMany('App\Models\Notification', 'notificationable');
    }

    public function tokens()
    {
        return $this->morphMany('App\Models\Token', 'tokenable');
    }

    public function payments()
    {
        return $this->hasMany('App\Models\Payment');
    }

    protected $hidden = [
        'password', 'remember_token', 'api_token', 'pin_code' 
    ];

}
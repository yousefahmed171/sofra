<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model 
{

    protected $table = 'orders';
    public $timestamps = true;
    protected $fillable = array('address', 'notes', 'payment_method', 'status', 'price', 'delivery_cost', 'total_cost', 'commission', 'restaurant_id', 'client_id', 'cost', 'net');

    public function notifications()
    {
        return $this->hasMany('App\Models\Notification');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant');
    }

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product')->withPivot('quantity', 'price', 'note'); 
    }

}
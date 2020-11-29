<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order_product extends Model 
{

    protected $table = 'order_product';
    public $timestamps = true;
    protected $fillable = array('quantity', 'price', 'special_order', 'order_id', 'product_id');

}
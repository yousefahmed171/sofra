<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category_restaurant extends Model 
{

    protected $table = 'category_restaurant';
    public $timestamps = true;
    protected $fillable = array('category_id', 'restaurant_id');

}
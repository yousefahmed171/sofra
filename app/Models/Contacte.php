<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contacte extends Model 
{

    protected $table = 'contactes';
    public $timestamps = true;
    protected $fillable = array('name', 'email', 'phone', 'massage', 'type');

}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model 
{

    protected $table = 'settings';
    public $timestamps = true;
    protected $fillable = array('about', 'phone', 'facebook_link', 'instagram_link', 'twitter_link', 'youtube_link', 'whatsapp_link', 'android_link', 'ios_link', 'terms', 'about_commission', 'id_bank');

}
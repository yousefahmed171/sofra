<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


use Laratrust\Traits\LaratrustUserTrait;


class Admin extends Authenticatable
{
    //
    use Notifiable;
    use LaratrustUserTrait;

    protected $table = 'users';

    protected $fillable = [
        'name', 'email', 'password', 'phone', 
    ];


    protected $hidden = [
        'password', 'remember_token', 
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

}
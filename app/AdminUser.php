<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class AdminUser extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'username',
        'password',
        'name',
        'avatar',
        'email',
        'reset_password_token',
        'reset_password_token_date',
        'remember_token',
        'phone_number'
    ];


}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminUserSmsDiffusion extends Model
{
    protected $table = "admin_user_sms_diffusion";
    protected $fillable = [
        "admin_user_id",
        "sms_diffusion_id",
        "views"
    ];
}

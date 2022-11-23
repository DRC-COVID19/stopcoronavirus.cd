<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminUserNotification extends Model
{
  use SoftDeletes;
  protected $fillable = ['admin_user_id', 'notification_id', 'read'];
}

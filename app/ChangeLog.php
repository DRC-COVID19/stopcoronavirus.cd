<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChangeLog extends Model
{
  protected $fillable = [
    'publish_date',
    'title',
    'description'
  ];

  public function administratorRead()
  {
    return $this->belongsToMany(Administrator::class, 'administrator_read_change_logs', 'change_log_id','administrator_id');
  }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bookmark extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'form_id',
        'row',
        'column',
        'display_type',
        'aggregator_type',
        'params1',
        'params2',
    ];

}

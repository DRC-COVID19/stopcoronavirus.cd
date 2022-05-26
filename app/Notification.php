<?php

namespace App;

use App\Form;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'form_id',
        'title',
        'message'
    ];

    public function form (){
        return $this->belongsTo(Form::class);
    }
}

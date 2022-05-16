<?php

namespace App;

use App\Hospital;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Form extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'publish',
        'visible_all_hospitals',
        'form_recurrence_value',
        'form_recurrence_id'
    ];

    public function formRecurrence()
    {
        return $this->belongsTo(FormRecurrence::class);
    }

    public function formSteps()
    {
        return $this->hasMany(FormStep::class);
    }
    public function formFields()
    {
        return $this->hasMany(FormField::class);
    }
    public function completedforms(){
        return $this->hasMany(CompletedForm::class);
    }
    
    public function hospitals(){
        return $this->belongsToMany(Hospital::class);
    }
    
}

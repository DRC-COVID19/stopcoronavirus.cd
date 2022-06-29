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
        'form_recurrence_id',
        'form_recurrence_number',
        'conflict_resolution_mode_id'
    ];

    public function formRecurrence()
    {
        return $this->belongsTo(FormRecurrence::class);
    }
    public function conflictResolutionMode()
    {
        return $this->belongsTo(ConflictResolutionMode::class);
    }

    public function formSteps()
    {
        return $this->hasMany(FormStep::class)->orderBy('step');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function formFields()
    {
        return $this->hasMany(FormField::class);
    }

    public function completedForms()
    {
        return $this->hasMany(CompletedForm::class);
    }

    public function hospitals()
    {
        return $this->belongsToMany(Hospital::class);
    }

}

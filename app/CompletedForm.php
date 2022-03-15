<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompletedForm extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'reference',
        'synchronized',
        'form_id',
        'admin_user_id',
        'hospital_id',
        'created_manager_name',
        'created_manager_first_name',
        'last_update',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    public function completedFormFields()
    {
        return $this->hasMany(CompletedFormField::class);
    }

    public function adminUser()
    {
        return $this->belongsTo(AdminUser::class);
    }
}

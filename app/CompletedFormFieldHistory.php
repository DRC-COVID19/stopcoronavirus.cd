<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompletedFormFieldHistory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'value',
        'completed_form_history_id',
        'form_field_id',
        'updated_manager_name',
        'updated_manager_first_name'
    ];

    public function completedFormHistory()
    {
        return $this->belongsTo(CompletedFormHistory::class);
    }

    public function formField()
    {
        return $this->belongsTo(FormField::class);
    }
}

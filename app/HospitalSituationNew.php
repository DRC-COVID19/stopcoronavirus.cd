<?php

namespace App;

use App\FormField;
use Encore\Admin\Form\Field\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HospitalSituationNew extends Model
{
        use SoftDeletes;
        protected $fillable = ['value','form_fields_id'];

        public function formField()
        {
            return $this->belongsTo(FormField::class);
        }
}

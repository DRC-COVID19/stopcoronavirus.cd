<?php

namespace App;

use App\HospitalSituationNew;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormField extends Model
{
  use SoftDeletes;

  protected $fillable = [
    'name',
    'order_field',
    'rules',
    'agreggation',
    'default_value',
    'form_id',
    'form_field_type_id',
    'show_in_summary_report',
    'form_step_id',
  ];

  public function formFieldType()
  {
    return $this->belongsTo(FormFieldType::class);
  }

  public function form()
  {
    return $this->belongsTo(Form::class);
  }

  public function formStep()
  {
    return $this->belongsTo(FormStep::class);
  }

  public function hospitalSituationsNew()
  {
    return $this->hasMany(HospitalSituationNew::class);
  }
}

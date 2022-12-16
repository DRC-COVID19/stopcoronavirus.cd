<?php

namespace App;

use App\Hospital;
use App\FormField;
use App\HospitalLog;
use Encore\Admin\Form\Field\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HospitalSituationNew extends Model
{
  use SoftDeletes;
  protected $fillable = [
    'hospital_id',
    'value',
    'form_field_id',
    'created_manager_name',
    'updated_manager_name',
    'hospital_id',
    'last_update',
  ];

  protected $table = 'hospital_situations_new';

  public function formField()
  {
    return $this->belongsTo(FormField::class);
  }
  public function hospital()
  {
    return $this->belongsTo(Hospital::class);
  }
  public function hospitalLog()
  {
    return $this->belongsTo(HospitalLog::class, 'hospital_id');
  }
}

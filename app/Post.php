<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
  use Sluggable;

  protected $fillable = [
    'title',
    'content',
    'image_path',
    'slug',
    'category_id',
    'width',
    'order',
  ];

  public function category()
  {
    return $this->belongsTo('App\Category');
  }

  /**
   * Return the sluggable configuration array for this model.
   *
   * @return array
   */
  public function sluggable()
  {
    return [
      'slug' => [
        'source' => 'title',
      ],
    ];
  }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Category extends Model
{
  use Sluggable;
  protected $fillable = ['name', 'slug', 'icon', 'description'];

  public function articles()
  {
    return $this->hasMany(Post::class);
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
        'source' => 'name',
      ],
    ];
  }
}
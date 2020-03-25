<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    
    protected $fillable = [
        "icon",
    ];

    public function articles()
    {
        return $this->hasMany(Post::class);
    }

    public function translates()
    {
        return $this->hasMany(CategoryTranslation::class);
    }
    
}

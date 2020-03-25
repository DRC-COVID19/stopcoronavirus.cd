<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    

    protected $fillable = [
        "image_path",
        "category_id",
        'width',
        'order'
    ];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function translates()
    {
        return $this->hasMany(PostTranslation::class);
    }
    
}

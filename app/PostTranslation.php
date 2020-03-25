<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;


class PostTranslation extends Model
{
    use Sluggable;
    protected $fillable = [
        "title",
        "content",
        "slug",
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
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
                'source' => 'title'
            ]
        ];
    }
}

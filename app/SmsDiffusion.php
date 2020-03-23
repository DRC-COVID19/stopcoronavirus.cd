<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmsDiffusion extends Model
{
    protected $fillable = [
        "status",
        "content_fr",
        "content_li", //Lingala
        "content_sw", //Swahili
        "content_ts", //Tshiluba
        "content_ki", //Kikongo
        "date_diffusion"
    ];

    public function provinces()
    {
        return $this->hasMany("App\Province");
    }
}

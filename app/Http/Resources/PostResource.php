<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $title = "";
        $content = "";
        $slug = "";
        $translate = $this->translates()->where('locale', App::getLocale())->first();
        if (!$translate) {
            $translate = $this->translates()->first();
        }
        $title = $translate->title;
        $content = $translate->content;
        $slug = $translate->slug;
        return [
            'id' => $this->id,
            'title' => $title,
            'content' => $content,
            'slug' => $slug,
            "image_path"=>$this->image_path,
            'width'=>$this->width,
            'order'=>$this->order
        ];;
    }
}

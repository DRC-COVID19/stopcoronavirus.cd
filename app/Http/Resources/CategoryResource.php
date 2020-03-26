<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $name = '';
        $description = '';
        $translate = $this->translates()->where('locale', App::getLocale())->first();
        if (!$translate) {
            $translate = $this->translates()->first();
        }
        $name = $translate->name;
        $description = $translate->description;
        return [
            'id' => $this->id,
            'name'=> $name,
            'descriptiom'=> $description
        ];
    }
}

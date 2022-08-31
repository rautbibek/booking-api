<?php

namespace App\Http\Resources;

use App\Helper\MediaHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'category_name'=>$this->name,
            'has_package'=> $this->has_package?1:0,
            'package_names'=>$this->package_names,
            'cover_url' => MediaHelper::getThumbnailUrl($this->image,'thumb')
        ];
    }
}

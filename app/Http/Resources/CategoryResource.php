<?php

namespace App\Http\Resources;

use App\Helper\MediaHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'name'=>$this->name,
            'status'=> $this->status,
            'image'=>MediaHelper::getThumbnailUrl($this->image,'thumb'),
            'package_names'=>$this->package_names,
            'created_at'=> $this->created_at,
            'cover_url' => MediaHelper::getThumbnailUrl($this->image,'thumb')
        ];
    }
}

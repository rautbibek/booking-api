<?php

namespace App\Http\Resources;

use App\Helper\MediaHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class BusinessDetailResource extends JsonResource
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
            'id'=> $this->id,
            'business_name'=>$this->business_name,
            'business_email'=>$this->business_email,
            'contact_number'=>$this->contact_number,
            'business_logo' => MediaHelper::getThumbnailUrl($this->business_logo,'thumb'),
            'category'=>$this->category->name,
            'status'=>$this->service_status,
            'created_at'=>$this->created_at,
            'business_images'=>$this->images,
            'about' => $this->about,
            
        ];
    }
}

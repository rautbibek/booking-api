<?php

namespace App\Http\Resources;

use App\Helper\MediaHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class EditServiceResource extends JsonResource
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
            'business_name'=>$this->business_name,
            'business_email'=>$this->business_email,
            'category_id'=>$this->category_id,
            'contact_number'=>$this->contact_number,
            'full_address'=> $this->full_address,
            'business_started_date'=> $this->business_started_date,
            'business_detail'=> $this->about,
            'cover_url' => MediaHelper::getThumbnailUrl($this->business_logo,'thumb')
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
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
            'business_name'=>$this->business_name,
            'business_email'=>$this->business_email,
            'business_logo'=>$this->business_logo,
            'category'=>$this->category->name,
            'status'=>$this->service_status,
            'created_at'=>$this->created_at,
            'about' => $this->about,
        ];
    }
}

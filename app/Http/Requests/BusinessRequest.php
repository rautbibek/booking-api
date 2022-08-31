<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BusinessRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'business_logo'=>'required|image|mimes:png,jpg,jpeg,webp,gif|max:8000',
            'business_name'=>'required|max:200',
            'business_email'=>'required|email|max:100',
            'contact_number'=>'required|numeric',
            'business_images' => 'required',
            'business_images.*' => 'required|image|mimes:jpg,jpeg,png,gif|max:10048',
            'full_address'=>'required|max:200',
            'category_id'=>'required',
        ];
    }
}

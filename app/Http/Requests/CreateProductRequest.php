<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'code' => 'required|string|max:12|unique:products,code,NULL,id,deleted_at,NULL',
            'category' => 'required|string|max:40',
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:400',
            'selling_price' => 'required|numeric|gt:0',
            'special_price' => 'nullable|numeric|gte:0',
            'status' => 'required|in:Draft,Published,Out of Stock',
            'is_delivery_available' => 'boolean',
            'image' => 'required|image|mimes:jpeg,png|max:2048',    
            'attributes' => 'array', 
            'attributes.*.name' => 'required|string|max:40',
            'attributes.*.attribute_value' => 'required|string|max:40',
        ];
    }
}

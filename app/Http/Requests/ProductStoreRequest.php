<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->entity !== null; // ownership check middleware already ensures entity exists
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:150',
            'description' => 'nullable|string|max:2000',
            'price' => 'nullable|numeric|min:0|max:99999999.99',
            'category_id' => 'nullable|exists:categories,id',
            'type' => 'required|in:product,service',
            'is_active' => 'sometimes|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
        ];
    }
}

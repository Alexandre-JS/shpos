<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Product;

class ProductUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var Product $product */
        $product = $this->route('product');
        return $product && $product->entity && $product->entity->user_id === $this->user()->id;
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

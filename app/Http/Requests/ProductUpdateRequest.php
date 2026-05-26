<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class ProductUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var Product $product */
        $product = $this->route('product');
        $userEntityId = $this->user()?->entity?->id;
        $allowed = $product && $userEntityId !== null && (int)$product->entity_id === (int)$userEntityId;
        Log::debug('ProductUpdateRequest.authorize', [
            'product_id' => $product?->id,
            'product_entity_id' => $product?->entity_id,
            'user_id' => $this->user()?->id,
            'user_entity_id' => $userEntityId,
            'allowed' => $allowed,
        ]);
        return $allowed;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:150',
            'description' => 'required|string|min:1|max:2000',
            'price' => 'nullable|numeric|min:0|max:99999999.99',
            'category_id' => 'nullable|exists:categories,id',
            'type' => 'required|in:product,service',
            'is_active' => 'sometimes|boolean',
            'has_delivery' => 'sometimes|boolean',
            // Discount
            'discount_type' => 'nullable|in:percent,amount|required_with:discount_value',
            'discount_value' => 'nullable|numeric|min:0.01',
            'discount_starts_at' => 'nullable|date',
            'discount_ends_at' => 'nullable|date|after_or_equal:discount_starts_at',
            'remove_discount' => 'sometimes|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,webp|max:2048', // legacy
            'images' => 'nullable|array|max:8',
            'images.*' => 'image|mimes:jpeg,png,webp|max:2048',
            'primary_image_index' => 'nullable|integer|min:0',
            'primary_existing_id' => 'nullable|exists:product_images,id',
        ];
    }

    protected function prepareForValidation(): void
    {
        Log::debug('ProductUpdateRequest.prepareForValidation:before', [
            'discount_type' => $this->discount_type,
            'discount_value' => $this->discount_value,
            'remove_discount' => $this->boolean('remove_discount'),
        ]);
        if ($this->discount_type === 'percent' && $this->discount_value !== null) {
            $this->merge([
                'discount_value' => min((float)$this->discount_value, 100),
            ]);
        }
        if ($this->boolean('remove_discount')) {
            $this->merge([
                'discount_type' => null,
                'discount_value' => null,
                'discount_starts_at' => null,
                'discount_ends_at' => null,
            ]);
        }
        Log::debug('ProductUpdateRequest.prepareForValidation:after', [
            'discount_type' => $this->discount_type,
            'discount_value' => $this->discount_value,
        ]);
    }

    public function withValidator($validator)
    {
        $validator->after(function ($v) {
            $price = $this->input('price');
            if ($this->input('discount_type') === 'amount' && $price !== null && $this->input('discount_value') !== null) {
                if ($this->input('discount_value') > $price) {
                    $v->errors()->add('discount_value', 'O valor do desconto não pode exceder o preço.');
                    Log::warning('ProductUpdateRequest.validation:discount_amount_gt_price', [
                        'price' => $price,
                        'discount_value' => $this->input('discount_value'),
                    ]);
                }
            }
        });
    }
}

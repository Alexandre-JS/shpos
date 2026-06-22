<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class ProductStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        $allowed = $this->user()?->entity !== null;
        Log::debug('ProductStoreRequest.authorize', [
            'user_id' => $this->user()?->id,
            'has_entity' => $this->user()?->entity?->id,
            'allowed' => $allowed,
        ]);
        return $allowed; // ownership check middleware already ensures entity exists
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:150',
            'description' => 'required|string|min:1|max:2000',
            'price' => 'nullable|numeric|min:0|max:99999999.99',
            'category_id' => 'required|exists:categories,id',
            'type' => 'required|in:product,service',
            'is_active' => 'sometimes|boolean',
            'has_delivery' => 'sometimes|boolean',
            // Discount
            'discount_type' => 'nullable|in:percent,amount|required_with:discount_value',
            'discount_value' => 'nullable|numeric|min:0.01',
            'discount_starts_at' => 'nullable|date',
            'discount_ends_at' => 'nullable|date|after_or_equal:discount_starts_at',
            'remove_discount' => 'sometimes|boolean',
            // Additional percent cap logic handled in prepareForValidation
            // Legacy single image (deprecated):
            'image' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
            // New multiple images support:
            'images' => 'nullable|array|max:8',
            'images.*' => 'image|mimes:jpeg,png,webp|max:2048',
            'primary_image_index' => 'nullable|integer|min:0',
        ];
    }

    protected function prepareForValidation(): void
    {
        Log::debug('ProductStoreRequest.prepareForValidation:before', [
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
        Log::debug('ProductStoreRequest.prepareForValidation:after', [
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
                    Log::warning('ProductStoreRequest.validation:discount_amount_gt_price', [
                        'price' => $price,
                        'discount_value' => $this->input('discount_value'),
                    ]);
                }
            }
        });
    }
}

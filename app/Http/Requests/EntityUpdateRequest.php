<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EntityUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->entity !== null;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:150',
            'description' => 'required|string|min:20|max:3000',
            'location_city' => 'nullable|string|max:120',
            'location_district' => 'nullable|string|max:120',
            'phone' => 'nullable|string|max:30',
            'whatsapp' => 'nullable|regex:/^258\d{9}$/',
            'email' => 'nullable|email',
            'facebook_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'website_url' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
        ];
    }
}

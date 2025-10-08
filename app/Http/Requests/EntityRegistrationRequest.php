<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EntityRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // guest pode registrar
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'], // nome do utilizador
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],

            // Entidade
            'entity_name' => ['required', 'string', 'max:255'],
            'entity_description' => ['required', 'string', 'min:20'],
            'location_city' => ['required', 'string', 'max:100'],
            'location_district' => ['nullable', 'string', 'max:100'],
            'whatsapp' => ['required', 'regex:/^258[0-9]{9}$/'],
            'phone' => ['nullable', 'string', 'max:20'],
            'entity_email' => ['nullable', 'email', 'max:255'],
            'facebook_url' => ['nullable', 'url', 'max:500'],
            'instagram_url' => ['nullable', 'url', 'max:500'],
            'website_url' => ['nullable', 'url', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'entity_description.min' => 'A descrição deve ter pelo menos 20 caracteres.',
            'whatsapp.regex' => 'O WhatsApp deve estar no formato 258XXXXXXXXX.',
        ];
    }
}

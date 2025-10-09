<?php

namespace Database\Factories;

use App\Models\Entity;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EntityFactory extends Factory
{
    protected $model = Entity::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->company();
        return [
            'user_id' => User::factory(),
            'name' => $name,
            'slug' => Str::slug($name) . '-' . Str::random(5),
            'description' => $this->faker->sentence(12),
            'logo_path' => null,
            'location_city' => $this->faker->city(),
            'location_district' => $this->faker->state(),
            'phone' => $this->faker->numerify('8########'),
            'whatsapp' => $this->faker->numerify('8########'),
            'email' => $this->faker->safeEmail(),
            'facebook_url' => null,
            'instagram_url' => null,
            'website_url' => null,
            'is_active' => true,
            'is_featured' => false,
            'plan_type' => 'free',
        ];
    }
}

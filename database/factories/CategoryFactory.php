<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $name = ucfirst($this->faker->unique()->word());
        return [
            'name' => $name,
            'slug' => Str::slug($name) . '-' . Str::random(4),
            'type' => $this->faker->randomElement(['product', 'service', 'both']),
            'icon' => null,
            'is_active' => true,
        ];
    }
}

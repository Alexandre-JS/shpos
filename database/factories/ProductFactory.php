<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Entity;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->words(3, true);
        $price = $this->faker->randomFloat(2, 5, 500);
        return [
            'entity_id' => Entity::factory(),
            'category_id' => Category::factory(),
            'name' => ucfirst($name),
            'slug' => Str::slug($name) . '-' . Str::random(5),
            'description' => $this->faker->sentence(12),
            'price' => $price,
            'image_path' => null,
            'type' => $this->faker->randomElement(['product', 'service']),
            'is_active' => true,
            'views_count' => 0,
        ];
    }

    public function discountedPercent(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'discount_type' => 'percent',
                'discount_value' => $this->faker->numberBetween(5, 50),
                'discount_starts_at' => now()->subDays($this->faker->numberBetween(0, 2)),
                'discount_ends_at' => now()->addDays($this->faker->numberBetween(1, 5)),
            ];
        });
    }

    public function discountedAmount(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'discount_type' => 'amount',
                'discount_value' => $this->faker->randomFloat(2, 1, max(1, ($attributes['price'] ?? 100) * 0.6)),
                'discount_starts_at' => now()->subDay(),
                'discount_ends_at' => now()->addDays($this->faker->numberBetween(2, 7)),
            ];
        });
    }

    public function expiredDiscount(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'discount_type' => 'percent',
                'discount_value' => $this->faker->numberBetween(5, 40),
                'discount_starts_at' => now()->subDays(7),
                'discount_ends_at' => now()->subDays(1),
            ];
        });
    }
}

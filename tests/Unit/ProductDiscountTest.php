<?php

namespace Tests\Unit;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductDiscountTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function percent_discount_calculations_are_correct()
    {
        $p = Product::factory()->create([
            'price' => 100.00,
            'discount_type' => 'percent',
            'discount_value' => 25,
            'discount_starts_at' => now()->subHour(),
            'discount_ends_at' => now()->addHour(),
        ]);

        $this->assertTrue($p->isDiscountActive());
        $this->assertEquals(25.00, $p->discountAmount());
        $this->assertEquals(75.00, $p->discountedPrice());
        $this->assertEquals(25.00, $p->discountPercent());
    }

    /** @test */
    public function amount_discount_calculations_are_correct()
    {
        $p = Product::factory()->create([
            'price' => 80.00,
            'discount_type' => 'amount',
            'discount_value' => 10.00,
            'discount_starts_at' => now()->subHour(),
            'discount_ends_at' => now()->addHour(),
        ]);

        $this->assertTrue($p->isDiscountActive());
        $this->assertEquals(10.00, $p->discountAmount());
        $this->assertEquals(70.00, $p->discountedPrice());
        $this->assertEquals(12.5, $p->discountPercent());
    }

    /** @test */
    public function discount_not_active_outside_window()
    {
        $p = Product::factory()->create([
            'price' => 50.00,
            'discount_type' => 'percent',
            'discount_value' => 10,
            'discount_starts_at' => now()->addHour(), // future
            'discount_ends_at' => now()->addHours(2),
        ]);

        $this->assertFalse($p->isDiscountActive());
        $this->assertEquals(0.0, $p->discountAmount());
        $this->assertEquals(50.00, $p->discountedPrice());
    }

    /** @test */
    public function expired_discount_is_inactive()
    {
        $p = Product::factory()->create([
            'price' => 50.00,
            'discount_type' => 'amount',
            'discount_value' => 5,
            'discount_starts_at' => now()->subHours(3),
            'discount_ends_at' => now()->subHour(),
        ]);

        $this->assertFalse($p->isDiscountActive());
    }

    /** @test */
    public function amount_discount_cannot_exceed_price()
    {
        $p = Product::factory()->create([
            'price' => 20.00,
            'discount_type' => 'amount',
            'discount_value' => 50.00, // exceeds price
            'discount_starts_at' => now()->subHour(),
            'discount_ends_at' => now()->addHour(),
        ]);

        $this->assertTrue($p->isDiscountActive());
        $this->assertEquals(20.00, $p->discountAmount());
        $this->assertEquals(0.00, $p->discountedPrice());
        $this->assertEquals(100.00, $p->discountPercent());
    }
}

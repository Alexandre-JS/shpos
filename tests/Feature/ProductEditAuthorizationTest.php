<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Entity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductEditAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function owner_can_access_edit_page()
    {
        $user = User::factory()->create();
        $entity = Entity::factory()->create(['user_id' => $user->id]);
        // Garantir que product pertence ao entity do user (não criar entity adicional via factory encadeada)
        $product = Product::factory()->for($entity, 'entity')->create();

        $this->actingAs($user)
            ->get(route('dashboard.products.edit', $product))
            ->assertStatus(200)
            ->assertSee($product->name);
    }

    /** @test */
    public function other_user_gets_403_on_edit_page()
    {
        $owner = User::factory()->create();
        $entityOwner = Entity::factory()->create(['user_id' => $owner->id]);
        $product = Product::factory()->for($entityOwner, 'entity')->create();

        $other = User::factory()->create();
        Entity::factory()->create(['user_id' => $other->id]);

        $this->actingAs($other)
            ->get(route('dashboard.products.edit', $product))
            ->assertStatus(403);
    }
}

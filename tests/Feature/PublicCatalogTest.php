<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Entity;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicCatalogTest extends TestCase
{
    use RefreshDatabase;

    public function test_products_with_the_same_slug_are_resolved_inside_their_store(): void
    {
        $category = Category::factory()->create();
        $firstStore = Entity::factory()->create(['slug' => 'loja-a']);
        $secondStore = Entity::factory()->create(['slug' => 'loja-b']);
        $firstProduct = Product::factory()->for($firstStore)->for($category)->create([
            'name' => 'Produto da loja A',
            'slug' => 'produto-repetido',
        ]);
        $secondProduct = Product::factory()->for($secondStore)->for($category)->create([
            'name' => 'Produto da loja B',
            'slug' => 'produto-repetido',
        ]);

        $this->assertTrue($firstStore->fresh()->isPubliclyVisible());
        $this->assertTrue($firstProduct->fresh()->load('entity')->isPubliclyVisible());

        $this->get(route('product.show', $firstProduct->publicRouteParameters()))
            ->assertOk()
            ->assertViewHas('product', fn (Product $product) => $product->is($firstProduct));

        $this->get(route('product.show', $secondProduct->publicRouteParameters()))
            ->assertOk()
            ->assertViewHas('product', fn (Product $product) => $product->is($secondProduct));
    }

    public function test_legacy_product_url_refuses_an_ambiguous_slug(): void
    {
        $category = Category::factory()->create();
        Product::factory()->for(Entity::factory())->for($category)->create(['slug' => 'repetido']);
        Product::factory()->for(Entity::factory())->for($category)->create(['slug' => 'repetido']);

        $this->get('/produto/repetido')->assertNotFound();
    }

    public function test_legacy_product_url_redirects_when_slug_is_unique(): void
    {
        $product = Product::factory()->create(['slug' => 'slug-unico']);

        $this->assertTrue($product->fresh()->load('entity')->isPubliclyVisible());

        $this->get('/produto/slug-unico')
            ->assertRedirect(route('product.show', $product->publicRouteParameters()));
    }

    public function test_products_from_non_public_stores_are_not_publicly_accessible(): void
    {
        foreach ([
            ['status' => Entity::STATUS_PENDING, 'is_active' => true],
            ['status' => Entity::STATUS_REJECTED, 'is_active' => false],
            ['status' => Entity::STATUS_APPROVED, 'is_active' => false],
        ] as $state) {
            $entity = Entity::factory()->create($state);
            $product = Product::factory()->for($entity)->create();

            $this->get(route('product.show', $product->publicRouteParameters()))->assertNotFound();
            $this->getJson(route('search', ['q' => $product->name]))
                ->assertOk()
                ->assertJsonCount(0, 'data');
        }
    }
}

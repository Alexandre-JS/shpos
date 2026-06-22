<?php

namespace Tests\Feature;

use App\Models\Entity;
use App\Models\Product;
use App\Services\ImageUploadService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageLifecycleTest extends TestCase
{
    use RefreshDatabase;

    public function test_image_service_deletes_all_generated_variants(): void
    {
        Storage::fake('public');
        $this->storeVariants('uploads/products/item');

        app(ImageUploadService::class)->delete('storage/uploads/products/item_lg.jpg');

        $this->assertVariantsMissing('uploads/products/item');
    }

    public function test_deleting_a_product_removes_legacy_and_gallery_images(): void
    {
        Storage::fake('public');
        $this->storeVariants('uploads/products/legacy');
        $this->storeVariants('uploads/products/gallery');
        $product = Product::factory()->create([
            'image_path' => 'storage/uploads/products/legacy_lg.jpg',
        ]);
        $product->images()->create([
            'path' => 'storage/uploads/products/gallery_lg.jpg',
            'position' => 0,
            'is_primary' => true,
        ]);

        $product->delete();

        $this->assertVariantsMissing('uploads/products/legacy');
        $this->assertVariantsMissing('uploads/products/gallery');
    }

    public function test_deleting_a_store_removes_product_and_logo_files(): void
    {
        Storage::fake('public');
        $this->storeVariants('uploads/logos/store');
        $this->storeVariants('uploads/products/item');
        $entity = Entity::factory()->create([
            'logo_path' => 'storage/uploads/logos/store_lg.jpg',
        ]);
        Product::factory()->for($entity)->create([
            'image_path' => 'storage/uploads/products/item_lg.jpg',
        ]);

        $entity->delete();

        $this->assertVariantsMissing('uploads/logos/store');
        $this->assertVariantsMissing('uploads/products/item');
    }

    private function storeVariants(string $base): void
    {
        foreach (["{$base}.jpg", "{$base}_lg.jpg", "{$base}_sm.jpg"] as $path) {
            Storage::disk('public')->put($path, 'image');
        }
    }

    private function assertVariantsMissing(string $base): void
    {
        Storage::disk('public')->assertMissing([
            "{$base}.jpg",
            "{$base}_lg.jpg",
            "{$base}_sm.jpg",
        ]);
    }
}

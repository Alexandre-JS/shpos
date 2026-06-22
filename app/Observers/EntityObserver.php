<?php

namespace App\Observers;

use App\Models\Entity;
use App\Services\ImageUploadService;

class EntityObserver
{
    public function __construct(private ImageUploadService $images) {}

    public function deleting(Entity $entity): void
    {
        $entity->products()
            ->with('images')
            ->chunkById(100, function ($products): void {
                foreach ($products as $product) {
                    $this->images->deleteMany([
                        $product->image_path,
                        ...$product->images->pluck('path')->all(),
                    ]);
                }
            });

        $this->images->delete($entity->logo_path);
    }
}

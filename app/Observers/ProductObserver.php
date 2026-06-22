<?php

namespace App\Observers;

use App\Models\Product;
use App\Services\ImageUploadService;
use Illuminate\Support\Facades\DB;

class ProductObserver
{
    public function __construct(private ImageUploadService $images) {}

    public function deleting(Product $product): void
    {
        $product->loadMissing('images');
        $this->images->deleteMany([
            $product->image_path,
            ...$product->images->pluck('path')->all(),
        ]);
    }

    public function created(Product $product): void
    {
        if ($product->is_active) {
            $this->touchEntity($product);
        }
    }

    public function updated(Product $product): void
    {
        // Se mudou is_active ou created_at relevante para entidade
        if ($product->wasChanged('is_active') || $product->wasChanged('created_at')) {
            $this->recalculateEntity($product);
            return;
        }
        // Caso permaneça ativo, apenas garante que last_item_at >= created_at
        if ($product->is_active) {
            $this->touchEntity($product);
        }
    }

    public function deleted(Product $product): void
    {
        $this->recalculateEntity($product);
    }

    protected function touchEntity(Product $product): void
    {
        $driver = DB::getDriverName();
        if ($driver === 'sqlite') {
            $current = DB::table('entities')->where('id', $product->entity_id)->value('last_item_at');
            if (!$current || $product->created_at > $current) {
                DB::table('entities')->where('id', $product->entity_id)->update(['last_item_at' => $product->created_at]);
            }
        } else {
            // MySQL / MariaDB suportam GREATEST
            DB::table('entities')
                ->where('id', $product->entity_id)
                ->update(['last_item_at' => DB::raw("GREATEST(COALESCE(last_item_at, '1970-01-01'), '{$product->created_at}')")]);
        }
    }

    protected function recalculateEntity(Product $product): void
    {
        $max = Product::where('entity_id', $product->entity_id)->where('is_active', true)->max('created_at');
        DB::table('entities')->where('id', $product->entity_id)->update(['last_item_at' => $max]);
    }
}

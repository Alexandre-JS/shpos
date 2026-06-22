<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ProductService
{
    public function getRecent(int $limit = 12): Collection
    {
        return Product::with(['entity:id,name,slug,is_active,status', 'category:id,name,slug', 'images'])
            ->publiclyVisible()
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function getMostViewed(int $limit = 12, int $minViews = 5): Collection
    {
        return Product::with(['entity:id,name,slug,is_active,status', 'category:id,name,slug', 'images'])
            ->publiclyVisible()
            ->where('views_count', '>=', $minViews)
            ->orderByDesc('views_count')
            ->limit($limit)
            ->get();
    }

    public function search(string $term, ?string $type = null, ?string $categorySlug = null): Collection
    {
        $term = trim($term);
        if ($term === '') {
            return collect();
        }

        $query = Product::with(['entity:id,name,slug,is_active,status', 'category:id,name,slug', 'images'])
            ->publiclyVisible()
            ->when(in_array($type, ['product', 'service']), fn($q) => $q->where('type', $type))
            ->when($categorySlug, fn($q) => $q->whereHas('category', fn($c) => $c->where('slug', $categorySlug)))
            ->where(function ($q) use ($term) {
                $q->where('name', 'LIKE', "%{$term}%")
                    ->orWhere('description', 'LIKE', "%{$term}%")
                    ->orWhereHas('entity', fn($sq) => $sq->where('name', 'LIKE', "%{$term}%"));
            })
            ->orderByDesc('views_count')
            ->limit(50);

        return $query->get();
    }

    public function paginateAll(int $perPage = 24): LengthAwarePaginator
    {
        return Product::with(['entity:id,name,slug,location_city,is_active,status', 'category:id,name,slug', 'images'])
            ->publiclyVisible()
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ViewTrackingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function __construct(private ViewTrackingService $viewTrackingService) {}

    public function show(Product $product, Request $request)
    {
        if ($product->is_active && $product->entity?->is_active) {
            $this->viewTrackingService->track(
                $product,
                $request->ip(),
                $request->userAgent(),
                Auth::id()
            );
        }

        $product->load(['entity', 'category']);

        $related = Product::with(['entity:id,name,slug', 'category:id,name,slug'])
            ->active()
            ->where('id', '!=', $product->id)
            ->when($product->category_id, fn($q) => $q->where('category_id', $product->category_id))
            ->when(!$product->category_id, fn($q) => $q->where('type', $product->type))
            ->orderByDesc('views_count')
            ->limit(8)
            ->get();

        // Se não encontrou nada pela categoria (pode ser muito restrito), faz um fallback por tipo.
        if ($related->isEmpty()) {
            $related = Product::with(['entity:id,name,slug', 'category:id,name,slug'])
                ->active()
                ->where('id', '!=', $product->id)
                ->where('type', $product->type)
                ->orderByDesc('views_count')
                ->limit(8)
                ->get();
        }

        return view('products.show', [
            'product' => $product,
            'related' => $related,
        ]);
    }
}

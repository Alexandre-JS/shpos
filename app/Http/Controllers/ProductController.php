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

        $product->load(['entity', 'category', 'images']);

        $moreFromEntity = Product::active()
            ->where('entity_id', $product->entity_id)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        $similarProducts = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        return view('products.show', [
            'product' => $product,
            'moreFromEntity' => $moreFromEntity,
            'similarProducts' => $similarProducts,
        ]);
    }
}

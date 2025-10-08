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
        return view('products.show', compact('product'));
    }
}

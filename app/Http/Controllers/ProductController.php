<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Entity;
use App\Services\ViewTrackingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function __construct(private ViewTrackingService $viewTrackingService) {}

    public function show(Entity $entity, Product $product, Request $request)
    {
        $product->loadMissing(['entity', 'category', 'images']);
        abort_unless($entity->isPubliclyVisible() && $product->isPubliclyVisible(), 404);

        $this->viewTrackingService->track(
            $product,
            $request->ip(),
            $request->userAgent(),
            Auth::id()
        );

        $moreFromEntity = Product::publiclyVisible()
            ->with(['entity', 'category', 'images'])
            ->where('entity_id', $product->entity_id)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        $similarProducts = Product::publiclyVisible()
            ->with(['entity', 'category', 'images'])
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

    public function legacy(string $product)
    {
        $matches = Product::publiclyVisible()
            ->with('entity')
            ->where('slug', $product)
            ->limit(2)
            ->get();

        abort_unless($matches->count() === 1, 404);

        $match = $matches->first();

        return redirect()->route('product.show', $match->publicRouteParameters(), 301);
    }
}

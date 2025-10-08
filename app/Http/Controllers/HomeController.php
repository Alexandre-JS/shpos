<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Services\ProductService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(private ProductService $productService) {}

    public function index()
    {
        // Se autenticado, direciona diretamente para o dashboard (experiência focada no gestor)
        if (Auth::check()) {
            return redirect()->route('dashboard.index');
        }

        $recent = $this->productService->getRecent();
        $mostViewed = $this->productService->getMostViewed();
        $products = $this->productService->paginateAll();

        return view('home.index', compact('recent', 'mostViewed', 'products'));
    }

    public function products()
    {
        $products = Product::with(['entity', 'category'])->active()->products()->paginate(24);
        return view('home.list', [
            'title' => 'Produtos',
            'products' => $products
        ]);
    }

    public function services()
    {
        $products = Product::with(['entity', 'category'])->active()->services()->paginate(24);
        return view('home.list', [
            'title' => 'Serviços',
            'products' => $products
        ]);
    }

    public function search(Request $request)
    {
        $term = $request->get('q', '');
        $type = $request->get('type'); // 'product' | 'service' | null
        $results = $this->productService->search($term, $type);

        if ($request->wantsJson()) {
            return response()->json([
                'data' => $results->map(function ($p) {
                    return [
                        'id' => $p->id,
                        'name' => $p->name,
                        'slug' => $p->slug,
                        'type' => $p->type,
                        'price' => $p->price,
                        // image_path já contém prefixo 'storage/' retornado pelo ImageUploadService
                        'image' => $p->image_path ? asset($p->image_path) : null,
                        'entity' => [
                            'name' => $p->entity->name,
                            'slug' => $p->entity->slug,
                        ],
                        'category' => $p->category?->name,
                        'views' => $p->views_count,
                        'url' => route('product.show', $p->slug),
                    ];
                }),
                'count' => $results->count(),
                'term' => $term,
                'type' => $type,
            ]);
        }

        return view('home.search', compact('term', 'results', 'type'));
    }
}

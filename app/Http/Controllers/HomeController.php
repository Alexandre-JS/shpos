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

        $categories = \App\Models\Category::active()
            ->withCount(['products as items_count' => function ($q) {
                $q->active();
            }])
            ->orderByDesc('items_count')
            ->orderBy('name')
            ->get();

        $entities = \App\Models\Entity::active()
            ->withCount(['products as items_count' => function ($q) {
                $q->active();
            }])
            ->orderByDesc('items_count')
            ->orderBy('name')
            ->limit(30)
            ->get();

        return view('home.index', compact('recent', 'mostViewed', 'products', 'categories', 'entities'));
    }

    public function products()
    {
        $products = Product::with(['entity', 'category'])->active()->products()->paginate(24);
        [$categories, $entities] = $this->sidebarData();
        return view('home.list', [
            'title' => 'Produtos',
            'products' => $products,
            'categories' => $categories,
            'entities' => $entities,
        ]);
    }

    public function services()
    {
        $products = Product::with(['entity', 'category'])->active()->services()->paginate(24);
        [$categories, $entities] = $this->sidebarData();
        return view('home.list', [
            'title' => 'Serviços',
            'products' => $products,
            'categories' => $categories,
            'entities' => $entities,
        ]);
    }

    public function search(Request $request)
    {
        $term = $request->get('q', '');
        $type = $request->get('type'); // 'product' | 'service' | null
        $categorySlug = $request->get('cat');

        $results = $this->productService->search($term, $type, $categorySlug);

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
                'category' => $categorySlug,
            ]);
        }

        [$categories, $entities] = $this->sidebarData();
        return view('home.search', [
            'term' => $term,
            'results' => $results,
            'type' => $type,
            'category' => $categorySlug,
            'categories' => $categories,
            'entities' => $entities,
        ]);
    }

    protected function sidebarData(): array
    {
        $categories = \App\Models\Category::active()
            ->withCount(['products as items_count' => function ($q) {
                $q->active();
            }])
            ->orderByDesc('items_count')->orderBy('name')->get();
        $entities = \App\Models\Entity::active()
            ->withCount(['products as items_count' => function ($q) {
                $q->active();
            }])
            ->orderByDesc('items_count')->orderBy('name')->limit(30)->get();
        return [$categories, $entities];
    }
}

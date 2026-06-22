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
        if (Auth::check()) {
            return Auth::user()->is_admin
                ? redirect()->route('admin.dashboard')
                : redirect()->route('dashboard.index');
        }

        $recent = $this->productService->getRecent();
        $categories = \App\Models\Category::active()
            ->withCount(['products as items_count' => function ($q) {
                $q->publiclyVisible();
            }])
            ->orderByDesc('items_count')
            ->orderBy('name')
            ->get();

        $entities = \App\Models\Entity::active()
            ->withCount(['products as items_count' => function ($q) {
                $q->publiclyVisible();
            }])
            ->orderByDesc('items_count')
            ->orderBy('name')
            ->limit(30)
            ->get();

        return view('home.index', compact('recent', 'categories', 'entities'));
    }

    public function products()
    {
        $query = Product::with(['entity', 'category', 'images'])->publiclyVisible()->products();
        if (request()->boolean('promo')) {
            $query->withActiveDiscount();
        }
        $products = $query->paginate(24)->withQueryString();
        [$categories, $entities] = $this->sidebarData();
        return view('home.list', [
            'title' => 'Produtos',
            'products' => $products,
            'categories' => $categories,
            'entities' => $entities,
            'promo' => request()->boolean('promo'),
        ]);
    }

    public function services()
    {
        $query = Product::with(['entity', 'category', 'images'])->publiclyVisible()->services();
        if (request()->boolean('promo')) {
            $query->withActiveDiscount();
        }
        $products = $query->paginate(24)->withQueryString();
        [$categories, $entities] = $this->sidebarData();
        return view('home.list', [
            'title' => 'Serviços',
            'products' => $products,
            'categories' => $categories,
            'entities' => $entities,
            'promo' => request()->boolean('promo'),
        ]);
    }

    public function search(Request $request)
    {
        $term = $request->get('q', '');
        $type = $request->get('type'); // 'product' | 'service' | null
        $categorySlug = $request->get('cat');

        $results = $this->productService->search($term, $type, $categorySlug);

        // Filtro de promoções (após busca em coleção). Se performance for um problema, mover lógica para ProductService.
        if ($request->boolean('promo')) {
            $results = $results->filter(fn($p) => method_exists($p, 'isDiscountActive') && $p->isDiscountActive())->values();
        }

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
                        'url' => route('product.show', $p->publicRouteParameters()),
                    ];
                }),
                'count' => $results->count(),
                'term' => $term,
                'type' => $type,
                'category' => $categorySlug,
                'promo' => $request->boolean('promo'),
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
            'promo' => $request->boolean('promo'),
        ]);
    }

    protected function sidebarData(): array
    {
        $categories = \App\Models\Category::active()
            ->withCount(['products as items_count' => function ($q) {
                $q->publiclyVisible();
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

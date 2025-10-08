<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use Illuminate\Support\Facades\DB;
use App\Services\SlugGeneratorService;
use App\Services\ImageUploadService;
use Illuminate\Support\Facades\Gate;

class ProductManagementController extends Controller
{
    public function index(Request $request)
    {
        $entity = $request->user()->entity;
        if (!$entity) return redirect()->route('home');

        $query = $entity->products()->with('category')->latest();
        if ($request->filled('type')) {
            $query->where('type', $request->get('type'));
        }
        if ($request->filled('q')) {
            $qTerm = $request->get('q');
            $query->where(function ($q) use ($qTerm) {
                $q->where('name', 'like', "%$qTerm%")
                    ->orWhere('description', 'like', "%$qTerm%");
            });
        }
        $products = $query->paginate(15)->withQueryString();
        return view('dashboard.products.index', compact('products'));
    }

    public function create(Request $request)
    {
        $entity = $request->user()->entity;
        if (!$entity) return redirect()->route('home');
        $categories = Category::orderBy('name')->get();
        return view('dashboard.products.create', compact('categories'));
    }

    public function store(ProductStoreRequest $request, SlugGeneratorService $slugger, ImageUploadService $uploader)
    {
        $entity = $request->user()->entity;
        if (!$entity) return redirect()->route('home');

        $data = $request->validated();

        DB::transaction(function () use ($data, $entity, $slugger, $request, $uploader) {
            $data['entity_id'] = $entity->id;
            $data['slug'] = $slugger->generate($data['name'], Product::class, ['entity_id' => $entity->id]);
            $data['is_active'] = $data['is_active'] ?? true;
            if ($request->hasFile('image')) {
                $data['image_path'] = $uploader->upload($request->file('image'), 'uploads/products');
            }
            Product::create($data);
        });

        return redirect()->route('dashboard.products.index')->with('success', 'Produto/Serviço criado.');
    }

    protected function authorizeProduct(Request $request, Product $product)
    {
        if (! Gate::allows('manage-product', $product)) {
            abort(403, 'Não autorizado.');
        }
        return $request->user()->entity;
    }

    public function edit(Request $request, Product $product)
    {
        $this->authorizeProduct($request, $product);
        $categories = Category::orderBy('name')->get();
        return view('dashboard.products.edit', compact('product', 'categories'));
    }

    public function update(ProductUpdateRequest $request, Product $product, ImageUploadService $uploader)
    {
        $entity = $this->authorizeProduct($request, $product);
        $data = $request->validated();

        // If name changed, optionally update slug in future (keep stable for SEO now)
        $data['is_active'] = $data['is_active'] ?? false; // checkbox if absent
        if ($request->hasFile('image')) {
            $uploader->delete($product->image_path);
            $data['image_path'] = $uploader->upload($request->file('image'), 'uploads/products');
        }
        $product->update($data);

        return redirect()->route('dashboard.products.index')->with('success', 'Atualizado com sucesso.');
    }

    public function destroy(Request $request, Product $product)
    {
        $this->authorizeProduct($request, $product);
        $product->delete();
        return redirect()->route('dashboard.products.index')->with('success', 'Removido.');
    }
}

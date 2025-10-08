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
        $imagesFiles = $request->file('images', []);
        $primaryIndex = $data['primary_image_index'] ?? null;

        DB::transaction(function () use ($data, $entity, $slugger, $uploader, $imagesFiles, $primaryIndex, $request) {
            $data['entity_id'] = $entity->id;
            $data['slug'] = $slugger->generate($data['name'], Product::class, ['entity_id' => $entity->id]);
            $data['is_active'] = $data['is_active'] ?? true;

            // Legacy single image fallback
            if ($request->hasFile('image') && empty($imagesFiles)) {
                $data['image_path'] = $uploader->upload($request->file('image'), 'uploads/products');
            }

            /** @var Product $product */
            $product = Product::create($data);

            if ($imagesFiles) {
                foreach ($imagesFiles as $idx => $file) {
                    $stored = $uploader->upload($file, 'uploads/products');
                    $product->images()->create([
                        'path' => $stored,
                        'position' => $idx,
                        'is_primary' => ($primaryIndex !== null && (int)$primaryIndex === $idx),
                    ]);
                }
                // Se nenhuma marcada primária explicitamente, marca a primeira
                if (!$product->images()->where('is_primary', true)->exists()) {
                    $first = $product->images()->orderBy('position')->first();
                    if ($first) {
                        $first->update(['is_primary' => true]);
                    }
                }
            }
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
        $this->authorizeProduct($request, $product);
        $data = $request->validated();

        $newImages = $request->file('images', []);
        $primaryIndex = $data['primary_image_index'] ?? null;
        $primaryExistingId = $data['primary_existing_id'] ?? null;

        DB::transaction(function () use ($data, $product, $uploader, $newImages, $primaryIndex, $primaryExistingId, $request) {
            // legacy single image replace
            if ($request->hasFile('image') && empty($newImages)) {
                $uploader->delete($product->image_path);
                $data['image_path'] = $uploader->upload($request->file('image'), 'uploads/products');
            }

            $data['is_active'] = $data['is_active'] ?? false;
            $product->update($data);

            // Append new images
            if ($newImages) {
                $basePos = (int) ($product->images()->max('position') ?? 0) + 1;
                foreach ($newImages as $offset => $file) {
                    $stored = $uploader->upload($file, 'uploads/products');
                    $product->images()->create([
                        'path' => $stored,
                        'position' => $basePos + $offset,
                        'is_primary' => false,
                    ]);
                }
            }

            // Reset all primaries if a new one selected
            if ($primaryExistingId || $primaryIndex !== null) {
                $product->images()->update(['is_primary' => false]);
            }

            if ($primaryExistingId) {
                $img = $product->images()->where('id', $primaryExistingId)->first();
                if ($img) {
                    $img->update(['is_primary' => true]);
                }
            } elseif ($primaryIndex !== null) {
                $img = $product->images()->orderBy('position')->skip((int)$primaryIndex)->first();
                if ($img) {
                    $img->update(['is_primary' => true]);
                }
            } else {
                // Ensure at least one primary
                if (!$product->images()->where('is_primary', true)->exists()) {
                    $first = $product->images()->orderBy('position')->first();
                    if ($first) {
                        $first->update(['is_primary' => true]);
                    }
                }
            }
        });

        return redirect()->route('dashboard.products.index')->with('success', 'Atualizado com sucesso.');
    }

    public function destroy(Request $request, Product $product)
    {
        $this->authorizeProduct($request, $product);
        $product->delete();
        return redirect()->route('dashboard.products.index')->with('success', 'Removido.');
    }

    public function setPrimaryImage(Request $request, Product $product, \App\Models\ProductImage $image)
    {
        $this->authorizeProduct($request, $product);
        if ($image->product_id !== $product->id) {
            abort(404);
        }
        $product->images()->update(['is_primary' => false]);
        $image->update(['is_primary' => true]);
        return back()->with('success', 'Imagem principal atualizada.');
    }

    public function reorderImages(Request $request, Product $product)
    {
        $this->authorizeProduct($request, $product);
        $data = $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:product_images,id'
        ]);
        $ids = $data['order'];
        // Garantir que todos pertencem ao produto
        $images = $product->images()->whereIn('id', $ids)->get();
        if ($images->count() !== count($ids)) {
            return response()->json(['message' => 'Imagens inválidas'], 422);
        }
        foreach ($ids as $pos => $id) {
            $product->images()->where('id', $id)->update(['position' => $pos]);
        }
        return response()->json(['message' => 'Ordem atualizada']);
    }
}

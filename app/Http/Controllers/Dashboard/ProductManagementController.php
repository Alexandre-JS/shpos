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
use Illuminate\Support\Facades\Log;

class ProductManagementController extends Controller
{
    public function index(Request $request)
    {
        $entity = $request->user()->entity;
        if (!$entity) return redirect()->route('home');

        Log::debug('ProductManagementController.index', [
            'user_id' => $request->user()->id,
            'entity_id' => $entity->id,
            'filters' => $request->only(['type', 'q'])
        ]);

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
        Log::debug('ProductManagementController.create', [
            'user_id' => $request->user()->id,
            'entity_id' => $entity->id,
        ]);
        $categories = Category::orderBy('name')->get();
        return view('dashboard.products.create', compact('categories'));
    }

    public function store(ProductStoreRequest $request, SlugGeneratorService $slugger, ImageUploadService $uploader)
    {
        $entity = $request->user()->entity;
        if (!$entity) return redirect()->route('home');

        Log::debug('ProductManagementController.store:start', [
            'user_id' => $request->user()->id,
            'entity_id' => $entity->id,
            'payload' => $request->only(['name', 'type', 'price', 'discount_type', 'discount_value'])
        ]);

        $data = $request->validated();
        $imagesFiles = $request->file('images', []);
        $primaryIndex = $data['primary_image_index'] ?? null;

        DB::transaction(function () use ($data, $entity, $slugger, $uploader, $imagesFiles, $primaryIndex, $request) {
            $data['entity_id'] = $entity->id;
            $data['slug'] = $slugger->generate($data['name'], Product::class, ['entity_id' => $entity->id]);
            $data['is_active']    = $data['is_active'] ?? true;
            $data['has_delivery'] = $data['has_delivery'] ?? false;

            // Legacy single image fallback
            if ($request->hasFile('image') && empty($imagesFiles)) {
                $data['image_path'] = $uploader->upload($request->file('image'), 'uploads/products');
            }

            /** @var Product $product */
            $product = Product::create($data);
            Log::debug('ProductManagementController.store:created', [
                'product_id' => $product->id,
                'entity_id' => $entity->id,
            ]);

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
        $userEntityId = $request->user()->entity?->id;
        $allowed = $userEntityId !== null && (int)$product->entity_id === (int)$userEntityId;
        Log::debug('ProductManagementController.authorizeProduct', [
            'user_id' => $request->user()->id,
            'product_id' => $product->id,
            'product_entity_id' => $product->entity_id,
            'user_entity_id' => $userEntityId,
            'allowed' => $allowed,
        ]);
        if (! $allowed) {
            Log::warning('ProductManagementController.authorizeProduct:denied', [
                'user_id' => $request->user()->id,
                'product_id' => $product->id,
            ]);
            abort(403, 'Não autorizado.');
        }
        return $request->user()->entity;
    }

    public function edit(Request $request, Product $product)
    {
        $this->authorizeProduct($request, $product);
        Log::debug('ProductManagementController.edit', [
            'user_id' => $request->user()->id,
            'product_id' => $product->id,
        ]);
        $categories = Category::orderBy('name')->get();
        return view('dashboard.products.edit', compact('product', 'categories'));
    }

    public function update(ProductUpdateRequest $request, Product $product, ImageUploadService $uploader)
    {
        $this->authorizeProduct($request, $product);
        $data = $request->validated();
        Log::debug('ProductManagementController.update:start', [
            'user_id' => $request->user()->id,
            'product_id' => $product->id,
            'changes' => collect($data)->only(['name', 'price', 'type', 'discount_type', 'discount_value', 'discount_starts_at', 'discount_ends_at', 'is_active'])->toArray()
        ]);

        $newImages = $request->file('images', []);
        $primaryIndex = $data['primary_image_index'] ?? null;
        $primaryExistingId = $data['primary_existing_id'] ?? null;

        DB::transaction(function () use ($data, $product, $uploader, $newImages, $primaryIndex, $primaryExistingId, $request) {
            // legacy single image replace
            if ($request->hasFile('image') && empty($newImages)) {
                $uploader->delete($product->image_path);
                $data['image_path'] = $uploader->upload($request->file('image'), 'uploads/products');
            }

            $data['is_active']    = $data['is_active'] ?? false;
            $data['has_delivery'] = $data['has_delivery'] ?? false;
            $product->update($data);
            Log::debug('ProductManagementController.update:updated', [
                'product_id' => $product->id,
            ]);

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
        Log::debug('ProductManagementController.destroy', [
            'user_id' => $request->user()->id,
            'product_id' => $product->id,
        ]);
        $product->delete();
        return redirect()->route('dashboard.products.index')->with('success', 'Removido.');
    }

    public function setPrimaryImage(Request $request, Product $product, \App\Models\ProductImage $image)
    {
        $this->authorizeProduct($request, $product);
        if ($image->product_id !== $product->id) {
            abort(404);
        }
        Log::debug('ProductManagementController.setPrimaryImage', [
            'product_id' => $product->id,
            'image_id' => $image->id,
        ]);
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
        Log::debug('ProductManagementController.reorderImages:start', [
            'product_id' => $product->id,
            'ids' => $data['order'],
        ]);
        $ids = $data['order'];
        // Garantir que todos pertencem ao produto
        $images = $product->images()->whereIn('id', $ids)->get();
        if ($images->count() !== count($ids)) {
            Log::warning('ProductManagementController.reorderImages:invalid-images', [
                'product_id' => $product->id,
            ]);
            return response()->json(['message' => 'Imagens inválidas'], 422);
        }
        foreach ($ids as $pos => $id) {
            $product->images()->where('id', $id)->update(['position' => $pos]);
        }
        Log::debug('ProductManagementController.reorderImages:done', [
            'product_id' => $product->id,
        ]);
        return response()->json(['message' => 'Ordem atualizada']);
    }
}

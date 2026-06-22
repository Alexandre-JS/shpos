<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::query()
            ->active()
            ->withCount(['products as items_count' => fn($q) => $q->publiclyVisible()])
            ->orderByDesc('items_count')
            ->orderBy('name')
            ->get();

        return view('categories.index', [
            'categories' => $categories,
        ]);
    }

    public function show(Category $category, Request $request)
    {
        abort_unless($category->is_active, 404);

        $products = $category->products()
            ->with(['entity:id,name,slug,is_active,status', 'category:id,name,slug', 'images'])
            ->publiclyVisible()
            ->orderByDesc('created_at')
            ->paginate(24)
            ->withQueryString();

        return view('categories.show', [
            'category' => $category,
            'products' => $products,
        ]);
    }
}

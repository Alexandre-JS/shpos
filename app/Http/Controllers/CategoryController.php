<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Category $category, Request $request)
    {
        // Produtos associados ativos (qualquer entidade ativa)
        $products = $category->products()
            ->with(['entity:id,name,slug,is_active', 'category:id,name,slug'])
            ->whereHas('entity', fn($q) => $q->where('is_active', true))
            ->active()
            ->orderByDesc('created_at')
            ->paginate(24)
            ->withQueryString();

        return view('categories.show', [
            'category' => $category,
            'products' => $products,
        ]);
    }
}

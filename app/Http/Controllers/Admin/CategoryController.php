<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->orderBy('name')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.form', ['category' => new Category]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['name']);

        if (Category::where('slug', $data['slug'])->exists()) {
            return back()->withErrors(['name' => 'Já existe uma categoria com este nome.'])->withInput();
        }

        Category::create($data);
        return redirect()->route('admin.categories.index')->with('success', 'Categoria criada.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.form', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $this->validated($request);
        $category->update($data);
        return redirect()->route('admin.categories.index')->with('success', 'Categoria actualizada.');
    }

    public function toggleActive(Category $category)
    {
        $category->update(['is_active' => !$category->is_active]);
        $label = $category->is_active ? 'activada' : 'desactivada';
        return back()->with('success', "Categoria «{$category->name}» {$label}.");
    }

    public function destroy(Category $category)
    {
        if ($category->products()->exists()) {
            return back()->with('error', 'Não é possível eliminar uma categoria com produtos associados.');
        }
        $name = $category->name;
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', "Categoria «{$name}» eliminada.");
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name'      => 'required|string|max:255',
            'type'      => 'required|in:product,service,both',
            'icon'      => 'nullable|string|max:10',
            'is_active' => 'boolean',
        ]) + ['is_active' => $request->boolean('is_active')];
    }
}

<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        if ($search) {
            $categories = Category::where('name', 'LIKE', '%' . $search . '%')->get();
        } else {
            $categories = Category::all();
        }
        
        return view('organizer.categories.index', compact('categories', 'search'));
    }

    public function create()
    {
        return view('organizer.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Generate slug from name
        $validated['slug'] = \Str::slug($validated['name']);

        Category::create($validated);

        return redirect()->route('organizer.categories.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit(Category $category)
    {
        return view('organizer.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Generate slug from name
        $validated['slug'] = \Str::slug($validated['name']);

        $category->update($validated);

        return redirect()->route('organizer.categories.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('organizer.categories.index')->with('success', 'Kategori berhasil dihapus!');
    }
}

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
        return view('admin.categories.index', [
            'categories' => Category::withCount('projects')->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required|max:60|unique:categories,name']);
        $data['slug'] = Str::slug($data['name']);

        if (Category::where('slug', $data['slug'])->exists()) {
            return back()->withErrors(['name' => 'Nama terlalu mirip dengan kategori lain'])->withInput();
        }

        Category::create($data);
        return back()->with('success', 'Kategori ditambahkan');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|max:60|unique:categories,name,' . $category->id,
        ]);
        $data['slug'] = Str::slug($data['name']);

        if (Category::where('slug', $data['slug'])->where('id', '!=', $category->id)->exists()) {
            return back()->withErrors(['name' => 'Nama terlalu mirip dengan kategori lain'])->withInput();
        }

        $category->update($data);
        return redirect()->route('admin.categories.index')->with('success', 'Kategori diperbarui');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Kategori dihapus');
    }
}

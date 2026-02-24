<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with('parent')
        ->latest()->get();
        return view('admin.categories.index'
        ,compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    $parents = Category::whereNull('parent_id')->latest()->get();
    return view('admin.categories.create', compact('parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'parent_id' => 'nullable|exists:categories,id',
            ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'parent_id' => $request->parent_id,
            'icon' => categoryIcon($request->name),
        ]);

        return redirect()->route('admin.categories.index')
        ->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $parents = Category::whereNull('parent_id')
            ->where('id', '!=',$id)->latest()->get();
        $category = Category::findOrFail($id);
          return view('admin.categories.edit'
          ,compact('category','parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'parent_id' => 'nullable|exists:categories,id',
           ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'parent_id' => $request->parent_id,
            'icon'      => categoryIcon($request->name),
        ]);

        return redirect()->route('admin.categories.index')
        ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')
        ->with('success', 'Category deleted successfully.');
    }
}

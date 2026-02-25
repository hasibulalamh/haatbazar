<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['primaryImage', 'shop', 'category'])
            ->where('is_active', true)
            ->whereHas('shop', fn($q) => $q->where('is_approved', true));

        // Filter by category
        if ($request->category) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category)
                ->orWhereHas('parent', fn($p) => $p->where('slug', $request->category));
            });
        }

        // Search
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Sort
        $query->when($request->sort === 'price_asc',  fn($q) => $q->orderBy('price', 'asc'))
              ->when($request->sort === 'price_desc', fn($q) => $q->orderBy('price', 'desc'))
              ->when(!$request->sort,                 fn($q) => $q->latest());

        $products   = $query->paginate(12);
        $categories = Category::whereNull('parent_id')->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        // Only active products from approved shops
        if (!$product->is_active || !$product->shop->is_approved) {
            abort(404);
        }

        $product->load(['images', 'shop', 'category']);

        $related = Product::with(['primaryImage', 'shop'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'related'));
    }
}

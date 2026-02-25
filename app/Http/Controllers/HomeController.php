<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::whereNull('parent_id')
            ->withCount('children')
            ->latest()
            ->take(8)
            ->get();

        $featuredProducts = Product::with(['primaryImage', 'shop', 'category'])
            ->where('is_active', true)
            ->whereHas('shop', fn($q) => $q->where('is_approved', true))
            ->latest()
            ->take(8)
            ->get();

        return view('home', compact('categories', 'featuredProducts'));
    }
}

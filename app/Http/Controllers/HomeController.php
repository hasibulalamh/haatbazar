<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\FlashSale;
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

        // Homepage hero carousel banners
        $banners = Banner::active()->get();

        // Currently running flash sale (null if none scheduled right now)
        $flashSale = FlashSale::current();

        return view('home', compact('categories', 'featuredProducts', 'banners', 'flashSale'));
    }
}

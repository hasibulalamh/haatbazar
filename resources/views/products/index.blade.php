@extends('layouts.app')

@section('title', 'Products')

@section('content')

<div class="page-wrap">

    {{-- Filters Sidebar --}}
    <aside class="filter-sidebar">
        <h3 class="filter-title"><i class="fa fa-sliders"></i> Filters</h3>

        <form method="GET" action="{{ route('products.index') }}" id="filter-form">
            @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif

            {{-- Categories --}}
            <div class="filter-group">
                <h4 class="filter-group-title">Categories</h4>
                <a href="{{ route('products.index', array_merge(request()->except('category'), []) ) }}"
                   class="filter-cat-link {{ !request('category') ? 'active' : '' }}">
                    <i class="fa fa-grid-2"></i> All Categories
                </a>
                @foreach($categories as $category)
                    <a href="{{ route('products.index', array_merge(request()->except('category'), ['category' => $category->slug])) }}"
                       class="filter-cat-link {{ request('category') === $category->slug ? 'active' : '' }}">
                        <i class="fa {{ $category->icon ?? 'fa-tag' }}"></i> {{ $category->name }}
                    </a>
                @endforeach
            </div>

            {{-- Sort --}}
            <div class="filter-group">
                <h4 class="filter-group-title">Sort By</h4>
                <select name="sort" class="filter-select" onchange="document.getElementById('filter-form').submit()">
                    <option value="" {{ !request('sort') ? 'selected' : '' }}>Latest</option>
                    <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                </select>
            </div>
        </form>
    </aside>

    {{-- Products Main --}}
    <div class="products-main">

        {{-- Header --}}
        <div class="products-header">
            <div>
                <h1 class="products-title">
                    {{ request('search') ? 'Search: "' . request('search') . '"' : (request('category') ? ucfirst(str_replace('-', ' ', request('category'))) : 'All Products') }}
                </h1>
                <p style="font-size:13px; color:var(--text-muted);">{{ $products->total() }} products found</p>
            </div>
        </div>

        {{-- Products Grid --}}
        <div class="products-grid">
            @forelse($products as $product)
            <a href="{{ route('products.show', $product->slug) }}" class="product-card">
                <div class="product-img-wrap">
                    @if($product->primaryImage)
                        <img src="{{ asset('storage/' . $product->primaryImage->image) }}"
                            alt="{{ $product->name }}" class="product-img">
                    @else
                        <div class="product-img-placeholder">
                            <i class="fa fa-image"></i>
                        </div>
                    @endif
                    @if($product->discount_price)
                        <span class="product-badge-discount">
                            {{ round((($product->price - $product->discount_price) / $product->price) * 100) }}% OFF
                        </span>
                    @endif
                </div>
                <div class="product-info">
                    <div class="product-shop">
                        <i class="fa fa-store"></i> {{ $product->shop->name }}
                    </div>
                    <h3 class="product-name">{{ $product->name }}</h3>
                    <div class="product-price-row">
                        @if($product->discount_price)
                            <span class="product-price">৳{{ number_format($product->discount_price, 0) }}</span>
                            <span class="product-price-old">৳{{ number_format($product->price, 0) }}</span>
                        @else
                            <span class="product-price">৳{{ number_format($product->price, 0) }}</span>
                        @endif
                    </div>
                </div>
            </a>
            @empty
            <div style="grid-column:1/-1; text-align:center; padding:60px 20px; color:var(--text-muted);">
                <i class="fa fa-box-open" style="font-size:40px; opacity:0.3; display:block; margin-bottom:12px;"></i>
                <p>No products found.</p>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($products->hasPages())
        <div style="margin-top:32px; display:flex; justify-content:center;">
            {{ $products->withQueryString()->links() }}
        </div>
        @endif

    </div>
</div>

@endsection

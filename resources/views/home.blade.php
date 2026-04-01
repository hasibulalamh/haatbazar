@extends('layouts.app')

@section('title', 'Home')

@section('content')

{{-- HERO --}}
<section class="hero">
    <div class="hero-content">
        <div class="hero-badge">🇧🇩 Bangladesh's #1 Marketplace</div>
        <h1 class="hero-title">
            Shop Everything,<br>
            <span class="hero-accent">Anywhere in BD</span>
        </h1>
        <p class="hero-subtitle">Discover thousands of products from verified local sellers. Fast delivery across Bangladesh.</p>
        <div class="hero-actions">
            <a href="{{ route('products.index') }}" class="hero-btn-primary">
                <i class="fa fa-bag-shopping"></i> Shop Now
            </a>
            <a href="{{ route('seller.register') }}" class="hero-btn-secondary">
                <i class="fa fa-store"></i> Become a Seller
            </a>
        </div>
        <div class="hero-stats">
            <div class="hero-stat">
                <span class="hero-stat-value">500+</span>
                <span class="hero-stat-label">Products</span>
            </div>
            <div class="hero-stat-divider"></div>
            <div class="hero-stat">
                <span class="hero-stat-value">50+</span>
                <span class="hero-stat-label">Sellers</span>
            </div>
            <div class="hero-stat-divider"></div>
            <div class="hero-stat">
                <span class="hero-stat-value">100%</span>
                <span class="hero-stat-label">Secure</span>
            </div>
        </div>
    </div>
    <div class="hero-visual">
        <div class="hero-card-float hero-card-1">
            <i class="fa fa-microchip" style="color:#a5b4fc; font-size:22px;"></i>
            <span>Electronics</span>
        </div>
        <div class="hero-card-float hero-card-2">
            <i class="fa fa-shirt" style="color:#fcd34d; font-size:22px;"></i>
            <span>Fashion</span>
        </div>
        <div class="hero-card-float hero-card-3">
            <i class="fa fa-house" style="color:#86efac; font-size:22px;"></i>
            <span>Home & Living</span>
        </div>
        <div class="hero-orb"></div>
    </div>
</section>

{{-- CATEGORIES --}}
<section class="section">
    <div class="section-header">
        <h2 class="section-heading">Shop by Category</h2>
        <a href="{{ route('products.index') }}" class="section-link">View All <i class="fa fa-arrow-right"></i></a>
    </div>
    <div class="categories-grid">
        @foreach($categories as $category)
        <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="category-card">
            <div class="category-icon">
                <i class="fa {{ $category->icon ?? 'fa-tag' }}"></i>
            </div>
            <div class="category-name">{{ $category->name }}</div>
            @if($category->children_count > 0)
                <div class="category-sub">{{ $category->children_count }} subcategories</div>
            @endif
        </a>
        @endforeach
    </div>
</section>

{{-- FEATURED PRODUCTS --}}
<section class="section">
    <div class="section-header">
        <h2 class="section-heading">Featured Products</h2>
        <a href="{{ route('products.index') }}" class="section-link">View All <i class="fa fa-arrow-right"></i></a>
    </div>
    <div class="products-grid">
        @forelse($featuredProducts as $product)
        <div class="product-card">
            <a href="{{ route('products.show', $product->slug) }}">
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
            {{-- Add to Cart --}}
            <div style="padding:0 12px 12px;">
                @auth('buyer')
                   <form method="POST" action="{{ route('buyer.cart.add', $product) }}" class="add-to-cart-form">

                        @csrf
                        <input type="hidden" name="quantity" value="1">
                       <button type="submit" class="add-to-cart-btn"
                            style="width:100%; padding:8px; background:linear-gradient(135deg,#6366f1,#4f46e5); color:white; border:none; border-radius:8px; font-size:13px; cursor:pointer; font-weight:600;">
                            <i class="fa fa-cart-shopping"></i> Add to Cart
                        </button>
                    </form>
                @else
                    <a href="{{ route('buyer.login') }}"
                       style="display:block; text-align:center; padding:8px; background:linear-gradient(135deg,#6366f1,#4f46e5); color:white; border-radius:8px; font-size:13px; font-weight:600; text-decoration:none;">
                        <i class="fa fa-cart-shopping"></i> Add to Cart
                    </a>
                @endauth
            </div>
        </div>
        @empty
        <div style="grid-column:1/-1; text-align:center; padding:40px; color:var(--text-muted);">
            <i class="fa fa-box-open" style="font-size:40px; opacity:0.3; display:block; margin-bottom:12px;"></i>
            <p>No products available yet.</p>
        </div>
        @endforelse
    </div>
</section>

{{-- CTA BANNER --}}
<section class="cta-banner">
    <div class="cta-content">
        <h2 class="cta-title">Start Selling on HaatBazar</h2>
        <p class="cta-subtitle">Join thousands of sellers and reach millions of buyers across Bangladesh.</p>
        <a href="{{ route('seller.register') }}" class="hero-btn-primary">
            <i class="fa fa-store"></i> Open Your Shop Today
        </a>
    </div>
</section>

@endsection

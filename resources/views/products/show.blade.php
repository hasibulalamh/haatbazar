@extends('layouts.app')

@section('title', $product->name)

@section('content')

    <div style="max-width:1200px; margin:0 auto; padding:32px 20px;">

        {{-- Breadcrumb --}}
        <div style="display:flex; align-items:center; gap:8px; font-size:13px; color:var(--text-muted); margin-bottom:24px;">
            <a href="{{ route('home') }}" style="color:var(--text-muted);">Home</a>
            <i class="fa fa-chevron-right" style="font-size:10px;"></i>
            <a href="{{ route('products.index') }}" style="color:var(--text-muted);">Products</a>
            <i class="fa fa-chevron-right" style="font-size:10px;"></i>
            <a href="{{ route('products.index', ['category' => $product->category->slug]) }}"
                style="color:var(--text-muted);">{{ $product->category->name }}</a>
            <i class="fa fa-chevron-right" style="font-size:10px;"></i>
            <span style="color:var(--white);">{{ Str::limit($product->name, 30) }}</span>
        </div>

        {{-- Product Detail --}}
        <div class="product-detail-grid">

            {{-- Images --}}
            <div class="product-images">
                <div class="product-main-img-wrap">
                    @if ($product->images->count() > 0)
                        <img src="{{ asset('storage/' . $product->images->where('is_primary', true)->first()?->image ?? $product->images->first()->image) }}"
                            alt="{{ $product->name }}" class="product-main-img" id="main-img">
                    @else
                        <div class="product-img-placeholder" style="height:400px; border-radius:16px;">
                            <i class="fa fa-image" style="font-size:48px;"></i>
                        </div>
                    @endif
                </div>

                @if ($product->images->count() > 1)
                    <div class="product-thumbnails">
                        @foreach ($product->images as $image)
                            <img src="{{ asset('storage/' . $image->image) }}" alt="{{ $product->name }}"
                                class="product-thumb {{ $image->is_primary ? 'active' : '' }}"
                                onclick="document.getElementById('main-img').src = this.src; document.querySelectorAll('.product-thumb').forEach(t => t.classList.remove('active')); this.classList.add('active');">
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Info --}}
            <div class="product-detail-info">

                {{-- Shop --}}
                <div style="display:flex; align-items:center; gap:8px; margin-bottom:12px;">
                    <div
                        style="width:28px; height:28px; border-radius:50%; background:rgba(99,102,241,0.12); display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:700; color:#a5b4fc;">
                        {{ strtoupper(substr($product->shop->name, 0, 2)) }}
                    </div>
                    <span style="font-size:13px; color:var(--text-muted);">{{ $product->shop->name }}</span>
                    @if ($product->shop->is_approved)
                        <span
                            style="font-size:11px; background:rgba(22,163,74,0.1); color:#86efac; padding:2px 8px; border-radius:20px;">
                            <i class="fa fa-circle-check"></i> Verified
                        </span>
                    @endif
                </div>

                <h1
                    style="font-family:'Playfair Display',serif; font-size:26px; font-weight:700; margin-bottom:12px; line-height:1.3;">
                    {{ $product->name }}</h1>

                {{-- Category --}}
                <div style="margin-bottom:16px;">
                    <span
                        style="font-size:12px; background:rgba(99,102,241,0.1); color:#a5b4fc; padding:4px 12px; border-radius:20px;">
                        <i class="fa {{ $product->category->icon ?? 'fa-tag' }}"></i> {{ $product->category->name }}
                    </span>
                </div>

                {{-- Price --}}
                <div style="margin-bottom:20px;">
                    @if ($product->discount_price)
                        <div style="font-family:'Playfair Display',serif; font-size:32px; font-weight:700; color:#86efac;">
                            ৳{{ number_format($product->discount_price, 0) }}
                        </div>
                        <div style="display:flex; align-items:center; gap:10px; margin-top:4px;">
                            <span
                                style="font-size:18px; color:var(--text-muted); text-decoration:line-through;">৳{{ number_format($product->price, 0) }}</span>
                            <span
                                style="font-size:13px; background:rgba(239,68,68,0.1); color:#fca5a5; padding:3px 10px; border-radius:20px; font-weight:600;">
                                {{ round((($product->price - $product->discount_price) / $product->price) * 100) }}% OFF
                            </span>
                        </div>
                    @else
                        <div
                            style="font-family:'Playfair Display',serif; font-size:32px; font-weight:700; color:var(--white);">
                            ৳{{ number_format($product->price, 0) }}
                        </div>
                    @endif
                </div>

                {{-- Stock --}}
                <div style="margin-bottom:24px; display:flex; align-items:center; gap:8px;">
                    @if ($product->stock > 0)
                        <span
                            style="width:8px; height:8px; border-radius:50%; background:#86efac; display:inline-block;"></span>
                        <span style="font-size:13px; color:#86efac;">In Stock ({{ $product->stock }} available)</span>
                    @else
                        <span
                            style="width:8px; height:8px; border-radius:50%; background:#fca5a5; display:inline-block;"></span>
                        <span style="font-size:13px; color:#fca5a5;">Out of Stock</span>
                    @endif
                </div>

                {{-- Add to Cart --}}
                @if ($product->stock > 0)
                    <div style="display:flex; gap:12px; margin-bottom:24px;">
                        @auth('buyer')
                            <form method="POST" action="{{ route('buyer.cart.add', $product) }}" class="add-to-cart-form">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="add-to-cart-btn"
                                    style="padding:12px 24px; background:linear-gradient(135deg,#6366f1,#4f46e5); color:white; border:none; border-radius:12px; font-size:15px; cursor:pointer; font-weight:600; display:inline-flex; align-items:center; gap:8px;">
                                    <i class="fa fa-cart-shopping"></i> Add to Cart
                                </button>
                            </form>
                        @else
                            <a href="{{ route('buyer.login') }}" class="btn-submit"
                                style="flex:1; margin:0; background:linear-gradient(135deg,#6366f1,#4f46e5); text-align:center;">
                                <i class="fa fa-cart-shopping"></i> Add to Cart
                            </a>
                        @endauth
                        <button class="btn-icon" style="width:48px; height:48px;" title="Add to Wishlist">
                            <i class="fa fa-heart"></i>
                        </button>
                    </div>
                @endif


                {{-- Description --}}
                @if ($product->description)
                    <div style="border-top:1px solid var(--border); padding-top:20px;">
                        <h3 style="font-size:15px; font-weight:600; margin-bottom:10px;">Description</h3>
                        <p style="font-size:14px; color:var(--text-muted); line-height:1.8;">{{ $product->description }}
                        </p>
                    </div>
                @endif

            </div>
        </div>

        {{-- Related Products --}}
        @if ($related->count() > 0)
            <div style="margin-top:48px;">
                <div class="section-header">
                    <h2 class="section-heading">Related Products</h2>
                </div>
                <div class="products-grid">
                    @foreach ($related as $rel)
                        <a href="{{ route('products.show', $rel->slug) }}" class="product-card">
                            <div class="product-img-wrap">
                                @if ($rel->primaryImage)
                                    <img src="{{ asset('storage/' . $rel->primaryImage->image) }}"
                                        alt="{{ $rel->name }}" class="product-img">
                                @else
                                    <div class="product-img-placeholder">
                                        <i class="fa fa-image"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="product-info">
                                <h3 class="product-name">{{ $rel->name }}</h3>
                                <div class="product-price-row">
                                    @if ($rel->discount_price)
                                        <span class="product-price">৳{{ number_format($rel->discount_price, 0) }}</span>
                                        <span class="product-price-old">৳{{ number_format($rel->price, 0) }}</span>
                                    @else
                                        <span class="product-price">৳{{ number_format($rel->price, 0) }}</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

    </div>

@endsection

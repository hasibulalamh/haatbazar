<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HaatBazar') — Bangladesh's Premium Marketplace</title>
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/store.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

    <div class="bg-canvas">
        <div class="bg-orb bg-orb-1"></div>
        <div class="bg-orb bg-orb-2"></div>
        <div class="bg-orb bg-orb-3"></div>
    </div>
    <div class="bg-grid"></div>

    {{-- NAVBAR --}}
    <nav class="navbar">
        <div class="nav-container">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="nav-logo">
                <span class="logo-text">HaatBazar</span>
            </a>

            {{-- Search --}}
            <form action="{{ route('products.index') }}" method="GET" class="nav-search">
                <i class="fa fa-search nav-search-icon"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..."
                    class="nav-search-input">
                <button type="submit" class="nav-search-btn">Search</button>
            </form>

            {{-- Nav Actions --}}
            <div class="nav-actions">
                @if (Auth::guard('admin')->check())
                    <a href="{{ route('admin.dashboard') }}" class="nav-btn nav-btn-ghost">
                        <i class="fa fa-gauge"></i> Admin
                    </a>
                @elseif(Auth::guard('seller')->check())
                    <a href="{{ route('seller.dashboard') }}" class="nav-btn nav-btn-ghost">
                        <i class="fa fa-store"></i> My Shop
                    </a>
                @elseif(Auth::guard('buyer')->check())
                    <a href="{{ route('buyer.dashboard') }}" class="nav-btn nav-btn-ghost">
                        <i class="fa fa-user"></i> {{ explode(' ', Auth::guard('buyer')->user()->name)[0] }}
                    </a>
                @else
                    <a href="{{ route('buyer.login') }}" class="nav-btn nav-btn-ghost">
                        <i class="fa fa-user"></i> Login
                    </a>
                    <a href="{{ route('buyer.register') }}" class="nav-btn nav-btn-primary">
                        Sign Up
                    </a>
                @endif

                {{-- Cart Icon + Mini-cart Dropdown --}}
                <div class="mini-cart-wrapper" id="mini-cart-wrapper">

                    <button type="button" class="nav-icon-btn" id="cart-icon-btn" title="Cart">
                        <i class="fa fa-cart-shopping"></i>
                        @if (Auth::guard('buyer')->check())
                            {{-- sum('quantity') = Amazon style total --}}
                            @php $cartCount = Auth::guard('buyer')->user()->cartItems()->sum('quantity'); @endphp
                            <span class="nav-badge" id="cart-badge">{{ $cartCount }}</span>
                        @else
                            <span class="nav-badge" id="cart-badge">0</span>
                        @endif
                    </button>

                    {{-- Mini-cart dropdown content AJAX দিয়ে load হবে --}}

                    @auth('buyer')
                        <div class="mini-cart-dropdown" id="mini-cart-dropdown">

                            {{-- Header --}}
                            <div class="mini-cart-header">
                                <span class="mini-cart-title">
                                    <i class="fa fa-cart-shopping"></i> My Cart
                                </span>
                                <button type="button" class="mini-cart-close" id="mini-cart-close">
                                    <i class="fa fa-xmark"></i>
                                </button>
                            </div>


                            <div id="mini-cart-content">
                                @php
                                    $mcItems = Auth::guard('buyer')
                                        ->user()
                                        ->cartItems()
                                        ->with(['product.primaryImage', 'product.shop'])
                                        ->get();

                                    $mcTotal = $mcItems->sum(
                                        fn($i) => ($i->product->discount_price ?? $i->product->price) * $i->quantity,
                                    );
                                @endphp
                                @include('buyer.cart.partials.mini-cart', [
                                    'cartItems' => $mcItems,
                                    'total' => $mcTotal,
                                ])
                            </div>

                        </div>
                    @endauth

                </div>
            </div>
        </div>

        {{-- Category Bar --}}
        <div class="category-bar">
            <div class="nav-container">
                <a href="{{ route('products.index') }}" class="cat-link {{ !request('category') ? 'active' : '' }}">
                    <i class="fa fa-grid-2"></i> All
                </a>
                @foreach (\App\Models\Category::whereNull('parent_id')->take(8)->get() as $cat)
                    <a href="{{ route('products.index', ['category' => $cat->slug]) }}"
                        class="cat-link {{ request('category') === $cat->slug ? 'active' : '' }}">
                        <i class="fa {{ $cat->icon ?? 'fa-tag' }}"></i> {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </nav>

    {{-- MAIN CONTENT --}}
    <main class="main-wrap">
        @if (session('success'))
            <div class="flash-success">
                <i class="fa fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="footer">
        <div class="nav-container">
            <div class="footer-grid">
                <div>
                    <span class="logo-text" style="font-size:22px;">HaatBazar</span>
                    <p style="font-size:13px; color:var(--text-muted); margin-top:10px; line-height:1.7;">
                        Bangladesh's premium multi-vendor marketplace. Shop from thousands of verified sellers.
                    </p>
                </div>
                <div>
                    <h4
                        style="font-size:13px; font-weight:600; letter-spacing:1px; text-transform:uppercase; color:var(--text-muted); margin-bottom:14px;">
                        Quick Links</h4>
                    <div style="display:flex; flex-direction:column; gap:8px;">
                        <a href="{{ route('home') }}" class="footer-link">Home</a>
                        <a href="{{ route('products.index') }}" class="footer-link">Products</a>
                        <a href="{{ route('seller.register') }}" class="footer-link">Become a Seller</a>
                    </div>
                </div>
                <div>
                    <h4
                        style="font-size:13px; font-weight:600; letter-spacing:1px; text-transform:uppercase; color:var(--text-muted); margin-bottom:14px;">
                        Account</h4>
                    <div style="display:flex; flex-direction:column; gap:8px;">
                        @if (Auth::guard('admin')->check())
                            <a href="{{ route('admin.dashboard') }}" class="footer-link">Dashboard</a>
                        @elseif(Auth::guard('seller')->check())
                            <a href="{{ route('seller.dashboard') }}" class="footer-link">My Store</a>
                        @elseif(Auth::guard('buyer')->check())
                            <a href="{{ route('buyer.dashboard') }}" class="footer-link">My Account</a>
                        @else
                            <a href="{{ route('buyer.login') }}" class="footer-link">Login</a>
                            <a href="{{ route('buyer.register') }}" class="footer-link">Register</a>
                        @endif
                    </div>
                </div>
            </div>
            <div
                style="border-top:1px solid var(--border); margin-top:32px; padding-top:20px; text-align:center; color:var(--text-muted); font-size:12px;">
                © {{ date('Y') }} HaatBazar. All rights reserved.
            </div>
        </div>
    </footer>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // ── Mini-cart Toggle ──────────────────────────────
            const cartBtn = document.getElementById('cart-icon-btn');
            const miniCart = document.getElementById('mini-cart-dropdown');
            const miniCartClose = document.getElementById('mini-cart-close');

            if (cartBtn && miniCart) {

                cartBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    miniCart.classList.toggle('open');
                });

                if (miniCartClose) {
                    miniCartClose.addEventListener('click', function() {
                        miniCart.classList.remove('open');
                    });
                }

                document.addEventListener('click', function(e) {
                    if (!miniCart.contains(e.target) && e.target !== cartBtn) {
                        miniCart.classList.remove('open');
                    }
                });

                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') miniCart.classList.remove('open');
                });
            }

            // ── Add to Cart AJAX ──────────────────────────────
            document.querySelectorAll('.add-to-cart-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const btn = form.querySelector('.add-to-cart-btn');
                    const originalText = btn.innerHTML;

                    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Adding...';
                    btn.disabled = true;

                    fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                quantity: form.querySelector('[name="quantity"]').value
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {

                                // 1. Badge update
                                const badge = document.getElementById('cart-badge');
                                if (badge) badge.textContent = data.cart_count;

                                // 2. Mini-cart content update
                                const miniCartContent = document.getElementById(
                                    'mini-cart-content');
                                if (miniCartContent && data.fragments?.mini_cart) {
                                    miniCartContent.innerHTML = data.fragments.mini_cart;
                                }

                                // 3. Mini-cart dropdown open করো
                                if (miniCart) miniCart.classList.add('open');

                                // 4. Button success state
                                btn.innerHTML = '<i class="fa fa-circle-check"></i> Added!';
                                btn.style.background =
                                'linear-gradient(135deg,#16a34a,#15803d)';

                                setTimeout(() => {
                                    btn.innerHTML = originalText;
                                    btn.style.background =
                                        'linear-gradient(135deg,#6366f1,#4f46e5)'; // ← original color
                                    btn.disabled = false;
                                }, 2000);

                                showToast(data.message, 'success');

                            } else {
                                showToast(data.message, 'error');
                                btn.innerHTML = originalText;
                                btn.disabled = false;
                            }
                        })
                        .catch(() => {
                            showToast('Something went wrong!', 'error');
                            btn.innerHTML = originalText;
                            btn.disabled = false;
                        });
                });
            });
        });

        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.style.cssText = `
        position:fixed; bottom:24px; right:24px; z-index:9999;
        padding:14px 20px; border-radius:12px; font-size:14px; font-weight:600;
        display:flex; align-items:center; gap:8px;
        background:${type === 'success' ? 'rgba(22,163,74,0.95)' : 'rgba(239,68,68,0.95)'};
        color:white; box-shadow:0 8px 32px rgba(0,0,0,0.3);
    `;
            toast.innerHTML =
                `<i class="fa fa-${type === 'success' ? 'circle-check' : 'circle-exclamation'}"></i> ${message}`;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 3000);
        }
    </script>
    @stack('scripts')
</body>

</html>

@extends('layouts.buyer')

@section('title', 'My Cart')

@section('content')

<div class="topbar">
    <div>
        <h1 class="topbar-title">My Cart</h1>
        <p class="topbar-subtitle">{{ $cartItems->count() }} item(s) in your cart</p>
    </div>
    @if($cartItems->count() > 0)
    <div class="topbar-actions">
        <form method="POST" action="{{ route('buyer.cart.clear') }}"
              onsubmit="return confirm('Clear all items?')">
            @csrf @method('DELETE')
            <button type="submit"
                style="padding:10px 18px; background:rgba(239,68,68,0.1); color:#fca5a5; border-radius:10px; font-size:13px; border:none; cursor:pointer;">
                <i class="fa fa-trash"></i> Clear Cart
            </button>
        </form>
    </div>
    @endif
</div>

@if(session('success'))
    <div class="alert-success" style="margin-bottom:20px;">
        <i class="fa fa-circle-check"></i> {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert-error" style="margin-bottom:20px;">
        <p><i class="fa fa-circle-exclamation"></i> {{ session('error') }}</p>
    </div>
@endif

@if($cartItems->count() > 0)
<div style="display:grid; grid-template-columns:1fr 340px; gap:20px; align-items:start;">

    {{-- Cart Items --}}
    <div style="display:flex; flex-direction:column; gap:14px;">
        @foreach($cartItems as $item)
        <div class="card" style="padding:16px; display:flex; gap:16px; align-items:center;">

            {{-- Product Image --}}
            <a href="{{ route('products.show', $item->product->slug) }}">
                @if($item->product->primaryImage)
                    <img src="{{ asset('storage/' . $item->product->primaryImage->image) }}"
                        style="width:80px; height:80px; object-fit:cover; border-radius:10px; border:1px solid var(--border);">
                @else
                    <div style="width:80px; height:80px; border-radius:10px; background:rgba(255,255,255,0.05); display:flex; align-items:center; justify-content:center;">
                        <i class="fa fa-image" style="color:var(--text-muted);"></i>
                    </div>
                @endif
            </a>

            {{-- Product Info --}}
            <div style="flex:1; min-width:0;">
                <a href="{{ route('products.show', $item->product->slug) }}"
                   style="font-weight:600; font-size:14px; color:var(--text); text-decoration:none; display:block; margin-bottom:4px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                    {{ $item->product->name }}
                </a>
                <p style="font-size:12px; color:var(--text-muted); margin-bottom:8px;">
                    <i class="fa fa-store"></i> {{ $item->product->shop->name }}
                </p>
                <div style="display:flex; align-items:center; gap:8px;">
                    @if($item->product->discount_price)
                        <span style="font-weight:700; color:#4ade80;">৳{{ number_format($item->product->discount_price, 0) }}</span>
                        <span style="font-size:12px; color:var(--text-muted); text-decoration:line-through;">৳{{ number_format($item->product->price, 0) }}</span>
                    @else
                        <span style="font-weight:700; color:#4ade80;">৳{{ number_format($item->product->price, 0) }}</span>
                    @endif
                </div>
            </div>

            {{-- Quantity Update --}}
            <form method="POST" action="{{ route('buyer.cart.update', $item) }}"
                  style="display:flex; align-items:center; gap:8px;">
                @csrf @method('PATCH')
                <div style="display:flex; align-items:center; gap:6px; background:rgba(255,255,255,0.05); border:1px solid var(--border); border-radius:8px; padding:4px 8px;">
                    <button type="button" onclick="decreaseQty(this)"
                        style="width:24px; height:24px; background:rgba(255,255,255,0.05); border:none; border-radius:6px; color:var(--text); cursor:pointer; font-size:14px;">−</button>
                    <input type="number" name="quantity" value="{{ $item->quantity }}"
                        min="1" max="{{ $item->product->stock }}"
                        style="width:40px; text-align:center; background:transparent; border:none; color:var(--text); font-size:14px; font-weight:600;"
                        onchange="this.closest('form').submit()">
                    <button type="button" onclick="increaseQty(this)"
                        style="width:24px; height:24px; background:rgba(255,255,255,0.05); border:none; border-radius:6px; color:var(--text); cursor:pointer; font-size:14px;">+</button>
                </div>
            </form>

            {{-- Item Total --}}
            <div style="text-align:right; min-width:80px;">
                <div style="font-weight:700; font-size:15px; color:#a5b4fc;">
                    ৳{{ number_format(($item->product->discount_price ?? $item->product->price) * $item->quantity, 0) }}
                </div>
                <div style="font-size:11px; color:var(--text-muted);">subtotal</div>
            </div>

            {{-- Remove --}}
            <form method="POST" action="{{ route('buyer.cart.remove', $item) }}">
                @csrf @method('DELETE')
                <button type="submit"
                    style="width:32px; height:32px; background:rgba(239,68,68,0.1); color:#fca5a5; border-radius:8px; border:none; cursor:pointer;">
                    <i class="fa fa-trash"></i>
                </button>
            </form>

        </div>
        @endforeach
    </div>

    {{-- Order Summary --}}
    <div class="card" style="padding:24px; position:sticky; top:20px;">
        <h3 style="font-size:16px; font-weight:700; margin-bottom:20px;">Order Summary</h3>

        <div style="display:flex; flex-direction:column; gap:12px; margin-bottom:20px;">
            <div style="display:flex; justify-content:space-between; font-size:14px;">
                <span style="color:var(--text-muted);">Items ({{ $cartItems->count() }})</span>
                <span>৳{{ number_format($total, 0) }}</span>
            </div>
            <div style="display:flex; justify-content:space-between; font-size:14px;">
                <span style="color:var(--text-muted);">Shipping</span>
                <span style="color:#4ade80;">Free</span>
            </div>
            <div style="border-top:1px solid var(--border); padding-top:12px; display:flex; justify-content:space-between; font-weight:700; font-size:16px;">
                <span>Total</span>
                <span style="color:#a5b4fc;">৳{{ number_format($total, 0) }}</span>
            </div>
        </div>

        <a href="#"
           style="display:block; text-align:center; padding:14px; background:linear-gradient(135deg,#6366f1,#4f46e5); color:white; border-radius:12px; font-weight:600; font-size:15px; text-decoration:none;">
            Proceed to Checkout <i class="fa fa-arrow-right"></i>
        </a>

        <a href="{{ route('products.index') }}"
           style="display:block; text-align:center; padding:10px; margin-top:10px; color:var(--text-muted); font-size:13px; text-decoration:none;">
            <i class="fa fa-arrow-left"></i> Continue Shopping
        </a>
    </div>

</div>

@else
{{-- Empty Cart --}}
<div class="card" style="padding:60px; text-align:center;">
    <i class="fa fa-cart-shopping" style="font-size:48px; color:var(--text-muted); opacity:0.3; display:block; margin-bottom:16px;"></i>
    <h3 style="font-size:18px; font-weight:600; margin-bottom:8px;">Your cart is empty</h3>
    <p style="color:var(--text-muted); margin-bottom:24px;">Add some products to get started!</p>
    <a href="{{ route('products.index') }}"
       style="display:inline-flex; align-items:center; gap:8px; padding:12px 24px; background:linear-gradient(135deg,#6366f1,#4f46e5); color:white; border-radius:12px; font-weight:600; text-decoration:none;">
        <i class="fa fa-bag-shopping"></i> Browse Products
    </a>
</div>
@endif

@push('scripts')
<script>
function decreaseQty(btn) {
    const input = btn.nextElementSibling;
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
        input.closest('form').submit();
    }
}
function increaseQty(btn) {
    const input = btn.previousElementSibling;
    const max = parseInt(input.max);
    if (parseInt(input.value) < max) {
        input.value = parseInt(input.value) + 1;
        input.closest('form').submit();
    }
}
</script>
@endpush

@endsection

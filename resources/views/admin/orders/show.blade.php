@extends('layouts.admin')

@section('title', 'Order #' . $order->id)

@section('content')

<div class="topbar">
    <div>
        <h1 class="topbar-title">Order #{{ $order->id }}</h1>
        <p class="topbar-subtitle">{{ $order->created_at->format('d M Y, h:i A') }}</p>
    </div>
    <a href="{{ route('admin.orders.index') }}"
       style="display:inline-flex; align-items:center; gap:6px; font-size:13px; color:var(--text-muted); text-decoration:none;">
        <i class="fa fa-arrow-left"></i> Back to Orders
    </a>
</div>

<div style="display:flex; flex-direction:column; gap:16px; max-width:900px;">

    {{-- Status Overview --}}
    <div class="card" style="padding:20px;">
        <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
            <div>
                <div style="font-size:12px; color:var(--text-muted); margin-bottom:6px;">Order Status</div>
                <span style="font-size:13px; font-weight:700; padding:6px 16px; border-radius:20px; text-transform:uppercase;
                    background:{{ $order->statusColor() }}20; color:{{ $order->statusColor() }};">
                    {{ $order->status }}
                </span>
            </div>
            <div>
                <div style="font-size:12px; color:var(--text-muted); margin-bottom:6px;">Payment</div>
                <span style="font-size:13px; font-weight:700; padding:6px 16px; border-radius:20px;
                    background:{{ $order->paymentColor() }}20; color:{{ $order->paymentColor() }};">
                    {{ ucfirst($order->payment_status) }} · {{ strtoupper($order->payment_method) }}
                </span>
            </div>
            <div>
                <div style="font-size:12px; color:var(--text-muted); margin-bottom:6px;">Total Amount</div>
                <div style="font-size:20px; font-weight:700; color:#a5b4fc;">৳{{ number_format($order->total, 0) }}</div>
            </div>
        </div>
    </div>

    {{-- Items --}}
    <div class="card" style="padding:20px;">
        <h3 style="font-size:14px; font-weight:700; margin-bottom:16px;">
            <i class="fa fa-box" style="color:#a5b4fc;"></i> Order Items
        </h3>
        <div style="display:flex; flex-direction:column; gap:12px;">
            @foreach($order->items as $item)
            <div style="display:flex; align-items:center; gap:14px; padding:12px; background:rgba(255,255,255,0.02); border-radius:10px; border:1px solid var(--border);">
                @if($item->product?->primaryImage)
                    <img src="{{ asset('storage/' . $item->product->primaryImage->image) }}"
                         style="width:56px; height:56px; object-fit:cover; border-radius:8px; flex-shrink:0;">
                @else
                    <div style="width:56px; height:56px; border-radius:8px; background:rgba(255,255,255,0.04); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <i class="fa fa-image" style="color:var(--text-muted);"></i>
                    </div>
                @endif
                <div style="flex:1;">
                    <div style="font-size:14px; font-weight:600; margin-bottom:4px;">{{ $item->product_name }}</div>
                    <div style="font-size:12px; color:var(--text-muted);">
                        Seller: {{ $item->seller->name ?? 'N/A' }} ·
                        {{ $item->quantity }} × ৳{{ number_format($item->price, 0) }}
                    </div>
                </div>
                <div style="font-size:15px; font-weight:700; color:#a5b4fc;">
                    ৳{{ number_format($item->subtotal, 0) }}
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Buyer + Shipping --}}
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">

        <div class="card" style="padding:20px;">
            <h3 style="font-size:14px; font-weight:700; margin-bottom:14px;">
                <i class="fa fa-user" style="color:#a5b4fc;"></i> Buyer Info
            </h3>
            <div style="font-size:13px; color:var(--text-muted); line-height:2;">
                <div><span style="color:var(--white); font-weight:600;">{{ $order->buyer->name }}</span></div>
                <div><i class="fa fa-envelope" style="width:16px;"></i> {{ $order->buyer->email }}</div>
            </div>
        </div>

        <div class="card" style="padding:20px;">
            <h3 style="font-size:14px; font-weight:700; margin-bottom:14px;">
                <i class="fa fa-location-dot" style="color:#a5b4fc;"></i> Shipping Address
            </h3>
            <div style="font-size:13px; color:var(--text-muted); line-height:2;">
                <div><span style="color:var(--white); font-weight:600;">{{ $order->shipping_name }}</span></div>
                <div><i class="fa fa-phone" style="width:16px;"></i> {{ $order->shipping_phone }}</div>
                <div><i class="fa fa-map-pin" style="width:16px;"></i> {{ $order->shipping_address }}</div>
                <div><i class="fa fa-city" style="width:16px;"></i> {{ $order->shipping_city }}</div>
            </div>
        </div>

    </div>

    {{-- Notes --}}
    @if($order->notes)
    <div class="card" style="padding:16px;">
        <i class="fa fa-note-sticky" style="color:#a5b4fc;"></i>
        <span style="font-size:13px; color:var(--text-muted); margin-left:8px;">{{ $order->notes }}</span>
    </div>
    @endif

</div>

@endsection

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background:#f4f4f4; margin:0; padding:0; }
        .container { max-width:600px; margin:40px auto; background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 2px 12px rgba(0,0,0,0.08); }
        .header { background:linear-gradient(135deg,#f59e0b,#d97706); padding:32px; text-align:center; }
        .header h1 { color:#fff; margin:0; font-size:24px; }
        .header p { color:rgba(255,255,255,0.9); margin:8px 0 0; }
        .body { padding:32px; }
        .alert-box { background:#fef3c7; border:1px solid #f59e0b; border-radius:8px; padding:16px; margin-bottom:20px; font-size:14px; color:#92400e; }
        .order-info { background:#f8fafc; border-radius:8px; padding:20px; margin-bottom:20px; }
        .order-info h3 { margin:0 0 14px; font-size:14px; color:#374151; }
        .item-row { display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid #e5e7eb; font-size:13px; color:#374151; }
        .item-row:last-child { border-bottom:none; }
        .total-row { display:flex; justify-content:space-between; padding:12px 0 0; font-weight:700; font-size:15px; color:#1f2937; }
        .shipping { background:#f0fdf4; border-radius:8px; padding:16px; margin-bottom:20px; font-size:13px; color:#374151; line-height:1.8; }
        .btn { display:block; text-align:center; background:linear-gradient(135deg,#f59e0b,#d97706); color:#fff; padding:14px 28px; border-radius:8px; text-decoration:none; font-weight:700; margin:20px 0; }
        .footer { text-align:center; padding:20px; color:#9ca3af; font-size:12px; border-top:1px solid #f3f4f6; }
    </style>
</head>
<body>
<div class="container">

    <div class="header">
        <h1>🛒 HaatBazar</h1>
        <p>You have a new order!</p>
    </div>

    <div class="body">
        <p style="font-size:15px; color:#374151;">Hi <strong>Seller</strong>,</p>

        <div class="alert-box">
            🎉 You have received a new order <strong>#{{ $order->id }}</strong>! Please confirm it as soon as possible.
        </div>

        <div class="order-info">
            <h3>Order #{{ $order->id }} — {{ $order->created_at->format('d M Y, h:i A') }}</h3>
            @foreach($order->items as $item)
            <div class="item-row">
                <span>{{ $item->product_name }} × {{ $item->quantity }}</span>
                <span>৳{{ number_format($item->subtotal, 0) }}</span>
            </div>
            @endforeach
            <div class="total-row">
                <span>Your Earnings</span>
                <span>৳{{ number_format($order->items->sum('subtotal'), 0) }}</span>
            </div>
        </div>

        <div class="shipping">
            <strong>📦 Ship To:</strong><br>
            {{ $order->shipping_name }}<br>
            {{ $order->shipping_phone }}<br>
            {{ $order->shipping_address }}, {{ $order->shipping_city }}
        </div>

        <a href="{{ url('/seller/orders/' . $order->id) }}" class="btn">
            View & Confirm Order
        </a>

        <p style="font-size:13px; color:#9ca3af; text-align:center;">
            Payment: <strong>{{ strtoupper($order->payment_method) }}</strong>
        </p>
    </div>

    <div class="footer">
        © {{ date('Y') }} HaatBazar. Bangladesh's Premium Marketplace.
    </div>
</div>
</body>
</html>

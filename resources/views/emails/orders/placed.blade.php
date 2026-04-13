<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background:#f4f4f4; margin:0; padding:0; }
        .container { max-width:600px; margin:40px auto; background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 2px 12px rgba(0,0,0,0.08); }
        .header { background:linear-gradient(135deg,#6366f1,#4f46e5); padding:32px; text-align:center; }
        .header h1 { color:#fff; margin:0; font-size:24px; }
        .header p { color:rgba(255,255,255,0.8); margin:8px 0 0; }
        .body { padding:32px; }
        .status-badge { display:inline-block; background:#fef9c3; color:#854d0e; padding:6px 16px; border-radius:20px; font-size:13px; font-weight:700; margin-bottom:20px; }
        .order-info { background:#f8fafc; border-radius:8px; padding:20px; margin-bottom:20px; }
        .order-info h3 { margin:0 0 14px; font-size:14px; color:#374151; }
        .item-row { display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid #e5e7eb; font-size:13px; color:#374151; }
        .item-row:last-child { border-bottom:none; }
        .total-row { display:flex; justify-content:space-between; padding:12px 0 0; font-weight:700; font-size:15px; color:#1f2937; }
        .shipping { background:#f0fdf4; border-radius:8px; padding:16px; margin-bottom:20px; font-size:13px; color:#374151; line-height:1.8; }
        .btn { display:block; text-align:center; background:linear-gradient(135deg,#6366f1,#4f46e5); color:#fff; padding:14px 28px; border-radius:8px; text-decoration:none; font-weight:700; margin:20px 0; }
        .footer { text-align:center; padding:20px; color:#9ca3af; font-size:12px; border-top:1px solid #f3f4f6; }
    </style>
</head>
<body>
<div class="container">

    <div class="header">
        <h1>🛍️ HaatBazar</h1>
        <p>Thank you for your order!</p>
    </div>

    <div class="body">
        <p style="font-size:15px; color:#374151;">Hi <strong>{{ $order->shipping_name }}</strong>,</p>
        <p style="font-size:14px; color:#6b7280;">We've received your order and it's being reviewed by the seller.</p>

        <span class="status-badge">⏳ Order Pending</span>

        <div class="order-info">
            <h3>Order #{{ $order->id }} — {{ $order->created_at->format('d M Y') }}</h3>
            @foreach($order->items as $item)
            <div class="item-row">
                <span>{{ $item->product_name }} × {{ $item->quantity }}</span>
                <span>৳{{ number_format($item->subtotal, 0) }}</span>
            </div>
            @endforeach
            <div class="total-row">
                <span>Total</span>
                <span>৳{{ number_format($order->total, 0) }}</span>
            </div>
        </div>

        <div class="shipping">
            <strong>📦 Shipping To:</strong><br>
            {{ $order->shipping_name }}<br>
            {{ $order->shipping_phone }}<br>
            {{ $order->shipping_address }}, {{ $order->shipping_city }}
        </div>

        <a href="{{ url('/buyer/orders/' . $order->id) }}" class="btn">
            View Order Details
        </a>

        <p style="font-size:13px; color:#9ca3af; text-align:center;">
            Payment Method: <strong>{{ strtoupper($order->payment_method) }}</strong>
        </p>
    </div>

    <div class="footer">
        © {{ date('Y') }} HaatBazar. Bangladesh's Premium Marketplace.
    </div>
</div>
</body>
</html>

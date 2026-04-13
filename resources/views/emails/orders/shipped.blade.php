<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background:#f4f4f4; margin:0; padding:0; }
        .container { max-width:600px; margin:40px auto; background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 2px 12px rgba(0,0,0,0.08); }
        .header { background:linear-gradient(135deg,#0ea5e9,#0284c7); padding:32px; text-align:center; }
        .header h1 { color:#fff; margin:0; font-size:24px; }
        .header p { color:rgba(255,255,255,0.8); margin:8px 0 0; }
        .body { padding:32px; }
        .status-badge { display:inline-block; background:#e0f2fe; color:#0c4a6e; padding:6px 16px; border-radius:20px; font-size:13px; font-weight:700; margin-bottom:20px; }
        .shipping { background:#f0f9ff; border-radius:8px; padding:16px; margin-bottom:20px; font-size:13px; color:#374151; line-height:1.8; }
        .btn { display:block; text-align:center; background:linear-gradient(135deg,#0ea5e9,#0284c7); color:#fff; padding:14px 28px; border-radius:8px; text-decoration:none; font-weight:700; margin:20px 0; }
        .footer { text-align:center; padding:20px; color:#9ca3af; font-size:12px; border-top:1px solid #f3f4f6; }
    </style>
</head>
<body>
<div class="container">

    <div class="header">
        <h1>🚚 HaatBazar</h1>
        <p>Your order is on the way!</p>
    </div>

    <div class="body">
        <p style="font-size:15px; color:#374151;">Hi <strong>{{ $order->shipping_name }}</strong>,</p>
        <p style="font-size:14px; color:#6b7280;">Your order has been shipped and is on its way to you!</p>

        <span class="status-badge">🚚 Order Shipped</span>

        <div class="shipping">
            <strong>📦 Delivering To:</strong><br>
            {{ $order->shipping_name }}<br>
            {{ $order->shipping_phone }}<br>
            {{ $order->shipping_address }}, {{ $order->shipping_city }}
        </div>

        <a href="{{ url('/buyer/orders/' . $order->id) }}" class="btn">
            Track Your Order
        </a>

        @if($order->notes)
        <p style="font-size:13px; color:#9ca3af; text-align:center;">
            Your note: {{ $order->notes }}
        </p>
        @endif
    </div>

    <div class="footer">
        © {{ date('Y') }} HaatBazar. Bangladesh's Premium Marketplace.
    </div>
</div>
</body>
</html>

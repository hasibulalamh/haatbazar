@extends('layouts.admin')

@section('title', 'All Orders')

@section('content')

<div class="topbar">
    <div>
        <h1 class="topbar-title">All Orders</h1>
        <p class="topbar-subtitle">{{ $orders->total() }} total orders</p>
    </div>
</div>

{{-- Stats --}}
<div style="display:grid; grid-template-columns:repeat(5,1fr); gap:14px; margin-bottom:24px;">
    @foreach([
        ['label'=>'Total',      'count'=>$stats['total'],      'color'=>'#a5b4fc', 'icon'=>'fa-bag-shopping'],
        ['label'=>'Pending',    'count'=>$stats['pending'],    'color'=>'#fbbf24', 'icon'=>'fa-clock'],
        ['label'=>'Confirmed',  'count'=>$stats['confirmed'],  'color'=>'#818cf8', 'icon'=>'fa-circle-check'],
        ['label'=>'Shipped',    'count'=>$stats['shipped'],    'color'=>'#38bdf8', 'icon'=>'fa-truck'],
        ['label'=>'Delivered',  'count'=>$stats['delivered'],  'color'=>'#86efac', 'icon'=>'fa-box'],
    ] as $stat)
    <div class="card" style="padding:16px; text-align:center;">
        <i class="fa {{ $stat['icon'] }}" style="font-size:20px; color:{{ $stat['color'] }}; margin-bottom:8px; display:block;"></i>
        <div style="font-size:22px; font-weight:700; color:{{ $stat['color'] }};">{{ $stat['count'] }}</div>
        <div style="font-size:12px; color:var(--text-muted);">{{ $stat['label'] }}</div>
    </div>
    @endforeach
</div>

{{-- Filter tabs --}}
<div style="display:flex; gap:8px; margin-bottom:20px; flex-wrap:wrap;">
    @foreach(['all','pending','confirmed','processing','shipped','delivered','cancelled'] as $tab)
    <a href="{{ route('admin.orders.index', ['status' => $tab]) }}"
       style="padding:7px 16px; border-radius:20px; font-size:12px; font-weight:600; text-decoration:none;
           {{ request('status', 'all') === $tab
               ? 'background:rgba(99,102,241,0.2); color:#a5b4fc; border:1px solid rgba(99,102,241,0.3);'
               : 'background:rgba(255,255,255,0.04); color:var(--text-muted); border:1px solid var(--border);' }}">
        {{ ucfirst($tab) }}
    </a>
    @endforeach
</div>

{{-- Orders Table --}}
@if($orders->count() > 0)
<div class="card" style="padding:0; overflow:hidden;">
    <table style="width:100%; border-collapse:collapse;">
        <thead>
            <tr style="border-bottom:1px solid var(--border);">
                <th style="padding:14px 20px; text-align:left; font-size:12px; color:var(--text-muted); font-weight:600;">Order</th>
                <th style="padding:14px 20px; text-align:left; font-size:12px; color:var(--text-muted); font-weight:600;">Buyer</th>
                <th style="padding:14px 20px; text-align:left; font-size:12px; color:var(--text-muted); font-weight:600;">Items</th>
                <th style="padding:14px 20px; text-align:left; font-size:12px; color:var(--text-muted); font-weight:600;">Total</th>
                <th style="padding:14px 20px; text-align:left; font-size:12px; color:var(--text-muted); font-weight:600;">Status</th>
                <th style="padding:14px 20px; text-align:left; font-size:12px; color:var(--text-muted); font-weight:600;">Date</th>
                <th style="padding:14px 20px; text-align:left; font-size:12px; color:var(--text-muted); font-weight:600;">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr style="border-bottom:1px solid var(--border); transition:background 0.2s;"
                onmouseover="this.style.background='rgba(255,255,255,0.02)'"
                onmouseout="this.style.background='transparent'">

                <td style="padding:14px 20px;">
                    <div style="font-size:13px; font-weight:700;">#{{ $order->id }}</div>
                    <div style="font-size:11px; color:var(--text-muted); text-transform:uppercase;">{{ $order->payment_method }}</div>
                </td>

                <td style="padding:14px 20px;">
                    <div style="font-size:13px; font-weight:600;">{{ $order->buyer->name }}</div>
                    <div style="font-size:11px; color:var(--text-muted);">{{ $order->buyer->email }}</div>
                </td>

                <td style="padding:14px 20px;">
                    <span style="font-size:13px; color:var(--text-muted);">{{ $order->items->count() }} item(s)</span>
                </td>

                <td style="padding:14px 20px;">
                    <span style="font-size:14px; font-weight:700; color:#a5b4fc;">৳{{ number_format($order->total, 0) }}</span>
                </td>

                <td style="padding:14px 20px;">
                    <span style="font-size:11px; font-weight:700; padding:4px 10px; border-radius:20px; text-transform:uppercase;
                        background:{{ $order->statusColor() }}20; color:{{ $order->statusColor() }};">
                        {{ $order->status }}
                    </span>
                </td>

                <td style="padding:14px 20px;">
                    <span style="font-size:12px; color:var(--text-muted);">{{ $order->created_at->format('d M Y') }}</span>
                </td>

                <td style="padding:14px 20px;">
                    <a href="{{ route('admin.orders.show', $order) }}"
                       style="padding:6px 14px; background:rgba(99,102,241,0.1); color:#a5b4fc; border-radius:8px; font-size:12px; font-weight:600; text-decoration:none; border:1px solid rgba(99,102,241,0.2);">
                        View
                    </a>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div style="margin-top:20px;">{{ $orders->links() }}</div>

@else
<div class="card" style="padding:60px; text-align:center;">
    <i class="fa fa-bag-shopping" style="font-size:48px; color:var(--text-muted); opacity:0.3; display:block; margin-bottom:16px;"></i>
    <h3 style="font-size:18px; font-weight:600; margin-bottom:8px;">No orders yet</h3>
    <p style="color:var(--text-muted);">Orders will appear here when buyers start purchasing.</p>
</div>
@endif

@endsection

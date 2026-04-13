<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * All orders list with stats।
     */
    public function index(Request $request)
    {
        $query = Order::with(['buyer:id,name,email', 'items'])
            ->latest();

        // Status filter
        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(15)->withQueryString();

        // Stats
        $stats = [
            'total'     => Order::count(),
            'pending'   => Order::where('status', 'pending')->count(),
            'confirmed' => Order::where('status', 'confirmed')->count(),
            'shipped'   => Order::where('status', 'shipped')->count(),
            'delivered' => Order::where('status', 'delivered')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'stats'));
    }

    /**
     * Single order detail।
     */
    public function show(Order $order)
    {
        $order->load([
            'buyer:id,name,email',
            'items.product.primaryImage',
            'items.seller:id,name,email',
        ]);

        return view('admin.orders.show', compact('order'));
    }
}

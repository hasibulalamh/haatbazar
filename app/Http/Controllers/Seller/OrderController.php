<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Mail\OrderConfirmed;
use App\Mail\OrderShipped;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Seller এর orders list।
     */
    public function index(Request $request)
    {
        /** @var \App\Models\User $seller */
        $seller = Auth::guard('seller')->user();

        $query = Order::whereHas('items', function ($q) use ($seller) {
            $q->where('seller_id', $seller->id);
        })
            ->with([
                'buyer:id,name,email',
                'items' => fn($q) => $q->where('seller_id', $seller->id),
            ])
            ->latest();

        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(10)->withQueryString();

        $orders->each(function ($order) {
            $order->setRelation('sellerItems', $order->items);
        });

        return view('seller.orders.index', compact('orders'));
    }

    /**
     * Single order detail।
     */
    public function show(Order $order)
    {
        /** @var \App\Models\User $seller */
        $seller = Auth::guard('seller')->user();

        $hasItem = $order->items()->where('seller_id', $seller->id)->exists();
        if (!$hasItem) {
            abort(403);
        }

        $order->load([
            'buyer:id,name,email',
            'items' => fn($q) => $q->where('seller_id', $seller->id)
                ->with('product.primaryImage'),
        ]);

        $order->setRelation('sellerItems', $order->items);

        return view('seller.orders.show', compact('order'));
    }

    /**
     * Order status update + email।
     */
    public function updateStatus(Request $request, Order $order)
    {
        /** @var \App\Models\User $seller */
        $seller = Auth::guard('seller')->user();

        $hasItem = $order->items()->where('seller_id', $seller->id)->exists();
        if (!$hasItem) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered',
        ]);

        if ($order->status === 'cancelled') {
            return back()->with('error', 'Cancelled orders cannot be updated!');
        }

        $order->update(['status' => $request->status]);

        // Email notification
        try {
            $order->load('buyer', 'items');

            /** @var \App\Models\User|null $buyer */
            $buyer = $order->buyer;

            if ($buyer !== null) {
                if ($request->status === 'confirmed') {
                    Mail::to($buyer->email)->send(new OrderConfirmed($order));
                } elseif ($request->status === 'shipped') {
                    Mail::to($buyer->email)->send(new OrderShipped($order));
                }
            }
        } catch (\Exception $e) {
            Log::error('Order email failed: ' . $e->getMessage());
        }

        return back()->with('success', 'Order status updated to ' . ucfirst($request->status) . '!');
    }
}

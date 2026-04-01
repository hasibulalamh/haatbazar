<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class CartController extends Controller
{
    /**
     * Display cart items with total price.
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::guard('buyer')->user();

        // eager load product and shop relationships
        $cartItems = $user->cartItems()
            ->with(['product.primaryImage', 'product.shop'])
            ->get();

        // calculate total price considering discounts
        $total = $cartItems->sum(
            fn($item) => ($item->product->discount_price ?? $item->product->price) * $item->quantity
        );

        return view('buyer.cart.index', compact('cartItems', 'total'));
    }

    /**
     * Add a product to cart or increase quantity if already exists.
     */
    public function add(Request $request, Product $product)
{
    /** @var \App\Models\User $user */
    $user = Auth::guard('buyer')->user();

    // Check product availability
    if (!$product->is_active || !$product->shop->is_approved) {
        return response()->json(['success' => false, 'message' => 'Product is not available'], 422);
    }

    $quantity = $request->quantity ?? 1;

    $cartItem = CartItem::where('user_id', $user->id)
        ->where('product_id', $product->id)->first();

    if ($cartItem) {
        $newQuantity = $cartItem->quantity + $quantity;
        if ($newQuantity > $product->stock) {
            return response()->json(['success' => false, 'message' => 'Not enough stock available'], 422);
        }
        $cartItem->update(['quantity' => $newQuantity]);
    } else {
        CartItem::create([
            'user_id'    => $user->id,
            'product_id' => $product->id,
            'quantity'   => $quantity,
        ]);
    }

 // Return cart count for navbar update
$cartCount = $user->cartItems()->sum('quantity');

// Fragment: mini-cart HTML render — eager load optimize করা
$cartItems = $user->cartItems()
    ->with([
        'product' => fn($q) => $q->select('id','name','slug','price','discount_price','stock'),
        'product.primaryImage' => fn($q) => $q->select('id','product_id','image'),
        'product.shop' => fn($q) => $q->select('id','name'),
    ])
    ->get();

$total = $cartItems->sum(
    fn($item) => ($item->product->discount_price ?? $item->product->price) * $item->quantity
);

$miniCartHtml = view('buyer.cart.partials.mini-cart',
    compact('cartItems', 'total')
)->render();

return response()->json([
    'success'    => true,
    'message'    => 'Product added to cart!',
    'cart_count' => $cartCount,
    'fragments'  => [
        'mini_cart' => $miniCartHtml,
    ],
]);
}

     /**
     * Update the quantity of a specific cart item.
     */

     public function update(Request $request, CartItem $cartItem){

     /** @var \App\Models\User $user */
        $user = Auth::guard('buyer')->user();

       // Check ownership
        if ($cartItem->user_id !== $user->id) {
            abort(403);
        }
        // Validate quantity
        $request->validate([
         'quantity' => 'required|integer|min:1|max:' . $cartItem->product->stock,
        ]);

         // Update quantity
        $cartItem->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Cart updated!');

     }

     /**
     * Remove a specific item from the cart.
     */
    public function remove(CartItem $cartItem)
    {
        /** @var \App\Models\User $user */
        $user = Auth::guard('buyer')->user();

        // Check ownership
        if ($cartItem->user_id !== $user->id) {
            abort(403);
        }

        // Delete cart item
        $cartItem->delete();

        return back()->with('success', 'Item removed from cart!');
    }

    /**
     * Clear all items from the buyer's cart.
     */
    public function clear()
    {
        /** @var \App\Models\User $user */
        $user = Auth::guard('buyer')->user();

        // Delete all cart items for this user
        $user->cartItems()->delete();

        return back()->with('success', 'Cart cleared!');
    }
}

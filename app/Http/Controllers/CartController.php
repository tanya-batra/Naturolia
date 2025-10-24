<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function viewCart()
{
    $user = Auth::user();
    $cart = Cart::where('user_id', $user->id)->with('items.product.images')->first();

    $items = $cart ? $cart->items : collect();

    return view('add-cart', [
        'cart' => $cart,
        'items' => $items
    ]);
}
    // Add product to cart
    public function addToCart($productId)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You need to log in first.');
        }

        $user = Auth::user();
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        $product = Product::findOrFail($productId);

        // Check if product is already in the cart
        $cartItem = CartItem::where('cart_id', $cart->id)
                            ->where('product_id', $product->id)
                            ->first();

        if ($cartItem) {
            // If already in cart, increment quantity
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            // Add new item to cart
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => 1,
                'price' => $product->price,
            ]);
        }

        return redirect()->route('cart.view')->with('success', 'Product added to cart!');
    }

    // Remove item from cart
    public function removeItem($cartItemId)
    {
        $cartItem = CartItem::findOrFail($cartItemId);
        $cartItem->delete();

        return redirect()->route('cart.view')->with('success', 'Item removed from cart');
    }

    public function updateItemQuantity(Request $request, $cartItemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

       
        $cartItem = CartItem::findOrFail($cartItemId);

      
        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return response()->json([
            'success' => true,
            'updated_quantity' => $cartItem->quantity,
            'updated_subtotal' => number_format($cartItem->price * $cartItem->quantity, 2),
            'updated_total' => number_format(
                $cartItem->cart->items->sum(function($item) {
                    return $item->price * $item->quantity;
                }) + 
                $cartItem->cart->items->sum(function($item) {
                    return ($item->price * $item->quantity) * 0.18; // Tax (GST 18%)
                }), 
                2
            )
        ]);
    }
}

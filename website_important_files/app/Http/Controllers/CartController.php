<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    // Display the cart
    public function index()
    {
        $userId = Auth::id();

        $cartItems = Cart::where('user_id', $userId)
            ->whereNull('order_id')
            ->with('product')
            ->get();

        $subtotal = $cartItems->sum(fn($item) => $item->price * $item->quantity);
        $total    = $subtotal;

        return view('customer.cart', compact('cartItems', 'subtotal', 'total'));
    }

    // Add item to cart
    public function store(Request $request)
    {
        $userId = Auth::id();
        $productId = $request->id;
        $price = $request->price;
        $quantity = $request->quantity ?? 1;

        // Check if the product is already in the cart
        $cartItem = Cart::where('user_id', $userId)
            ->where('product_id', $productId)->whereNull('order_id')
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'price' => $price,
                'quantity' => $quantity,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    // Update Quantity
    public function update(Request $request)
    {
        $quantities = $request->quantity ?? [];
        $userId = Auth::id();

        foreach ($quantities as $id => $qty) {
            $cartItem = Cart::where('user_id', $userId)->where('id', $id)->first();
            if ($cartItem && $qty > 0) {
                $cartItem->quantity = $qty;
                $cartItem->save();
            }
        }

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully!');
    }

    // Remove single item

    public function destroy($id)
    {
        $cartItem = Cart::where('user_id', Auth::id())->where('id', $id)->first();
        if ($cartItem) {
            $cartItem->delete();
        }
        return redirect()->route('cart.index')->with('success', 'Item removed!');
    }
    

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class OrderController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        $cartItems = Cart::with('product')->where('user_id', $user->id)->whereNull('order_id')->get();

        return view('customer.orders.create', compact('cartItems', 'user'));
    }
    public function store(Request $request)
    {
        $user = Auth::user();

    $cartItems = Cart::with('product')
        ->where('user_id', $user->id)
        ->whereNull('order_id')
        ->get();
    if ($cartItems->isEmpty()) {
        return redirect()->route('cart.index')
            ->with('error', 'Your cart is empty.');
    }

    foreach ($cartItems as $item) {
        if (!$item->product) {
            return redirect()->route('cart.index')
                ->with('error', 'One of the products is no longer available.');
        }

        if ($item->product->qty < $item->quantity) {
            return redirect()->route('cart.index')
                ->with('error', "Not enough stock for {$item->product->name}. Available: {$item->product->qty}, requested: {$item->quantity}.");
        }
    }

    DB::transaction(function () use ($request, $user, $cartItems) {

        $total = $cartItems->sum(fn($item) => $item->price * $item->quantity);

        $order = Order::create([
            'user_id' => $user->id,
            'name'    => $request->name ?? $user->name ?? 'Unknown',
            'email'   => $request->email,
            'phone'   => $request->phone,
            'address' => $request->address,
            'total'   => $total,
        ]);

        Cart::where('user_id', $user->id)
            ->whereNull('order_id')
            ->update(['order_id' => $order->id]);

        foreach ($cartItems as $item) {
            $productId = $item->product->id;
            $qty       = $item->quantity;

            Product::where('id', $productId)
                ->decrement('qty', $qty);
        }
    });

    return redirect()->route('home')
        ->with('status', 'Order placed successfully!');
    }
    public function show($orderId)
    {
        $user = Auth::user();

        // Fetch the order for this user
        $order = Order::where('id', $orderId)
            ->where('user_id', $user->id)
            ->firstOrFail();

        // Get all cart items associated with this order
        $items = Cart::with('product')
            ->where('order_id', $order->id)
            ->get();

        return view('customer.orders.show', [
            'order' => $order,
            'items' => $items,
        ]);
    }
}

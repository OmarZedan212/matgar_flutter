<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CategoryGroup;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class MobileApiController extends Controller
{
    public function categories()
    {
        $groups = CategoryGroup::with([
            'categories' => function ($query) {
                $query->where('status', 'active')->orderBy('name');
            },
        ])
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return response()->json([
            'data' => $groups->map(function ($group) {
                return [
                    'id' => $group->id,
                    'name' => $group->name,
                    'slug' => $group->slug,
                    'categories' => $group->categories->map(function ($category) {
                        return [
                            'id' => $category->id,
                            'name' => $category->name,
                            'slug' => $category->slug,
                        ];
                    })->values(),
                ];
            })->values(),
        ]);
    }

    public function products(Request $request)
    {
        $sellerId = $this->currentSellerId();

        $products = Product::query()
            ->with(['category.group', 'seller'])
            ->where('qty', '>', 0)
            ->when($sellerId, function ($query) use ($sellerId) {
                $query->where('seller_id', '!=', $sellerId);
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            })
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->where('category_id', $request->category);
            })
            ->when($request->filled('group'), function ($query) use ($request) {
                $query->whereHas('category', function ($categoryQuery) use ($request) {
                    $categoryQuery->where('category_group_id', $request->group);
                });
            })
            ->when($request->filled('max_price'), function ($query) use ($request) {
                $query->where('price', '<=', $request->max_price);
            })
            ->latest()
            ->paginate((int) $request->get('per_page', 20));

        return response()->json([
            'data' => $products->getCollection()->map(fn ($product) => $this->productResource($product))->values(),
            'meta' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
            ],
        ]);
    }

    public function product($id)
    {
        $sellerId = $this->currentSellerId();

        $product = Product::with(['category.group', 'seller'])
            ->when($sellerId, function ($query) use ($sellerId) {
                $query->where('seller_id', '!=', $sellerId);
            })
            ->findOrFail($id);

        $related = Product::with(['category.group', 'seller'])
            ->where('qty', '>', 0)
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->when($sellerId, function ($query) use ($sellerId) {
                $query->where('seller_id', '!=', $sellerId);
            })
            ->limit(8)
            ->get();

        return response()->json([
            'data' => $this->productResource($product),
            'related' => $related->map(fn ($item) => $this->productResource($item))->values(),
        ]);
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'dob' => ['nullable', 'date'],
            'gender' => ['nullable', 'in:male,female'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'address' => $data['address'] ?? null,
            'phone' => $data['phone'] ?? null,
            'dob' => $data['dob'] ?? null,
            'gender' => $data['gender'] ?? null,
        ]);

        event(new Registered($user));

        return $this->tokenResponse($user, 'Account created successfully.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Wrong email or password.',
            ], 422);
        }

        return $this->tokenResponse($request->user(), 'Logged in successfully.');
    }

    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken();

        if ($token) {
            $token->delete();
        }

        return response()->json([
            'message' => 'Logged out successfully.',
        ]);
    }

    public function profile(Request $request)
    {
        return response()->json([
            'data' => $this->userResource($request->user()),
        ]);
    }

    public function updateProfile(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $request->user()->id],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:255'],
        ]);

        $request->user()->update($data);

        return response()->json([
            'message' => 'Profile updated successfully.',
            'data' => $this->userResource($request->user()->fresh()),
        ]);
    }

    public function cart(Request $request)
    {
        return response()->json($this->cartPayload($request->user()->id));
    }

    public function addToCart(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        $product = Product::where('id', $data['product_id'])
            ->where('qty', '>', 0)
            ->firstOrFail();

        if ($this->currentSellerId() && $product->seller_id === $this->currentSellerId()) {
            return response()->json([
                'message' => 'You cannot add your own product to cart.',
            ], 422);
        }

        $quantity = $data['quantity'] ?? 1;
        $cartItem = Cart::where('user_id', $request->user()->id)
            ->where('product_id', $product->id)
            ->whereNull('order_id')
            ->first();

        $newQuantity = (optional($cartItem)->quantity ?? 0) + $quantity;

        if ($newQuantity > $product->qty) {
            return response()->json([
                'message' => "Only {$product->qty} items are available.",
            ], 422);
        }

        if ($cartItem) {
            $cartItem->update([
                'quantity' => $newQuantity,
                'price' => $product->price,
            ]);
        } else {
            Cart::create([
                'user_id' => $request->user()->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price,
            ]);
        }

        return response()->json($this->cartPayload($request->user()->id));
    }

    public function updateCartItem(Request $request, Cart $cart)
    {
        if ($cart->user_id !== $request->user()->id || $cart->order_id !== null) {
            abort(404);
        }

        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:0'],
        ]);

        if ($data['quantity'] === 0) {
            $cart->delete();

            return response()->json($this->cartPayload($request->user()->id));
        }

        $product = Product::findOrFail($cart->product_id);

        if ($data['quantity'] > $product->qty) {
            return response()->json([
                'message' => "Only {$product->qty} items are available.",
            ], 422);
        }

        $cart->update([
            'quantity' => $data['quantity'],
            'price' => $product->price,
        ]);

        return response()->json($this->cartPayload($request->user()->id));
    }

    public function removeCartItem(Request $request, Cart $cart)
    {
        if ($cart->user_id !== $request->user()->id || $cart->order_id !== null) {
            abort(404);
        }

        $cart->delete();

        return response()->json($this->cartPayload($request->user()->id));
    }

    public function checkout(Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:255'],
        ]);

        $cartItems = Cart::with('product')
            ->where('user_id', $user->id)
            ->whereNull('order_id')
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'message' => 'Your cart is empty.',
            ], 422);
        }

        foreach ($cartItems as $item) {
            if (! $item->product || $item->product->qty < $item->quantity) {
                $productName = optional($item->product)->name ?? 'this product';

                return response()->json([
                    'message' => "Not enough stock for {$productName}.",
                ], 422);
            }
        }

        $order = DB::transaction(function () use ($cartItems, $data, $user) {
            $total = $cartItems->sum(fn ($item) => $item->price * $item->quantity);

            $order = Order::create([
                'user_id' => $user->id,
                'name' => $data['name'] ?? $user->name,
                'email' => $data['email'] ?? $user->email,
                'phone' => $data['phone'] ?? $user->phone ?? '',
                'address' => $data['address'] ?? $user->address ?? '',
                'total' => $total,
                'dob' => $user->dob,
                'gender' => $user->gender,
            ]);

            Cart::whereIn('id', $cartItems->pluck('id'))->update(['order_id' => $order->id]);

            foreach ($cartItems as $item) {
                Product::where('id', $item->product_id)->decrement('qty', $item->quantity);
            }

            return $order->fresh();
        });

        return response()->json([
            'message' => 'Order placed successfully.',
            'data' => $this->orderResource($order),
        ], 201);
    }

    public function orders(Request $request)
    {
        $orders = Order::where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return response()->json([
            'data' => $orders->map(fn ($order) => $this->orderResource($order))->values(),
        ]);
    }

    public function order(Request $request, Order $order)
    {
        if ($order->user_id !== $request->user()->id) {
            abort(404);
        }

        return response()->json([
            'data' => $this->orderResource($order, true),
        ]);
    }

    private function tokenResponse(User $user, string $message)
    {
        $token = $user->createToken('matgar-mobile')->plainTextToken;

        return response()->json([
            'message' => $message,
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => $this->userResource($user),
        ]);
    }

    private function userResource(User $user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'address' => $user->address,
            'dob' => $user->dob,
            'gender' => $user->gender,
        ];
    }

    private function productResource(Product $product)
    {
        return [
            'id' => $product->id,
            'seller_id' => $product->seller_id,
            'name' => $product->name,
            'slug' => $product->slug,
            'description' => $product->description,
            'price' => (float) $product->price,
            'old_price' => $product->old_price ? (float) $product->old_price : null,
            'quantity' => (int) $product->qty,
            'rating' => (int) $product->rating,
            'badge' => $product->badge,
            'is_featured' => (bool) $product->badge,
            'image_url' => $product->image_path ? asset('storage/' . $product->image_path) : null,
            'category' => $product->category ? [
                'id' => $product->category->id,
                'name' => $product->category->name,
                'slug' => $product->category->slug,
                'group' => $product->category->group ? [
                    'id' => $product->category->group->id,
                    'name' => $product->category->group->name,
                    'slug' => $product->category->group->slug,
                ] : null,
            ] : null,
            'seller' => $product->seller ? [
                'id' => $product->seller->id,
                'shop_name' => $product->seller->shop_name,
                'slug' => $product->seller->slug,
            ] : null,
        ];
    }

    private function currentSellerId()
    {
        $user = auth('sanctum')->user();

        if (! $user || ! $user->seller) {
            return null;
        }

        return $user->seller->id;
    }

    private function cartPayload(int $userId)
    {
        $items = Cart::where('user_id', $userId)
            ->whereNull('order_id')
            ->with('product.category.group')
            ->get();

        return [
            'data' => $items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'product_id' => $item->product_id,
                    'quantity' => (int) $item->quantity,
                    'price' => (float) $item->price,
                    'line_total' => (float) ($item->price * $item->quantity),
                    'product' => $item->product ? $this->productResource($item->product) : null,
                ];
            })->values(),
            'summary' => [
                'count' => $items->sum('quantity'),
                'subtotal' => (float) $items->sum(fn ($item) => $item->price * $item->quantity),
                'total' => (float) $items->sum(fn ($item) => $item->price * $item->quantity),
            ],
        ];
    }

    private function orderResource(Order $order, bool $includeItems = false)
    {
        $payload = [
            'id' => $order->id,
            'status' => $order->status,
            'name' => $order->name,
            'email' => $order->email,
            'phone' => $order->phone,
            'address' => $order->address,
            'total' => (float) $order->total,
            'created_at' => optional($order->created_at)->toIso8601String(),
        ];

        if ($includeItems) {
            $items = Cart::with('product.category.group')
                ->where('order_id', $order->id)
                ->get();

            $payload['items'] = $items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'product_id' => $item->product_id,
                    'quantity' => (int) $item->quantity,
                    'price' => (float) $item->price,
                    'line_total' => (float) ($item->price * $item->quantity),
                    'product' => $item->product ? $this->productResource($item->product) : null,
                ];
            })->values();
        }

        return $payload;
    }
}

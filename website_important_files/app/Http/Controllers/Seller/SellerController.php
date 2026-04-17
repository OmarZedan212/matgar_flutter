<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Seller;
use App\Models\Cart;
use App\Models\CategoryGroup;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    public function index() {

        $seller_id = Seller::where("user_id", auth()->id())->first("id");
        if(!isset($seller_id->id)){
            return "Seller Not Found";
        }
        $inventoryData = Product::where("seller_id", $seller_id->id)->with("category")->get();
        return view('seller.index', compact('inventoryData'));
    }
    public function store_product(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'cost'       => 'required|numeric|min:0',
            'qty'       => 'required|integer|min:0',
            'category_id' => 'nullable|integer|exists:categories,id',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:2048',
        ]);

        $seller_id = Seller::where("user_id", auth()->id())->first("id");

        if(!isset($seller_id->id)){
            return "Seller Not Found";
        }

        $data['seller_id'] = $seller_id->id;

        $product = Product::create($data);
        $data2 = [];
        if ($request->hasFile('image')) {
            $productId = $product->id;

            $filename = $productId . '.' . $request->file('image')->getClientOriginalExtension();

            $data2['image_path'] = $request->file('image')
                ->storeAs('products', $filename, 'public');
        }
        $product->update($data2);
        $product->load('category:id,name');
        return response()->json([
            'message' => 'Product created successfully',
            'product' => $product,
        ]);
    }

    public function update_product(Request $request)
    {
        $product = Product::find($request->id);
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'cost'       => 'required|numeric|min:0',
            'qty'       => 'required|integer|min:0',
            'category_id' => 'nullable|integer|exists:categories,id',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('image')) {

            $filename = $product->id . '.' . $request->file('image')->getClientOriginalExtension();

            $data['image_path'] = $request->file('image')
                ->storeAs('products', $filename, 'public');
        }
        $seller_id = Seller::where("user_id", auth()->id())->first("id");
        if(!isset($seller_id->id)){
            return "Seller Not Found";
        }
        $data['seller_id'] = $seller_id->id;
        $product->update($data);
        $product->load('category:id,name');
        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $product,
        ]);
    }
    public function delete_product($id){
        Product::where('id', $id)->delete();

        return response()->json([
            'message' => 'Product deleted successfully',
        ]);
    }
    public function update_order_status(Request $request)
{
    $request->validate([
        'id'     => 'required|integer|exists:orders,id',
        'status' => 'required|string|in:Pending,Shipped,Delivered,Cancelled',
    ]);

    $order = Order::findOrFail($request->id);
    $order->status = $request->status;
    $order->save();

    return response()->json(['success' => true]);
}


    public function dashboard()
    {
        $sellerId = auth()->user()->seller->id; // adjust if needed

        // Define current week range (Mon–Sun)
        $startOfWeek = Carbon::now()->startOfWeek(); // Monday
        $endOfWeek   = Carbon::now()->endOfWeek();   // Sunday

        // Get revenue per day for this seller within this week
        $orders = Order::selectRaw('DATE(orders.created_at) as date, SUM(carts.price * carts.quantity) as revenue')
            ->join('carts', 'carts.order_id', '=', 'orders.id')
            ->join('products', 'products.id', '=', 'carts.product_id')
            ->where('products.seller_id', $sellerId)
            ->whereBetween('orders.created_at', [$startOfWeek, $endOfWeek])
            ->groupBy('date')
            ->orderBy('date')
            ->get();


        // Build labels & data arrays for the chart
        $labels = [];
        $data   = [];

        // Make sure all days of the week exist (Mon..Sun)
        $period = new \DatePeriod(
            $startOfWeek,
            new \DateInterval('P1D'),
            $endOfWeek->copy()->addDay() // inclusive
        );

        foreach ($period as $date) {
            $labels[] = $date->format('D'); // Mon, Tue, ...
            $dayData = $orders->firstWhere('date', $date->format('Y-m-d'));
            $data[] = $dayData ? (float) $dayData->revenue : 0;
        }

        $totalRevenue = Cart::join('products', 'products.id', '=', 'carts.product_id')
        ->where('products.seller_id', $sellerId)
        ->whereNotNull('order_id')
        ->selectRaw('COALESCE(SUM(carts.price * carts.quantity), 0) as revenue')
        ->value('revenue');

    // Total Orders (distinct order_id from carts for this seller)
    $totalOrders = Cart::join('products', 'products.id', '=', 'carts.product_id')
        ->where('products.seller_id', $sellerId)
        ->distinct('carts.order_id')
        ->count('carts.order_id');

    // Total Products (owned by this seller)
    $totalProducts = Product::where('seller_id', $sellerId)->count();

    return view('seller.dashboard', [
        'totalRevenue'  => $totalRevenue,
        'totalOrders'   => $totalOrders,
        'totalProducts' => $totalProducts,
         'salesLabels' => $labels,
         'salesData'   => $data,
    ]);
    }

    public function inventory(){
        $seller_id = Seller::where("user_id", auth()->id())->first("id");
        if(!isset($seller_id->id)){
            return "Seller Not Found";
        }
        $inventoryData = Product::where("seller_id", $seller_id->id)->with("category")->get();

        $category_groups = CategoryGroup::where('status', 'active')
                            ->whereHas('categories', function ($q) {
                                $q->where('status', 'active');
                            })
                            ->with([
                                'categories' => function ($q) {
                                    $q->where('status', 'active')
                                    ->orderBy('name');
                                }
                            ])
                            ->orderBy('name')
                            ->get();

        return view('seller.inventory', compact('inventoryData', 'category_groups'));
    }
    public function orders()
{
    $sellerId = Auth::user()->seller->id;

    $orders = Order::query()
        ->join('carts', 'carts.order_id', '=', 'orders.id')
        ->join('products', 'products.id', '=', 'carts.product_id')
        ->join('users', 'users.id', '=', 'orders.user_id')
        ->where('products.seller_id', $sellerId)
        ->groupBy('orders.id', 'users.name', 'orders.created_at', 'orders.status')
        ->selectRaw('
            orders.id,
            users.name as customer_name,
            orders.created_at,
            orders.status,
            COALESCE(SUM(carts.price * carts.quantity), 0) as total_for_seller
        ')
        ->orderByDesc('orders.created_at')
        ->get();

    $ordersData = $orders->map(function ($order) {
        return [
            'id'         => $order->id,
            'display_id' => '#ORD-' . str_pad($order->id, 4, '0', STR_PAD_LEFT),
            'customer'   => $order->customer_name,
            'date'       => $order->created_at->format('M d, Y'),
            'total'      => (float) $order->total_for_seller,
            'status'     => ucfirst($order->status),
        ];
    });

    return view('seller.orders', [
        'ordersData' => $ordersData,
    ]);
}
public function show_order($id)
{
    $seller = Auth::user()->seller;   // تأكد إن عندك relation user->seller
    $sellerId = $seller->id;

    // نجيب الأوردر نفسه (نتأكد إنه موجود)
    $order = Order::with('user')->findOrFail($id);

    // نجيب الـ items الخاصة بالبائع ده فقط من carts
    $items = Cart::query()
        ->join('products', 'products.id', '=', 'carts.product_id')
        ->where('carts.order_id', $order->id)
        ->where('products.seller_id', $sellerId)
        ->select([
            'carts.id',
            'carts.quantity',
            'carts.price',
            'products.name as product_name',
            'products.image_path as product_image', // لو عندك عمود للصورة
        ])
        ->get()
        ->map(function ($row) {
            $row->line_total = $row->price * $row->quantity;
            return $row;
        });

    // إجمالي البائع في الأوردر ده فقط
    $totalForSeller = $items->sum('line_total');

    return view('seller.order-show', [
        'order'          => $order,
        'items'          => $items,
        'totalForSeller' => $totalForSeller,
    ]);
}
    public function analytics(){
        return view("seller.analytics");
    }
    public function settings()
{
    $seller = Seller::where('user_id', auth()->id())->first();

    return view('seller.settings', compact('seller'));
}
public function update_settings(Request $request)
{
    $data = $request->validate([
        'shop_name'           => 'required|string|max:255',
        'description'         => 'nullable|string',

        'business_email'      => 'nullable|email|max:255',
        'support_phone'       => 'nullable|string|max:50',
        'address'             => 'nullable|string|max:255',

        'facebook_page'       => 'nullable|url|max:255',
        'instagram_profile'   => 'nullable|url|max:255',
    ]);

    $data['user_id'] = auth()->id();

    $seller = Seller::updateOrCreate(
        ['user_id' => auth()->id()],
        $data
    );

    return response()->json([
        'success'    => true,
        'store_name' => $seller->shop_name,
    ]);
}
}

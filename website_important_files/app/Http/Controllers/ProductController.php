<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CategoryGroup;

class ProductController extends Controller
{
    /**
     * Display the shop page with filters (Category, Price, Rating).
     */
    public function index(Request $request)
    {
        $query = Product::query();
        $query->where('qty', '>', 0);
        if (auth()->check() && auth()->user()->seller) {
            $query->where('seller_id', '!=', auth()->user()->seller->id);
        }
     
        
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        if ($request->filled('category')) {
            $categories = (array) $request->category;
        
            $query->whereIn('category_id', $categories);
        }

        if ($request->filled('group')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('category_group_id', $request->group);
            });
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // 4. Filter by Rating
        // If rating is 4, we show products with 4 stars or more
        //if ($request->filled('rating') && $request->rating > 0) {
        //    $query->where('rating', '>=', $request->rating);
        //}

        $products = $query->paginate(12);

        $products->appends($request->all());
        $category_groups = CategoryGroup::with('categories')->get();

        return view('customer.shop', compact('products', 'category_groups'));
    }

    /**
     * Display the specified product.
     * Route Name: customer.product
     */
    public function show($id)
        {
            $product = Product::with(['category.group', 'seller'])
                ->findOrFail($id);

            $products = Product::where('category_id', $product->category_id)
                ->where('id', '!=', $product->id);
                
            if (auth()->check() && auth()->user()->seller) {
                $products->where('seller_id', '!=', auth()->user()->seller->id);
            }
            $products->limit(8)->get();
            return view('customer.product', [
                'product'  => $product,
                'products' => $products,
            ]);
        }

}

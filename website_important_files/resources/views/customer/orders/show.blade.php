@extends('layouts.app')
@section('title', 'Order #' . $order->id)

@section('style')
<style>
/* Container */
.main-container {
    max-width: 1000px;
    margin: 40px auto;
    padding: 0 20px;
}

/* Table */
.table-container {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    overflow-x: auto;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
    margin-top: 20px;
}

.pro-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 600px;
}

.pro-table th, .pro-table td {
    text-align: left;
    padding: 15px 20px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}

.pro-table th {
    background: #f8fafc;
    color: #64748b;
    font-size: 0.75rem;
    text-transform: uppercase;
}

.pro-table img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 6px;
    transition: transform 0.2s;
}

.pro-table img:hover {
    transform: scale(1.05);
}

/* Badges */
.badge {
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
}
.badge.success { background: #ecfdf5; color: #059669; }
.badge.warning { background: #fffbeb; color: #d97706; }

/* Button */
.btn-primary {
    background: #2563eb;
    color: white;
    padding: 10px 25px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    display: inline-block;
    margin-top: 20px;
    text-decoration: none;
}
</style>
@endsection

@section('content')
<div class="main-container">

    <h2 style="margin-bottom: 20px;">Order #{{ $order->id }}</h2>

    <div class="table-container">
        <table class="pro-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    @php
                        $imgUrl = $item->product && $item->product->image_path 
                            ? asset('storage/' . $item->product->image_path) 
                            : asset('images/no-image.png');
                    @endphp
                    <tr>
                        <td>
                            @if($item->product)
                                <a href="{{ route('customer.product', $item->product->id) }}">
                                    <img src="{{ $imgUrl }}" alt="{{ $item->product->name }}">
                                </a>
                            @else
                                <img src="{{ $imgUrl }}" alt="No Image">
                            @endif
                        </td>
                        <td>
                        <a href="{{ route('customer.product', $item->product->id) }}">
                        {{ $item->product->name ?? 'Product Deleted' }}
                        </a>
                        </td>
                        <td>${{ number_format($item->product->price ?? 0, 2) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format(($item->product->price ?? 0) * $item->quantity, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center; padding:20px;">No items found in this order.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align:right; font-weight:bold;">Total:</td>
                    <td>${{ number_format($order->total, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="5" style="text-align:right;">
                        <span class="badge {{ $order->status === 'completed' ? 'success' : 'warning' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    <a href="{{ route('customer.account') }}" class="btn-primary">Back to My Account</a>
</div>
@endsection

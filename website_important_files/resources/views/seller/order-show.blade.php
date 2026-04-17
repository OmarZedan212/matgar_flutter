@extends('layouts.seller')
@section('title', 'Order Details')

@section('style')
<style>
.order-header-card {
    background: #ffffff;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    padding: 20px 24px;
    margin-bottom: 20px;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
}
.order-header-row {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
}
.order-meta span {
    display: block;
    font-size: 0.85rem;
    color: #64748b;
}
.order-meta strong {
    color: #0f172a;
}
.items-table-container {
    background: #ffffff;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    padding: 15px 20px;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
}
.items-table {
    width: 100%;
    border-collapse: collapse;
}
.items-table th,
.items-table td {
    padding: 10px 8px;
    border-bottom: 1px solid #f1f5f9;
    font-size: 0.9rem;
}
.items-table th {
    text-align: left;
    text-transform: uppercase;
    font-size: 0.75rem;
    color: #64748b;
    background: #f8fafc;
}
.item-product {
    display: flex;
    align-items: center;
    gap: 10px;
}
.item-product img {
    width: 40px;
    height: 40px;
    object-fit: cover;
    border-radius: 6px;
    border: 1px solid #e2e8f0;
}
.total-row td {
    font-weight: 700;
    font-size: 1rem;
}
.back-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 0.9rem;
    color: #2563eb;
    margin-bottom: 15px;
}
.back-link i {
    font-size: 0.85rem;
}
.badge-status {
    padding: 4px 10px;
    border-radius: 999px;
    font-size: 0.75rem;
    font-weight: 600;
}
.badge-status.Pending    { background:#fffbeb; color:#d97706; }
.badge-status.Shipped    { background:#eff6ff; color:#2563eb; }
.badge-status.Delivered  { background:#ecfdf5; color:#16a34a; }
.badge-status.Cancelled  { background:#fef2f2; color:#b91c1c; }
</style>
@endsection

@section('content')
<div class="main-container">
    @include('layouts.partials.seller-sidebar')

    <main class="content-wrapper">
        <a href="{{ route('seller.orders') }}" class="back-link">
            <i class="fa-solid fa-arrow-left-long"></i> Back to Orders
        </a>

        <div class="order-header-card">
            <div class="order-header-row">
                <div class="order-meta">
                    <span>Order ID</span>
                    <strong>#ORD-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</strong>
                </div>
                <div class="order-meta">
                    <span>Customer</span>
                    <strong>{{ $order->user->name ?? 'N/A' }}</strong>
                </div>
                <div class="order-meta">
                    <span>Date</span>
                    <strong>{{ optional($order->created_at)->format('M d, Y H:i') }}</strong>
                </div>
                <div class="order-meta">
                    <span>Status</span>
                    <span class="badge-status {{ $order->status ?? 'Pending' }}">
                        {{ ucfirst($order->status ?? 'Pending') }}
                    </span>
                </div>
                <div class="order-meta">
                    <span>Total for this seller</span>
                    <strong>${{ number_format($totalForSeller, 2) }}</strong>
                </div>
            </div>
        </div>

        <div class="items-table-container">
            <h3 style="margin-bottom: 10px; font-size:1.1rem;">Order Items</h3>
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Line Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        <tr>
                            <td>
                                <div class="item-product">
                                    @if(!empty($item->product_image))
                                        <img src="{{ asset('storage/'.$item->product_image) }}" alt="">
                                    @endif
                                    <span>{{ $item->product_name }}</span>
                                </div>
                            </td>
                            <td>${{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>${{ number_format($item->line_total, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">No items for this seller in this order.</td>
                        </tr>
                    @endforelse
                    @if($items->count())
                        <tr class="total-row">
                            <td colspan="3" style="text-align:right;">Total</td>
                            <td>${{ number_format($totalForSeller, 2) }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </main>
</div>
@endsection

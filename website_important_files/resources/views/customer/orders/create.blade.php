@extends('layouts.app')
@section('title','Orders')

@section('style')
<style>
.form-card {
    background: var(--surface);
    padding: 30px;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
}
.content-header h2 {
    font-size: 1.5rem;
    color: var(--text-main);
    margin-left: 24px;
}
.input-group label {
    display: block;
    margin-bottom: 8px;
    font-size: 0.9rem;
    font-weight: 600;
}
input, select, textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    outline: none;
}
.btn-primary {
    background: var(--primary);
    color: white;
    padding: 10px 25px;
    border-radius: var(--radius);
    border: none;
    cursor: pointer;
}
.cart-container { max-width:1200px; margin:3rem auto; display:flex; gap:30px; }
.cart-items { flex:2; }
.cart-item { display:flex; align-items:center; padding:20px 0; border-bottom:1px solid #eee; }
.item-img { width:80px; height:80px; border:1px solid #eee; border-radius:8px; padding:5px; margin-right:20px; }
.item-img img { width:100%; height:100%; object-fit:contain; }
.item-details { flex:1; }
.item-actions { display:flex; gap:10px; align-items:center; }
.checkout-btn { width:100%; background:#10b981; color:#fff; padding:12px; border:none; border-radius:5px; cursor:pointer; margin-top:10px; }

</style>
@endsection

@section('content')

<div class="form-card">
    <header class="content-header"><h2>Orders Information</h2></header>

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf

    <div class="row">
            <div class="input-group">
            <label for="first_name">Full Name</label>
            <input type="text" id="first_name" name="first_name" value="{{ $user->name }}" required>
        </div>

        <div class="input-group full-width">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ $user->email }}" required readonly>
        </div>

        <div class="input-group full-width">
            <label for="phone">Phone</label>
            <input type="tel" id="phone" name="phone" value="{{ $user->phone }}" required>
        </div>

        <div class="input-group full-width">
            <label for="address">Address</label>
            <textarea id="address" name="address" required>{{ $user->address }}</textarea>
        </div>
    </div>

<br><h3>Your Cart Items</h3><hr>

@foreach($cartItems as $item)
        @php
            $img = $item->product->image_path ?? null;
            $imgUrl = $img ? asset('storage/'.$img) : asset('images/placeholder.png');
            $productSubtotal = $item->price * $item->quantity;
        @endphp
        <div class="cart-item">
                <div class="item-img">
                    <a href="{{ route('customer.product', $item->product->id) }}">
                        <img src="{{ $imgUrl }}" alt="{{ $item->product->name }}">
                    </a>
                </div>
        <div class="item-details">
            <strong>{{ $item->product->name }}</strong><br>
            quantity: {{ $item->quantity }}<br>
            Price: ${{ $item->product->price }}
        </div>
    </div>

@endforeach


<br>
<button type="submit" class="checkout-btn">Confirm Order</button>
</form>

@endsection

@extends('layouts.app')
@section('title','Your Cart')

@section('style')
<style>
.cart-container { max-width:1200px; margin:3rem auto; display:flex; gap:30px; }
.cart-items { flex:2; }
.cart-item { display:flex; align-items:center; padding:20px 0; border-bottom:1px solid #eee; }
.item-img { width:80px; height:80px; border:1px solid #eee; border-radius:8px; padding:5px; margin-right:20px; }
.item-img img { width:100%; height:100%; object-fit:contain; }
.item-details { flex:1; }
.item-actions { display:flex; gap:10px; align-items:center; }
.qty-container { display:inline-flex; align-items:center; border:1px solid #e5e7eb; border-radius:6px; height:40px; overflow:hidden; }
.qty-btn { width:35px; border:none; background:none; cursor:pointer; font-size:1.2rem; }
.qty-display { width:40px; text-align:center; font-weight:600; font-size:1rem; }
.remove-btn { border:none; background:none; color:#d23f57; cursor:pointer; font-size:1.5rem; }
.cart-summary { flex:1; border:1px solid #eee; border-radius:8px; padding:2rem; height:fit-content; }
.summary-row { display:flex; justify-content:space-between; margin-bottom:15px; }
.total-row { display:flex; justify-content:space-between; font-weight:700; font-size:1.2rem; border-top:1px solid #eee; padding-top:20px; margin-top:20px; }
.update-btn { width:100%; background:#3b82f6; color:#fff; padding:12px; border:none; border-radius:5px; cursor:pointer; margin-top:10px; }
.checkout-btn { width:100%; background:#10b981; color:#fff; padding:12px; border:none; border-radius:5px; cursor:pointer; margin-top:10px; }
</style>
@endsection

@section('content')
<div class="cart-container">

    <div class="cart-items">
        <h3>Your Cart</h3>
        <hr style="border:0;border-top:1px solid #eee;margin-bottom:20px;">

        @if(session('success'))
            <div style="color:green; margin-bottom:15px;">{{ session('success') }}</div>
        @endif

        @if($cartItems->isEmpty())
            <p style="text-align:center; padding:30px;">Your cart is empty.</p>
        @else

        {{-- UPDATE CART FORM --}}
        <form id="updateCartForm" action="{{ route('cart.update') }}" method="POST">
            @csrf

            @foreach($cartItems as $item)
            @php
                $img = $item->product->image_path ?? null;
                $imgUrl = $img ? asset('storage/'.$img) : asset('images/placeholder.png');
                $productSubtotal = $item->price * $item->quantity;
                $maxQty = $item->product->qty ?? 0;
            @endphp

            <div class="cart-item">
                {{-- Product Image --}}
                <div class="item-img">
                    <a href="{{ route('customer.product', $item->product->id) }}">
                        <img src="{{ $imgUrl }}" alt="{{ $item->product->name }}">
                    </a>
                </div>

                {{-- Product Details --}}
                <div class="item-details">
                    <div style="font-weight:600">
                        <a href="{{ route('customer.product', $item->product->id) }}" style="text-decoration:none; color:inherit;">
                            {{ $item->product->name }}
                        </a>
                    </div>
                    <div>
                        <span id="subtotal-{{ $item->id }}"
                            data-subtotal="{{ $productSubtotal }}">
                            ${{ number_format($productSubtotal, 2) }}
                        </span>
                        <br>
                        <small class="unit-price" style="color:gray;">
                            Unit Price : ${{ number_format($item->price, 2) }}
                        </small>
                        <br>
                        <small style="color:#16a34a; font-weight:600;">
                            In stock: {{ $maxQty }}
                        </small>
                    </div>
                </div>

                <div class="item-actions">
                    <div class="qty-container">
                        <button type="button"
                                class="qty-btn"
                                onclick="changeQty({{ $item->id }}, -1)">
                            -
                        </button>
                        <span class="qty-display" id="qty-{{ $item->id }}">{{ $item->quantity }}</span>
                        <button type="button"
                                class="qty-btn"
                                onclick="changeQty({{ $item->id }}, 1)">
                            +
                        </button>
                    </div>

                    <input type="hidden"
                        name="quantity[{{ $item->id }}]"
                        id="input-{{ $item->id }}"
                        value="{{ $item->quantity }}"
                        data-price="{{ $item->price }}"
                        data-max="{{ $maxQty }}">

                    <button type="button"
                        class="remove-btn"
                        onclick="deleteItem({{ $item->id }})">
                        ✕
                    </button>
                </div>
            </div>
            @endforeach

            <button type="button" class="update-btn" onclick="submitUpdateCart()">Save</button> 
        </form>

        {{-- SEPARATE DELETE FORMS --}}
        @foreach($cartItems as $item)
        <form id="delete-form-{{ $item->id }}"
              action="{{ route('cart.destroy', $item->id) }}"
              method="POST"
              style="display:none;">
            @csrf
        </form>
        @endforeach
        @endif
    </div>


    <div class="cart-summary">
        <h3>Order Summary</h3>

        <div class="summary-row">
            <span>Subtotal</span>
            <span id="cart-subtotal">${{ number_format($subtotal,2) }}</span>
        </div>

        <div class="summary-row">
            <span>Shipping</span>
            <span id="Shipping">Free</span>
        </div>

        <div class="total-row">
            <span>Total</span>
            <span id="cart-total">${{ number_format($total,2) }}</span>
        </div>

        <form action="{{ route('orders.create') }}" method="GET">
            <button type="submit" class="checkout-btn">Checkout</button>
        </form>
    </div>

</div>
@endsection

@section('scripts')
<script>
function changeQty(id, delta) {
    let display = document.getElementById('qty-' + id);
    let input   = document.getElementById('input-' + id);

    let current = parseInt(display.textContent) || 1;
    let max     = parseInt(input.dataset.max) || Infinity;

    let val = current + delta;
    if (val < 1) val = 1;
    if (val > max) val = max;   // لا نتخطى المخزون

    display.textContent = val;
    input.value         = val;

    updateProductSubtotal(id);
    updateCartTotals();
}

function updateProductSubtotal(id) {
    let qty   = parseInt(document.getElementById('qty-' + id).textContent);
    let input = document.getElementById('input-' + id);
    let price = parseFloat(input.dataset.price);

    let subtotal = qty * price;

    let subtotalEl = document.getElementById('subtotal-' + id);
    subtotalEl.textContent = "$" + subtotal.toFixed(2);
    subtotalEl.dataset.subtotal = subtotal;
}

function updateCartTotals() {
    let subtotals = document.querySelectorAll('[id^="subtotal-"]');
    let cartSubtotal = 0;

    subtotals.forEach(el => {
        let text = el.textContent.replace("$", "").trim();
        cartSubtotal += parseFloat(text) || 0;
    });

    let total = cartSubtotal;
    document.getElementById('cart-subtotal').textContent = "$" + cartSubtotal.toFixed(2);
    document.getElementById('cart-total').textContent    = "$" + total.toFixed(2);
}

// SAVE CHANGES TO DATABASE
function submitUpdateCart() {
    document.getElementById('updateCartForm').submit();
}

// Submit delete form
function deleteItem(id) {
    document.getElementById('delete-form-' + id).submit();
}
</script>
@endsection

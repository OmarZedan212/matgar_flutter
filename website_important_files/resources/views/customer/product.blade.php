@extends('layouts.app')
@section('title', $product->name)

@section('style')
<style>
    :root {
        --primary-blue: #3b82f6;
        --secondary-text: #7d879c;
        --border-color: #e5e7eb;
    }

    /* Layout */
    .product-page-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .product-top-section {
        display: flex;
        gap: 50px;
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        border: 1px solid var(--border-color);
        margin-bottom: 50px;
    }

    .product-gallery { flex: 1; }
    .main-image-box {
        width: 100%;
        height: 400px;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
        padding: 20px;
    }
    .main-image-box img { max-width: 100%; max-height: 100%; object-fit: contain; }

    .product-details { flex: 1; }
    .breadcrumb-text { color: #999; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; margin-bottom: 10px; }
    .product-title { font-size: 2.2rem; font-weight: 800; color: #222; margin-bottom: 10px; line-height: 1.2; }
    .seller-tag { color: orange; font-size: 1rem; font-weight: 700; margin-bottom: 4px; }
    .price-wrap { display: flex; align-items: center; gap: 15px; margin-bottom: 25px; }
    .price-current { font-size: 2rem; font-weight: 700; color: var(--primary-blue); }
    .description { color: var(--secondary-text); line-height: 1.7; margin-bottom: 35px; border-top: 1px solid #f0f0f0; padding-top: 20px; }

    /* FORM STYLES */
    .add-to-cart-form {
        display: flex;
        gap: 15px;
        align-items: center;
    }

    .qty-selector {
        display: flex;
        align-items: center;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        height: 48px;
    }

    .qty-btn {
        background: none;
        border: none;
        width: 40px;
        height: 100%;
        font-size: 1.2rem;
        cursor: pointer;
        color: var(--secondary-text);
        transition: 0.2s;
    }
    .qty-btn:hover { background: #f0f0f0; color: var(--primary-blue); }

    .qty-input {
        width: 50px;
        border: none;
        text-align: center;
        font-weight: 700;
        font-size: 1.1rem;
        outline: none;
    }
    /* Hide number arrows */
    .qty-input::-webkit-inner-spin-button, .qty-input::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }

    .btn-submit-cart {
        background-color: var(--primary-blue);
        color: white;
        border: none;
        padding: 0 40px;
        height: 48px;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
        font-size: 1rem;
    }
    .btn-submit-cart:hover { background-color: #2563eb; }

    /* Success Message */
    .alert-success {
        padding: 15px;
        background-color: #d1fae5;
        color: #065f46;
        border-radius: 6px;
        margin-bottom: 20px;
        border: 1px solid #a7f3d0;
    }

    /* Related Products Grid (Simplified for length) */
    .related-title { font-size: 1.5rem; font-weight: 700; margin-bottom: 20px; }
    .products-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; }
    .card { border: 1px solid var(--border-color); border-radius: 10px; overflow: hidden; }
    .card-img { height: 180px; display: flex; align-items: center; justify-content: center; padding: 10px;}
    .card-img img { max-width: 100%; max-height: 100%; object-fit: contain; }
    .card-info { padding: 10px; }

    @media (max-width: 768px) { .product-top-section { flex-direction: column; } }
    /* Custom Quantity Stepper Style */
.qty-container {
    display: inline-flex;
    align-items: center;
    border: 1px solid #e5e7eb; /* Light gray border */
    border-radius: 6px;        /* Rounded corners */
    overflow: hidden;          /* Keeps buttons inside corners */
    background: #fff;
    height: 40px;
}

.qty-btn {
    background: none;
    border: none;
    width: 35px;
    height: 100%;
    font-size: 1.2rem;
    color: #333;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s;
}

.qty-btn:hover {
    background-color: #f3f4f6; /* Light gray hover */
}

.qty-input {
    width: 40px;
    border: none;
    text-align: center;
    font-weight: 600;
    font-size: 1rem;
    color: #111;
    outline: none;
    /* Remove arrows for chrome/safari */
    -moz-appearance: textfield;
}
.qty-input::-webkit-outer-spin-button,
.qty-input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
</style>
@endsection

@section('content')

@php
    $mainImg = $product->image_path ? asset('storage/' . $product->image_path) : asset('images/placeholder.png');
@endphp

<div class="product-page-container">

    {{-- LARAVEL SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="product-top-section">
        {{-- Left: Image --}}
        <div class="product-gallery">
            <div class="main-image-box">
                <img src="{{ $mainImg }}" alt="{{ $product->name }}">
            </div>
        </div>

        {{-- Right: Info --}}
        <div class="product-details">
            <div class="breadcrumb-text">Category / {{ $product->category->group->name }} / {{ $product->category->name }}</div>
            <h1 class="product-title">{{ $product->name }}</h1>
            <h1 class="seller-tag">Supplier: {{ $product->seller->shop_name }}</h1>

            <div class="price-wrap">
                <span class="price-current">${{ number_format($product->price, 2) }}</span>
            </div>

            <p style="color:#16a34a; font-weight:600; margin-bottom:10px;">
                In stock: {{ $product->qty }} item{{ $product->qty == 1 ? '' : 's' }}
            </p>

            <div class="description">
                {{ $product->description ?? 'Experience premium quality with this item.' }}
            </div>

                    {{-- FORM: Add To Cart --}}
        <form action="{{ route('cart.store') }}" method="POST" class="add-to-cart-form">
        @csrf
        <input type="hidden" name="id" value="{{ $product->id }}">
        <input type="hidden" name="price" value="{{ $product->price }}">
        <input type="hidden" name="name" value="{{ $product->name }}">
        <input type="hidden" name="image" value="{{ $product->image ?? '' }}">

        @php $inStock = $product->qty > 0; @endphp

        <div class="qty-container">
            <button type="button" class="qty-btn" onclick="modifyQty(this, -1)" {{ $inStock ? '' : 'disabled' }}>-</button>
            <input
                type="number"
                name="quantity"
                class="qty-input"
                value="{{ $inStock ? 1 : 0 }}"
                min="1"
                max="{{ $product->qty }}"
                data-max="{{ $product->qty }}"
                readonly
            >
            <button type="button" class="qty-btn" onclick="modifyQty(this, 1)" {{ $inStock ? '' : 'disabled' }}>+</button>
        </div>

        <button type="submit" class="btn-submit-cart" style="margin-left: 15px;"
                {{ $inStock ? '' : 'disabled' }}>
            {{ $inStock ? 'Add To Cart' : 'Out of Stock' }}
        </button>

    </form>

    <script>
        function modifyQty(btn, val) {
            const input = btn.parentElement.querySelector('.qty-input');
            let current = parseInt(input.value);
            const max = parseInt(input.getAttribute('data-max')) || 999999;

            let newVal = current + val;

            if (newVal < 1) newVal = 1;
            if (newVal > max) newVal = max;

            input.value = newVal;
        }
    </script>
        </div>
    </div>

    {{-- Related Products --}}
    <h3 class="related-title">Related Products</h3>
    <div class="products-grid">
        @forelse($products as $p)
            @php $pImg = $p->image_path ? asset('storage/' . $p->image_path) : asset('images/placeholder.png'); @endphp
            <div class="card">
                <div class="card-img">
                    <a href="{{ route('customer.product', $p->id) }}"><img src="{{ $pImg }}"></a>
                </div>
                <div class="card-info">
                    <a href="{{ route('customer.product', $p->id) }}" style="font-weight:600">{{ $p->name }}</a>
                </div>
            </div>
        @empty
            <p>No related products.</p>
        @endforelse
    </div>

</div>
@endsection

@section('script')
<script>
    // This script ONLY handles the visual number changing in the input.
    // The actual "Adding" is done by the PHP Form above.
    function updateQty(change) {
        const input = document.getElementById('qtyInput');
        let val = parseInt(input.value);
        val += change;
        if(val < 1) val = 1;
        input.value = val;
    }
</script>
@endsection

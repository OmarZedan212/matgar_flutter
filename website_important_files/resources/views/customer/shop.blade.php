@extends('layouts.app')
@section('title', __('Shop'))

@section('style')
<style>
    :root {
        --primary-blue: #3b82f6;
        --primary-hover: #2563eb;
        --secondary-text: #7d879c;
        --accent-color: #87ceeb;
        --border-color: #e5e7eb;
        --bg-color: #f8f9fa;
        --sidebar-width: 260px;
        --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    * { box-sizing: border-box; }

    body {
        font-family: var(--font-main);
        background-color: var(--bg-color);
        color: #333;
    }

    a { text-decoration: none; color: inherit; }
    ul { list-style: none; padding: 0; margin: 0; }

    /* --- LAYOUT FIX: Flex container only wraps Sidebar + Products --- */
    .main-container {
        display: flex;
        max-width: 1300px;
        margin: 20px auto;
        padding: 0 1.5rem;
        gap: 25px;
    }

    aside.sidebar {
        width: var(--sidebar-width);
        flex-shrink: 0;
        height: fit-content;
        background: white;
        padding: 20px;
        border-radius: 8px;
        border: 1px solid var(--border-color);
    }

    .filter-title { font-size: 1rem; font-weight: 700; margin-bottom: 0.8rem; color: #222; }

    details { margin-bottom: 8px; border-bottom: 1px solid #f9f9f9; }
    summary { list-style: none; cursor: pointer; font-weight: 600; font-size: 0.9rem; color: #555; display: flex; justify-content: space-between; align-items: center; padding: 8px 0; }
    summary::-webkit-details-marker { display: none; }
    details[open] summary i { transform: rotate(180deg); color: var(--primary-blue); }

    .checkbox-list { padding-left: 5px; padding-bottom: 8px; }
    .checkbox-label { display: flex; align-items: center; gap: 10px; margin-bottom: 0.5rem; cursor: pointer; color: var(--secondary-text); font-size: 0.85rem; }

    .products-area { flex-grow: 1; }
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 20px;
    }

    .card {
        background: white;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        overflow: hidden;
        position: relative;
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: var(--card-shadow);
        transform: translateY(-4px);
        border-color: transparent;
    }

    .badge-box {
        position: absolute;
        top: 10px;
        left: 10px;
        background: var(--accent-color);
        color: white;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 0.7rem;
        font-weight: 700;
        z-index: 2;
        text-transform: uppercase;
    }

    .card-img {
        height: 180px; 
        padding: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #fff;
        border-bottom: 1px solid #f3f3f3;
    }

    .card-img img { max-width: 100%; max-height: 100%; object-fit: contain; transition: transform 0.3s; }
    .card:hover .card-img img { transform: scale(1.05); }

    .card-info { padding: 12px; }
    .category-tag { color: #999; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; margin-bottom: 4px; }
    .seller-tag { color: orange; font-size: 0.7rem; font-weight: 700; margin-bottom: 4px; }

    .product-name { font-size: 0.9rem; font-weight: 600; margin: 0 0 8px; color: #333; line-height: 1.3; overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 2; }
    .price-wrap { display: flex; gap: 8px; align-items: center; margin-top: 5px; }
    .new-price { color: var(--primary-blue); font-weight: 700; font-size: 1rem; }
    .old-price { text-decoration: line-through; color: var(--secondary-text); font-size: 0.8rem; }
    
    .price-slider {
        width: 100%;
        accent-color: #3b82f6; 
        margin-bottom: 10px;
        cursor: pointer;
    }

    .rating-radio input[type="radio"] {
        accent-color: #3b82f6; 
        margin-right:5px;
    }

    .btn-filter {
        background-color: #3b82f6;
        color:white;
        border:none;
        padding:8px 15px;
        border-radius:5px;
        cursor:pointer;
        font-weight:600;
        transition:0.3s;
        width: 100%;
    }

    .btn-filter:hover {
        background-color:#2563eb;
    }
    input#priceInput {
        border-radius: 20px;
        border-color: #d7d7d769;
    }
</style>
@endsection

@section('content')

{{-- MAIN CONTAINER STARTS --}}
<div class="main-container">

    {{-- SIDEBAR --}}
    <aside class="sidebar">
        <form method="GET" action="{{ route('shop.index') }}">
            
            {{-- 1. CATEGORIES FILTER --}}
            <div class="filter-group">
                <h3 class="filter-title">Categories</h3>
                @foreach($category_groups as $group)
                    <details {{ $loop->first ? 'open' : '' }}>
                        <summary>{{ $group->name}} <i class="fa-solid fa-chevron-down"></i></summary>
                        <div class="checkbox-list">
                            @foreach($group->categories as $cat)
                                <label class="checkbox-label">
                                    <input type="checkbox" name="category[]" value="{{ $cat->id }}" class="category-checkbox" 
                                    {{ in_array($cat->id, (array) request('category')) ? 'checked' : '' }}>
                                    {{ ucwords(str_replace(['_', '-'], ' ', $cat->name)) }}
                                </label>
                            @endforeach
                        </div>
                    </details>
                @endforeach
            </div>

            {{-- 2. MAX PRICE FILTER (Synced) --}}
            <div class="filter-group mt-4">
                <h3 class="filter-title">Max Price</h3>
                
                <input 
                    type="range" 
                    id="priceRange" 
                    min="0" 
                    max="10000" 
                    step="50" 
                    value="{{ request('max_price', 20000) }}" 
                    class="price-slider mb-2"
                >

                <div class="d-flex align-items-center" style="gap: 5px;">
                    <span style="font-size: 0.9rem; color: #000000;">$</span>
                    <input 
                        type="number" 
                        name="max_price" 
                        id="priceInput" 
                        min="0" 
                        max="20000" 
                        value="{{ request('max_price', 20000) }}" 
                        class="form-control"
                        style="padding: 5px; width: 100px;"
                    >
                </div>
            </div>

            {{-- 3. RATINGS FILTER --}}
            <!--<div class="filter-group mt-4 mb-3">
                <h3 class="filter-title">Ratings</h3>
                @for($i=5;$i>=1;$i--)
                    <label class="rating-radio">
                        <input type="radio" name="rating" value="{{ $i }}" {{ request('rating',0)==$i?'checked':'' }}>
                        @for($j=0;$j<$i;$j++)
                            <i class="fa-solid fa-star" style="color:#ffc107;"></i>
                        @endfor
                        & Up
                    </label><br>
                @endfor
                <label class="rating-radio">
                    <input type="radio" name="rating" value="0" {{ request('rating',0)==0?'checked':'' }}> All Ratings
                </label>
            </div>-->
            <br>
            <button type="submit" class="btn-filter">Apply Filters</button>
        </form>
    </aside>

    {{-- PRODUCTS AREA --}}
    <main class="products-area">
        <div class="products-grid">
            @forelse($products as $p)
                @php
                    // Logic for Discount Badge
                    $discountPercent = $p->old_price > $p->price ? round((($p->old_price - $p->price)/$p->old_price)*100) : null;
                    
                    // Logic for Image Path
                    $imgSrc = $p->image_path ? asset('storage/' . $p->image_path) : ''; 
                @endphp

                <div class="card">
                    @if($discountPercent)
                        <span class="badge-box" style="background:#d23f57">-{{ $discountPercent }}%</span>
                    @elseif($p->badge)
                        <span class="badge-box">{{ $p->badge }}</span>
                    @endif
                    
                    {{-- 1. LINKED IMAGE --}}
                    <div class="card-img">
                        <a href="{{ route('customer.product', $p->id) }}" style="display:block; width:100%; height:100%;">
                            <img src="{{ $imgSrc }}" alt="{{ $p->name }}">
                        </a>
                    </div>

                    <div class="card-info">
                        <div class="category-tag">{{optional($p->category->group)->name}}/{{ optional($p->category)->name }}</div>
                        
                        {{-- 2. LINKED TITLE --}}
                        <h4 class="product-name">
                            <a href="{{ route('customer.product', $p->id) }}" style="color: inherit;">
                                {{ $p->name }}
                            </a>
                        </h4>
                        <div class="seller-tag">Supplier: {{ $p->seller->shop_name }}</div>
                        <!--<div class="rating-stars" style="color:#ffc107; font-size:0.8rem; margin-bottom:5px;">
                            @for($i=0; $i < ($p->rating ?? 4); $i++)
                                <i class="fa-solid fa-star"></i>
                            @endfor
                            @for($i=($p->rating ?? 4); $i<5; $i++)
                                <i class="fa-regular fa-star"></i>
                            @endfor
                        </div>-->

                        <div class="price-wrap">
                            <span class="new-price">${{ number_format($p->price, 2) }}</span>
                            <!--<span class="old-price">${{ number_format($p->old_price, 2) }}</span>-->
                        </div>
                    </div>
                </div>
            @empty
                <p style="text-align:center; margin-top:20px; color:#777; grid-column: 1/-1;">
                    No products found matching your filters.
                </p>
            @endforelse
        </div>
    </main>

</div> 
        {{-- 
        IMPORTANT: This </div> above closes the .main-container.
        Do NOT put the Footer inside this div. 
        --}}

<script>
    // Sync logic for Price Slider
    const priceRange = document.getElementById('priceRange');
    const priceInput = document.getElementById('priceInput');

    if(priceRange && priceInput){
        priceRange.addEventListener('input', function() {
            priceInput.value = this.value;
        });

        priceInput.addEventListener('input', function() {
            priceRange.value = this.value;
        });
    }
</script>

@endsection
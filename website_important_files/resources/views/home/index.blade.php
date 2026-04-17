@extends('layouts.app')

@section('title', __('messages.home'))
@section('style')
<style>

    /* =========================================
    1. GLOBAL VARIABLES & RESET
    ========================================= */
    :root {
    --primary-blue: #3b82f6;
    --primary-hover: #2563eb;
    --secondary-text: #7d879c;
    --accent-color: #87ceeb; /* Light Blue Badge */
    --hot-color: #d23f57;    /* Red for Hot Offers */
    --success-color: #10b981;
    --border-color: #e5e7eb;
    --bg-color: #f8f9fa;
    --sidebar-width: 260px;
    --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    * {
    box-sizing: border-box;
    }

    body {
    font-family: 'Poppins', 'Segoe UI', Tahoma, sans-serif;
    background-color: var(--bg-color);
    margin: 0;
    padding: 0;
    color: #333;
    }

    a {
    text-decoration: none;
    color: inherit;
    transition: 0.2s;
    }

    ul {
    list-style: none;
    padding: 0;
    margin: 0;
    }

    /* Container Utility */
    .main-container {
    max-width: 1300px;
    margin: 0 auto;
    padding: 0 1.5rem;
    }
    /* Active State (Blue Highlight) */
    .active-nav-item {
        color: var(--primary-blue) !important;
        font-weight: 700;
    }
    /* =========================================
    3. FLASH SALE SECTION (Home)
    ========================================= */
    .flash-sale-section {
        background: linear-gradient(to right, #fff0f0, #fff);
        padding: 30px 0;
        margin: 30px 0;
        border-top: 1px solid #ffe5e5;
        border-bottom: 1px solid #ffe5e5;
    }

    .flash-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .flash-title h2 { margin: 0; font-size: 1.6rem; color: var(--hot-color); }
    .text-warning { color: #ffc107; }

    /* Timer */
    .countdown-timer { display: flex; gap: 8px; }
    .time-box {
        background: #333; color: #fff;
        padding: 6px 10px; border-radius: 6px;
        display: flex; flex-direction: column; align-items: center;
        min-width: 55px;
    }
    .time-box span { font-weight: 700; font-size: 1.1rem; line-height: 1; }
    .time-box small { font-size: 0.6rem; text-transform: uppercase; opacity: 0.8; }

    /* Horizontal Scroll */
    .scrolling-wrapper {
        display: flex;
        gap: 15px;
        overflow-x: auto;
        padding-bottom: 10px;
        scroll-behavior: smooth;
        scrollbar-width: none;
    }
    .scrolling-wrapper::-webkit-scrollbar { display: none; }
    .scrolling-wrapper .card {
        min-width: 190px;
        max-width: 190px;
        flex-shrink: 0;
    }

    /* =========================================
    4. SHOP PAGE & SIDEBAR
    ========================================= */
    .shop-layout {
        display: flex;
        gap: 30px;
        margin-top: 30px;
    }

    aside.sidebar {
    width: var(--sidebar-width);
    flex-shrink: 0;
    background: white;
    padding: 20px;
    border-radius: 8px;
    border: 1px solid var(--border-color);
    height: fit-content;
    }

    /* Sidebar Accordion */
    details { margin-bottom: 8px; border-bottom: 1px solid #f9f9f9; }
    summary {
        cursor: pointer; font-weight: 600; font-size: 0.9rem; color: #555;
        display: flex; justify-content: space-between; padding: 8px 0;
    }
    summary::-webkit-details-marker { display: none; }
    details[open] summary i { transform: rotate(180deg); color: var(--primary-blue); }

    .checkbox-label {
    display: flex; align-items: center; gap: 10px; margin-bottom: 0.5rem;
    cursor: pointer; color: var(--secondary-text); font-size: 0.85rem;
    }
    .checkbox-label input { accent-color: var(--primary-blue); transform: scale(1.1); }
    .checkbox-label:hover { color: var(--primary-blue); }

    /* =========================================
    5. PRODUCT GRID & CARDS
    ========================================= */
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
    }

    /* Badges */
    .badge-box {
    position: absolute; top: 10px; left: 10px;
    background: var(--accent-color); color: white;
    padding: 3px 8px; border-radius: 4px;
    font-size: 0.7rem; font-weight: 700; z-index: 2;
    text-transform: uppercase;
    }

    /* Wishlist Button */
    .wishlist-btn {
    position: absolute; top: 10px; right: 10px;
    background: rgba(255, 255, 255, 0.9);
    width: 30px; height: 30px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; z-index: 2; color: #888;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .wishlist-btn:hover { background: #ff4757; color: white; }

    /* Product Image */
    .card-img {
    height: 180px;
    padding: 1rem;
    display: flex; align-items: center; justify-content: center;
    border-bottom: 1px solid #f3f3f3;
    }
    .card-img img {
    max-width: 100%; max-height: 100%; object-fit: contain;
    transition: transform 0.3s;
    }
    .card:hover .card-img img { transform: scale(1.05); }

    /* Product Info */
    .card-info { padding: 12px; }
    .category-tag { font-size: 0.7rem; font-weight: 700; color: #999; text-transform: uppercase; }
    .product-name {
    font-size: 0.9rem; font-weight: 600; margin: 5px 0;
    color: #333; height: 36px; overflow: hidden;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
    }
    .price-wrap { display: flex; gap: 8px; align-items: center; margin-top: 6px; }
    .new-price { color: var(--primary-blue); font-weight: 700; font-size: 1rem; }
    .old-price { text-decoration: line-through; color: var(--secondary-text); font-size: 0.8rem; }

    /* =========================================
    6. CART PAGE STYLES
    ========================================= */
    .cart-container {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 30px;
        align-items: start;
    }
    .cart-item {
        display: flex; gap: 15px; padding: 15px;
        border: 1px solid var(--border-color); border-radius: 8px;
        margin-bottom: 15px; background: white; align-items: center;
    }
    .item-img { width: 80px; height: 80px; flex-shrink: 0; }
    .item-img img { width: 100%; height: 100%; object-fit: contain; }
    .item-details { flex-grow: 1; }
    .qty-control { display: flex; align-items: center; border: 1px solid #ddd; border-radius: 4px; }
    .qty-btn { background: #f1f1f1; border: none; padding: 5px 10px; cursor: pointer; }

    /* Cart Summary */
    .cart-summary {
        background: white; padding: 20px;
        border: 1px solid var(--border-color); border-radius: 8px;
        position: sticky; top: 80px;
    }
    .checkout-btn {
        width: 100%; padding: 12px;
        background-color: var(--primary-blue); color: white;
        border: none; border-radius: 6px; font-weight: 600; cursor: pointer;
        margin-top: 15px;
    }

    /* =========================================
    7. CHECKOUT MODAL (Overlay & Box)
    ========================================= */
    .modal-overlay {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: none; justify-content: center; align-items: center;
        z-index: 2000; backdrop-filter: blur(4px);
    }
    .modal-overlay.active { display: flex; animation: fadeIn 0.3s ease; }

    .modal-box {
        background: white; width: 400px; max-width: 90%;
        border-radius: 12px; padding: 25px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        transform: translateY(20px); animation: slideUp 0.3s ease forwards;
    }
    .modal-header { display: flex; justify-content: space-between; margin-bottom: 20px; }
    .close-modal-btn { background: none; border: none; font-size: 2rem; cursor: pointer; color: #777; }

    /* Form Elements */
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 5px; }
    .form-group input, .form-group select {
        width: 100%; padding: 10px; border: 1px solid #ddd;
        border-radius: 6px; font-size: 0.95rem;
    }
    .checkout-total { text-align: right; font-weight: 700; margin: 20px 0; color: var(--primary-blue); }
    .pay-now-btn {
        width: 100%; padding: 12px; background: var(--success-color);
        color: white; border: none; border-radius: 6px;
        font-size: 1rem; font-weight: 600; cursor: pointer;
    }

    @keyframes slideUp { to { transform: translateY(0); } }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

    /* =========================================
    8. TOAST NOTIFICATION
    ========================================= */
    .toast-notification {
        position: fixed; bottom: -100px; left: 50%; transform: translateX(-50%);
        background-color: #333; color: #fff; padding: 14px 30px;
        border-radius: 50px; font-size: 14px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2); z-index: 9999;
        transition: bottom 0.5s cubic-bezier(0.68, -0.55, 0.27, 1.55);
        display: flex; align-items: center; gap: 10px; opacity: 0;
    }
    .toast-notification.show { bottom: 30px; opacity: 1; }
    .toast-notification.success { background-color: var(--success-color); }

    /* =========================================
    9. RESPONSIVE
    ========================================= */
    @media (max-width: 992px) {
    .shop-layout, .cart-container { flex-direction: column; }
    aside.sidebar { width: 100%; }
    .products-grid { grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); }
    
    .dropdown-parent:hover > .dropdown-menu,
    .dropdown-submenu:hover > .submenu {
        position: static; box-shadow: none; border: none; padding-left: 20px; width: 100%;
    }
}

</style>
@endsection
@section('content')
<section class="hero" style="background:#f4f9fc; padding: 40px 0;">
        <div class="main-container hero-content" style="display:flex; align-items:center; justify-content:space-between;">
            <div class="hero-text">
                <h1 style="font-size:3rem; line-height:1.2; margin-bottom:20px;">Starting at <strong style="color:var(--primary-blue);">$20.00</strong></h1>
                <p style="margin-bottom:20px; color:#666;">Get the best deals on the latest fashion and electronics.</p>
                <a href="http://127.0.0.1:8000/shop" style="background:var(--primary-blue); color:white; padding:10px 25px; border-radius:5px; font-weight:600;">SHOP NOW</a>
            </div>
            <div class="hero-img">
                <img src="https://img.freepik.com/free-photo/handsome-young-man-with-shopping-bags_23-2148424268.jpg?w=740" alt="Shopping" style="max-height:400px; border-radius:10px;">
            </div>
        </div>
    </section>

    <section class="flash-sale-section">
        <div class="main-container">
            <div class="flash-header">
                <div class="flash-title">
                    <h2><i class="fa-solid fa-bolt text-warning"></i> Flash Deals</h2>
                    <p>Limited time offers with huge discounts</p>
                </div>
                <div class="countdown-timer">
                    <div class="time-box"><span id="hours">10</span><small>Hours</small></div>
                    <div class="time-box"><span id="minutes">45</span><small>Mins</small></div>
                    <div class="time-box"><span id="seconds">30</span><small>Secs</small></div>
                </div>
            </div>

            <div class="scrolling-wrapper" id="hotOffersGrid">
                </div>
        </div>
    </section>

<section class="section-container main-container" style="margin-top: 40px;">
    <h2 class="section-title" style="margin-bottom:20px; font-size:1.5rem;">For You</h2>

    <div class="products-grid">

        <div class="card">
            <div class="badge-box" style="background:#d23f57">15%</div>
            <div class="wishlist-btn" onclick="toggleWishlist(1, this)">
                <i class="fa-regular fa-heart"></i>
            </div>
            <a href="product.html?id=1">
                <div class="card-img">
                    <img src="https://img.freepik.com/free-photo/leather-jacket-men-fashion-shoot_53876-102574.jpg?w=740" alt="Jacket">
                </div>
                <div class="card-info">
                    <div class="category-tag">JACKET</div>
                    <h3 class="product-title">Mens Winter Leather Jacket</h3>
                    <div class="rating-stars">
                        <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i>
                    </div>
                    <div class="price-wrap">
                        <span class="new-price">$48.00</span>
                        <span class="old-price">$75.00</span>
                    </div>
                </div>
            </a>
        </div>

        <div class="card">
            <div class="badge-box" style="background:green">NEW</div>
            <div class="wishlist-btn" onclick="toggleWishlist(2, this)">
                <i class="fa-regular fa-heart"></i>
            </div>
            <a href="product.html?id=2">
                <div class="card-img">
                    <img src="https://img.freepik.com/free-photo/classic-men-casual-outfit-with-blue-shirt-trousers_169016-4747.jpg?w=740" alt="Shirt">
                </div>
                <div class="card-info">
                    <div class="category-tag">SHIRT</div>
                    <h3 class="product-title">Pure Garment Dyed Shirt</h3>
                    <div class="rating-stars">
                        <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i>
                    </div>
                    <div class="price-wrap">
                        <span class="new-price">$45.00</span>
                        <span class="old-price">$56.00</span>
                    </div>
                </div>
            </a>
        </div>

        <div class="card">
            <div class="wishlist-btn" onclick="toggleWishlist(5, this)">
                <i class="fa-regular fa-heart"></i>
            </div>
            <a href="product.html?id=5">
                <div class="card-img">
                    <img src="https://img.freepik.com/free-photo/woman-black-skirt-outfit-details_53876-102554.jpg?w=740" alt="Skirt">
                </div>
                <div class="card-info">
                    <div class="category-tag">SKIRT</div>
                    <h3 class="product-title">Black Floral Wrap Skirt</h3>
                    <div class="rating-stars">
                         <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i>
                    </div>
                    <div class="price-wrap">
                        <span class="new-price">$25.00</span>
                        <span class="old-price">$35.00</span>
                    </div>
                </div>
            </a>
        </div>

        <div class="card">
            <div class="badge-box" style="background:#87ceeb">HOT</div>
            <div class="wishlist-btn" onclick="toggleWishlist(4, this)">
                <i class="fa-regular fa-heart"></i>
            </div>
            <a href="product.html?id=4">
                <div class="card-img">
                    <img src="https://img.freepik.com/free-photo/handsome-man-brown-jacket_144627-46383.jpg?w=740" alt="Jacket">
                </div>
                <div class="card-info">
                    <div class="category-tag">JACKET</div>
                    <h3 class="product-title">Yarn Fleece Full-Zip Jacket</h3>
                    <div class="rating-stars">
                        <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i>
                    </div>
                    <div class="price-wrap">
                        <span class="new-price">$58.00</span>
                        <span class="old-price">$65.00</span>
                    </div>
                </div>
            </a>
        </div>

        <div class="card">
            <div class="badge-box" style="background:#FFA500">SALE</div>
            <div class="wishlist-btn" onclick="toggleWishlist(9, this)">
                <i class="fa-regular fa-heart"></i>
            </div>
            <a href="product.html?id=9">
                <div class="card-img">
                    <img src="https://images.unsplash.com/photo-1620916566398-39f1143ab7be?w=500&q=80" alt="Serum">
                </div>
                <div class="card-info">
                    <div class="category-tag">BEAUTY</div>
                    <h3 class="product-title">Organic Aloe Vera Serum</h3>
                    <div class="rating-stars">
                        <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i>
                    </div>
                    <div class="price-wrap">
                        <span class="new-price">$30.00</span>
                        <span class="old-price">$45.00</span>
                    </div>
                </div>
            </a>
        </div>

        <div class="card">
            <div class="wishlist-btn" onclick="toggleWishlist(6, this)">
                <i class="fa-regular fa-heart"></i>
            </div>
            <a href="product.html?id=6">
                <div class="card-img">
                    <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500&q=80" alt="Shoes">
                </div>
                <div class="card-info">
                    <div class="category-tag">SHOES</div>
                    <h3 class="product-title">Running Sneakers Air</h3>
                    <div class="rating-stars">
                        <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i>
                    </div>
                    <div class="price-wrap">
                        <span class="new-price">$85.00</span>
                        <span class="old-price">$110.00</span>
                    </div>
                </div>
            </a>
        </div>

    </div>
</section>

    <section class="section-container main-container" style="margin-top:40px;">
        <h2 class="section-title">Deal Of The Day</h2>
        <div class="deal-section" style="display:flex; gap:30px; background:white; padding:20px; border:1px solid #eee; border-radius:8px; align-items:center; flex-wrap:wrap;">
            <div class="deal-img" style="flex:1;">
                <img src="https://via.placeholder.com/400x300?text=Beauty+Bundle" alt="Deal" style="width:100%; border-radius:8px;">
            </div>
            <div class="deal-info" style="flex:1;">
                <h3>SHAMPOO, CONDITIONER & FACEWASH</h3>
                <p style="margin: 1rem 0; color: #666;">Get the ultimate beauty pack for a fraction of the price. Limited stock available.</p>
                <div class="price" style="font-size: 1.5rem; margin: 1rem 0; color:var(--primary-blue); font-weight:bold;">$150.00 <span class="old-price" style="color:#999; text-decoration:line-through; font-size:1rem;">$200.00</span></div>
                <div class="progress-bar" style="width:100%; background:#eee; height:10px; border-radius:5px; overflow:hidden; margin-bottom:10px;">
                    <div class="progress-fill" style="width:60%; background:var(--primary-blue); height:100%;"></div>
                </div>
                <p style="font-size: 0.8rem; margin-bottom: 20px;">Available: 40 / Sold: 20</p>
                <button 
                        style="background:var(--primary-blue); color:white; padding:12px 30px; border:none; border-radius:5px; cursor:pointer; font-weight:600;">ADD TO CART</button>
            </div>
        </div>
    </section>

    <div class="services" style="background:white; padding:40px 0; margin-top:40px; border-top:1px solid #eee;">
        <div class="main-container">
            <div class="services-grid" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:20px; text-align:center;">
                <div class="service-item">
                    <i class="fas fa-globe-americas" style="font-size:2rem; color:var(--primary-blue); margin-bottom:10px;"></i>
                    <h4>Worldwide Delivery</h4>
                    <p style="color:#777; font-size:0.9rem;">For Order Over $100</p>
                </div>
                <div class="service-item">
                    <i class="fas fa-truck" style="font-size:2rem; color:var(--primary-blue); margin-bottom:10px;"></i>
                    <h4>Next Day Delivery</h4>
                    <p style="color:#777; font-size:0.9rem;">EGY Orders Only</p>
                </div>
                <div class="service-item">
                    <i class="fas fa-headset" style="font-size:2rem; color:var(--primary-blue); margin-bottom:10px;"></i>
                    <h4>Best Online Support</h4>
                    <p style="color:#777; font-size:0.9rem;">Hours: 8AM-11PM</p>
                </div>
                <div class="service-item">
                    <i class="fas fa-undo" style="font-size:2rem; color:var(--primary-blue); margin-bottom:10px;"></i>
                    <h4>Return Policy</h4>
                    <p style="color:#777; font-size:0.9rem;">Easy & Free Return</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="asset('js/shop.js')"></script>
<script>
  document.addEventListener("DOMContentLoaded", () => {
    
    /* --- 1. POPULATE FLASH SALE SECTION --- */
    const hotGrid = document.getElementById('hotOffersGrid');
    
    // Check if we have product data from shop.js
    // Note: shop.js must be loaded BEFORE home.js in your HTML
    if (hotGrid && typeof products !== 'undefined') {
        // Find discounted products (Old Price > Current Price)
        const discountedProducts = products.filter(p => p.oldPrice > p.price);
        
        hotGrid.innerHTML = ""; // Clear existing

        discountedProducts.forEach(p => {
            const percent = Math.round(((p.oldPrice - p.price) / p.oldPrice) * 100);
            
            const cardHTML = `
                <div class="card">
                    <span class="badge-box" style="background:#d23f57;">-${percent}%</span>
                    <a href="product.html?id=${p.id}">
                        <div class="card-img">
                            <img src="${p.img}" alt="${p.name}">
                        </div>
                        <div class="card-info">
                            <div class="category-tag">${p.category}</div>
                            <h4 class="product-name">${p.name}</h4>
                            <div class="price-wrap">
                                <span class="new-price" style="color:#d23f57;">$${p.price.toFixed(2)}</span>
                                <span class="old-price">$${p.oldPrice.toFixed(2)}</span>
                            </div>
                        </div>
                    </a>
                </div>
            `;
            hotGrid.innerHTML += cardHTML;
        });
    }

    /* --- 2. TIMER LOGIC --- */
    function startTimer(duration, displayHours, displayMins, displaySecs) {
        let timer = duration, hours, minutes, seconds;
        setInterval(function () {
            hours = parseInt(timer / 3600, 10);
            minutes = parseInt((timer % 3600) / 60, 10);
            seconds = parseInt(timer % 60, 10);

            displayHours.textContent = hours < 10 ? "0" + hours : hours;
            displayMins.textContent = minutes < 10 ? "0" + minutes : minutes;
            displaySecs.textContent = seconds < 10 ? "0" + seconds : seconds;

            if (--timer < 0) timer = duration; 
        }, 1000);
    }

    const h = document.getElementById('hours');
    const m = document.getElementById('minutes');
    const s = document.getElementById('seconds');
    if(h && m && s) startTimer(18000, h, m, s); 
});

/* --- 3. ADD TO CART FUNCTION (Updated to use Pop-up) --- */
function addToCart(id, name, price, img) {
    let cart = JSON.parse(localStorage.getItem("myCart")) || [];
    
    // Check if item exists
    const existingItem = cart.find(item => item.id === id);
    if (existingItem) {
        existingItem.qty += 1;
    } else {
        cart.push({ id, name, price, img, qty: 1 });
    }
    
    localStorage.setItem("myCart", JSON.stringify(cart));
    
    // Update Header Badge immediately
    if(typeof updateHeaderCounts === 'function') updateHeaderCounts();
    
    // VISUAL: Show the "Pop-up" instead of alert
    if(typeof showToast === 'function') {
        showToast("Added to Cart successfully!");
    } else {
        // Fallback if head.js didn't load
        alert("Added to Cart successfully!");
    }
}

/* --- 4. WISHLIST TOGGLE --- */
function toggleWishlist(id, btnElement) {
    let wishlist = JSON.parse(localStorage.getItem('myWishlist')) || [];
    
    // Check if item is already in list
    const index = wishlist.findIndex(item => item.id === id);
    
    // Find Product Data (Safe check)
    const productData = (typeof products !== 'undefined') 
                        ? products.find(p => p.id === id) 
                        : { id: id, name: 'Product ' + id, price: 0, img: '' };

    if (index > -1) {
        // REMOVE
        wishlist.splice(index, 1);
        
        // Turn Heart Empty
        if(btnElement) {
            const icon = btnElement.querySelector('i');
            if(icon) {
                icon.className = "fa-regular fa-heart"; 
                icon.style.color = ""; 
            }
        }
        // Optional: Show Red Toast for removal
        if(typeof showToast === 'function') showToast("Removed from Wishlist", false);

    } else {
        // ADD
        if(productData) wishlist.push(productData);
        
        // Turn Heart Red
        if(btnElement) {
            const icon = btnElement.querySelector('i');
            if(icon) {
                icon.className = "fa-solid fa-heart"; 
                icon.style.color = "#ef4444"; 
            }
        }
        
        // Show Green Toast
        if(typeof showToast === 'function') showToast("Added to Wishlist!");
    }
    
    localStorage.setItem('myWishlist', JSON.stringify(wishlist));
    if(typeof updateHeaderCounts === 'function') updateHeaderCounts();
}
</script>
@endsection
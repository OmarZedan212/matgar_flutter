@extends('layouts.app')
@section('title', __('Wish List'))

@section('style')
<style>   
    
        /* REUSE GLOBAL STYLES */
        :root { --primary-text: #2b3445; --accent-color: #d23f57; --border-color: #f3f5f9; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { color: var(--primary-text); }
        a { text-decoration: none; color: inherit; }

        /* WISHLIST CONTAINER */
        .container { max-width: 1000px; margin: 3rem auto; padding: 0 1rem; }
        h2 { margin-bottom: 2rem; }

        /* LIST STYLE */
        .wishlist-item {
            display: flex; align-items: center; border: 1px solid var(--border-color);
            padding: 1.5rem; margin-bottom: 1rem; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.03);
            flex-wrap: wrap; gap: 20px;
        }

        .item-img { width: 80px; height: 80px; object-fit: contain; }
        
        .item-info { flex: 1; min-width: 200px; }
        .item-name { font-weight: 600; margin-bottom: 5px; font-size: 1.1rem; }
        .item-price { color: var(--accent-color); font-weight: 600; }
        
        .item-actions { display: flex; gap: 15px; align-items: center; }

        /* BUTTONS */
        .btn-cart {
            padding: 10px 20px; background: var(--primary-text); color: white; border: none;
            border-radius: 4px; cursor: pointer; transition: 0.3s;
        }
        .btn-cart:hover { background: var(--accent-color); }

        .btn-remove {
            width: 40px; height: 40px; border: 1px solid #ddd; border-radius: 50%;
            display: flex; align-items: center; justify-content: center; cursor: pointer;
            color: #888; transition: 0.3s;
        }
        .btn-remove:hover { color: var(--accent-color); border-color: var(--accent-color); }
        p{ margin-bottom: 20px; }

        @media(max-width: 600px) {
            .wishlist-item { flex-direction: column; text-align: center; }
            .item-actions { width: 100%; justify-content: center; }
        }
</style>
@endsection

@section('content')
    <div class="container">
        <h2>My Wishlist</h2>
        <div id="wishlistGrid">
            </div>
    </div>
@endsection

@section('script')
<script>
        document.addEventListener('DOMContentLoaded', () => {
        
        // =========================================
        // 1. INTERNAL HELPER: TOAST
        // =========================================
        function showWishlistToast(message, isSuccess = true) {
            let toast = document.getElementById('toast-notification');
            if (!toast) {
                toast = document.createElement('div');
                toast.id = 'toast-notification';
                toast.className = 'toast-notification';
                document.body.appendChild(toast);
            }

            toast.innerHTML = isSuccess 
                ? `<i class="fa-solid fa-check-circle"></i> ${message}`
                : `<i class="fa-solid fa-circle-exclamation"></i> ${message}`;
            
            if (isSuccess) {
                toast.classList.add('success');
                toast.style.backgroundColor = "#10b981"; 
            } else {
                toast.classList.remove('success');
                toast.style.backgroundColor = "#ef4444"; 
            }

            toast.classList.add('show');
            setTimeout(() => { toast.classList.remove('show'); }, 3000);
        }

        const grid = document.getElementById('wishlistGrid');

        // =========================================
        // 2. RENDER WISHLIST
        // =========================================
        function renderWishlist() {
            const wishlist = JSON.parse(localStorage.getItem('myWishlist')) || [];
            
            grid.innerHTML = "";
            
            if (wishlist.length === 0) {
                grid.innerHTML = `
                    <div style="grid-column: 1/-1; text-align:center; padding:50px;">
                        <i class="fa-regular fa-heart" style="font-size:3rem; color:#eee; margin-bottom:15px;"></i>
                        <p>Your wishlist is empty.</p> 
                        <a href='shop.html' style='color:var(--primary-blue); font-weight:600;'>Go Shop</a>
                    </div>`;
                return;
            }

            wishlist.forEach(item => {
                const div = document.createElement('div');
                div.className = 'wishlist-item';
                div.innerHTML = `
                    <a href="product.html?id=${item.id}">
                        <img src="${item.img}" onerror="this.src='https://via.placeholder.com/150'" alt="${item.name}" class="item-img">
                    </a>
                    <div class="item-info">
                        <div class="item-name">${item.name}</div>
                        <div class="item-price">$${parseFloat(item.price).toFixed(2)}</div>
                        <div style="font-size:0.8rem; color:#10b981; margin-top:5px; font-weight:500;">
                            <i class="fa-solid fa-check"></i> In Stock
                        </div>
                    </div>
                    <div class="item-actions">
                        <button class="btn-cart" onclick="moveToCart(${item.id})">
                            <i class="fa-solid fa-cart-plus"></i> Add to Cart
                        </button>
                        <button class="btn-remove" onclick="removeFromWishlist(${item.id})">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                `;
                grid.appendChild(div);
            });
        }

        // =========================================
        // 3. ACTIONS (Global Scope)
        // =========================================

        // REMOVE ITEM
        window.removeFromWishlist = function(id) {
            let list = JSON.parse(localStorage.getItem('myWishlist')) || [];
            list = list.filter(p => p.id !== id);
            
            localStorage.setItem('myWishlist', JSON.stringify(list));
            
            renderWishlist();
            
            // Update Header
            if(typeof updateHeaderCounts === 'function') updateHeaderCounts();
            
            // Show Local Toast
            showWishlistToast("Removed from Wishlist", false); 
        };

        // MOVE TO CART
        window.moveToCart = function(id) {
            let wishlist = JSON.parse(localStorage.getItem('myWishlist')) || [];
            let cart = JSON.parse(localStorage.getItem('myCart')) || [];
            
            // Find product
            const product = wishlist.find(p => p.id === id);
            
            if (product) {
                // Check cart duplicate
                let existing = cart.find(p => p.id === id);
                if(existing) {
                    existing.qty++;
                } else {
                    cart.push({ ...product, qty: 1 });
                }
                
                localStorage.setItem('myCart', JSON.stringify(cart));
                
                // Remove from Wishlist
                window.removeFromWishlist(id); 

                // Update Header
                if(typeof updateHeaderCounts === 'function') updateHeaderCounts();
                
                // Show Local Toast (Override the removal toast)
                setTimeout(() => showWishlistToast("Moved to Cart Successfully!"), 100);
            }
        };

        // Init
        renderWishlist();
    });
</script>
@endsection
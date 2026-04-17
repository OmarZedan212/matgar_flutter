<header>
        <div class="top-bar">
            <div class="container">
                <div class="top-left">
                    <span><i class="fa-solid fa-phone"></i> +20 123 456 789</span>
                    <span><i class="fa-regular fa-envelope"></i> support@matgar.com</span>
                    
                    @auth
                        <span class="top-link">Hi, {{ auth()->user()->name }}</span>
                    @endauth
                    <a href="track.html">Track Order</a>
                    @if (!request()->routeIs('seller.*'))
                    <a href="{{route('seller.dashboard')}}">Sell Now</a>
                    @endif
                    @if(optional(auth()->user())->is_admin)
                    <a href="{{route('admin.categories')}}">
                     <i style="color: unset;" class="fa-solid fa-gear"></i> Manage Site
                    </a>
                    @endif
                    @auth

                        <a href="#" class="top-link"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                            @csrf
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="top-link">Login / Register</a>
                    @endauth
                </div>
                </div>
            </div>
        </div>
        <div class="main-header">
            <div class="container">
                <a href="{{route('home')}}" class="logo">
                    <div class="logo-img">
                        <img src="{{asset('img/logo_matgar.png')}}" alt="Matgar Logo">
                    </div>
                    <h1>Matgar</h1>
                </a>
                @php
                    $category_groups = \App\Models\CategoryGroup::with('categories')->get();
                    @endphp
                <div class="search-box">
                    <select class="search-cat">
                        
                <option value="">All Categories</option>
                @forelse($category_groups as $group)
                <option value="{{$group->id}}">{{$group->name}}</option>
                @empty
                @endforelse
                    </select>
                    <input type="text" id="searchInput" placeholder="Enter your product name...">
                    <button id="searchBtn"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>

                <div class="user-actions">
                    <a href="{{ url('/customer_account') }}" class="action-item {{ request()->is('customer_account') ? 'active-link' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="33" height="33" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                        </svg>
                        <span>My Account</span>
                    </a>
                        <a href="/wishlist"class="action-item {{ request()->is('wish_list.html') ? 'active-link' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="33" height="33" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                        <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
                        </svg>
                    <span>Wishlist</span>
                </a>

                <a href="{{ route('cart.index') }}" class="action-item {{ request()->is('cart') ? 'active-link' : '' }}">
                    <!-- Badge showing total quantity -->
                    <span class="badge_h">
                        {{ \App\Models\Cart::where('user_id', auth()->id())->whereNull('order_id')->count()}}
                    </span>
                    <!-- Cart icon SVG -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-cart4" viewBox="0 0 16 16">
                        <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5M3.14 5l.5 2H5V5zM6 5v2h2V5zm3 0v2h2V5zm3 0v2h1.36l.5-2zm1.11 3H12v2h.61zM11 8H9v2h2zM8 8H6v2h2zM5 8H3.89l.5 2H5zm0 5a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0m9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0"/>
                    </svg>

                    <span>Cart</span>
                </a>
                <style>
                    .action-item {
                        position: relative;
                        display: inline-flex;
                        align-items: center;
                        gap: 5px;
                    }

                    .badge_h {
                        position: absolute;
                        top: 0;
                        right: 0;
                        transform: translate(50%, -50%);
                        background-color: red;
                        color: white;
                        font-size: 12px;
                        font-weight: bold;
                        width: 20px;
                        height: 20px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        border-radius: 50%;
                        box-shadow: 0 0 2px rgba(0,0,0,0.5);
                    }
                </style>

                </div>
            </div>
        </div>

        <nav class="main-nav">
            <div class="container">
                <ul>
                    <li >
                        <a href="/" class="{{ request()->routeIs('home') ? 'active-link' : '' }}">Home</a>
                    </li>
                    <li class="dropdown-parent">
                    <a href="/shop" class="{{ request()->routeIs('shop.index') ? 'active-link' : '' }}">
                    Shop <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tags-fill" viewBox="0 0 16 16">
                                    <path d="M2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586zm3.5 4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3"/>
                                    <path d="M1.293 7.793A1 1 0 0 1 1 7.086V2a1 1 0 0 0-1 1v4.586a1 1 0 0 0 .293.707l7 7a1 1 0 0 0 1.414 0l.043-.043z"/>
                                </svg>
                    </a>    
                    
                    @if(count($category_groups))
<ul class="dropdown-menu">
    @foreach($category_groups as $group)
    <li class="dropdown-submenu">
        <a href="{{ route('shop.index', ['group' => $group->id]) }}" class="dropdown-item">
        {{$group->name}}<i class="fa-solid fa-angle-right"></i>
        </a>
        @if($group->categories)
        <ul class="dropdown-menu submenu">
            @foreach($group->categories as $cat)
            <li><a href="{{ route('shop.index', ['category' => $cat->id]) }}">{{$cat->name}}</a></li>
            @endforeach
        </ul>
        @endif
    </li>
    @endforeach

</ul>
@endif
                    </li>
                    <li>
    <a href="/shop?sale=true" class="nav-hot">
        <i class="fa-solid fa-fire">    </i> Hot Offers
    </a>
</li>
                    <li><a href="/blog"class="{{ request()->routeIs('blog') ? 'active-link' : '' }}">Blog</a></li>
                    <li><a href='/about'class="{{ request()->routeIs('about') ? 'active-link' : '' }}">About Us</a></li>
                    <li><a href="/contact"class="{{ request()->routeIs('contact') ? 'active-link' : '' }}">Contact Us</a></li>
                </ul>
            </div>
        </nav>

    </header>
<aside class="sidebar">
@php
    $seller = auth()->user()->seller;
    $name = optional($seller)->shop_name ?? auth()->user()->name;
    $parts = explode(' ', trim($name));
    $initials = '';

    if (isset($parts[0])) {
        $initials .= strtoupper($parts[0][0]);
    }
    if (isset($parts[1])) {
        $initials .= strtoupper($parts[1][0]);
    }
@endphp
@if(optional($seller)->approved)
    <div class="user-profile-summary">
    

<div class="profile-img" style="background:#2c3e50;">{{ $initials }}</div>
        <div class="profile-info">
            <h3>{{ $name }}</h3>

            <span class="user-role" style="color:#10b981;">
                <i class="fa-solid fa-check-circle"></i> Verified Seller
            </span>
        </div>
    </div>
    <nav class="nav-menu">
        <p class="nav-label">Management</p>

        <a href="{{ route('seller.dashboard') }}"
           class="nav-item {{ request()->routeIs('seller.dashboard*') ? 'active' : '' }}">
            <i class="fa-solid fa-chart-line"></i> Dashboard
        </a>
        
        <a href="{{ route('seller.inventory') }}"
           class="nav-item {{ request()->routeIs('seller.inventory*') ? 'active' : '' }}">
            <i class="fa-solid fa-box-open"></i> Inventory
        </a>

        <a href="{{ route('seller.orders') }}"
           class="nav-item {{ request()->routeIs('seller.orders*') ? 'active' : '' }}">
            <i class="fa-solid fa-clipboard-list"></i> Orders
        </a>

        <!--<a href="{{ route('seller.analytics') }}"
           class="nav-item {{ request()->routeIs('seller.analytics*') ? 'active' : '' }}">
            <i class="fa-solid fa-chart-pie"></i> Analytics
        </a>-->
@endif
        <p class="nav-label">Configuration</p>

        <a href="{{ route('seller.settings') }}"
           class="nav-item {{ request()->routeIs('seller.settings*') ? 'active' : '' }}">
            <i class="fa-solid fa-store"></i> Store Settings
        </a>
        <a href="{{route('home')}}" class="nav-item logout">
            <i class="fa-solid fa-power-off"></i> exit
        </a>
    </nav>
</aside>

<aside class="sidebar">
    
    <nav class="nav-menu">
        <p class="nav-label">Management</p>
        
        <a href="{{ route('admin.sellers.index') }}"
        class="nav-item {{ request()->routeIs('admin.sellers*') ? 'active' : '' }}">
            <i class="fa-solid fa-user-tie"></i> Sellers
        </a>
        <a href="{{ route('admin.category_groups') }}"
        class="nav-item {{ request()->routeIs('admin.category_groups*') ? 'active' : '' }}">
            <i class="fa-solid fa-layer-group"></i> Category Groups
        </a>
        <a href="{{ route('admin.categories') }}"
            class="nav-item {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                <i class="fa-solid fa-tags"></i> Categories
        </a>
        <a href="{{route('home')}}" class="nav-item logout">
            <i class="fa-solid fa-power-off"></i> exit
        </a>
    </nav>
</aside>

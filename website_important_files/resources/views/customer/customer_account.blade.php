@extends('layouts.app')
@section('title', __('My Account'))

@section('style')
<style> 
/* =========================================
1. VARIABLES & RESET
========================================= */
:root {
    --primary: #2563eb;
    --primary-dark: #1e40af;
    --secondary: #64748b;
    --success: #10b981;
    --warning: #f59e0b;
    --danger: #ef4444;
    --surface: #ffffff;
    --bg-body: #f8fafc;
    --border: #e2e8f0;
    --text-main: #1e293b;
    --text-muted: #64748b;
    --sidebar-width: 260px;
    --radius: 8px;
    --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}
body { font-family: var(--font-main); background-color: var(--bg-body); color: #333; }
a { text-decoration: none; color: inherit; transition: 0.2s; }
ul { list-style: none; }

/* MAIN LAYOUT */
.main-container {
    max-width: 1400px; margin: 30px auto; padding: 0 20px;
    display: grid; grid-template-columns: var(--sidebar-width) 1fr; gap: 30px;
}
aside.sidebar {
    background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius);
    position: sticky; top: 20px; box-shadow: var(--shadow); overflow: hidden;
}
.user-profile-summary {
    padding: 25px 20px; border-bottom: 1px solid var(--border);
    display: flex; align-items: center; gap: 15px; background: #f1f5f9;
}
.profile-img {
    width: 50px; height: 50px; background: var(--text-main); color: white;
    border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700;
}
.profile-info h3 { font-size: 1rem; margin: 0; }
.user-role { font-size: 0.75rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; }
.nav-menu { padding: 20px; }
.nav-label { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; color: #94a3b8; margin: 15px 0 8px 10px; }
.nav-item { display: flex; align-items: center; gap: 12px; padding: 12px 15px; color: var(--text-muted); font-size: 0.9rem; font-weight: 500; border-radius: var(--radius); margin-bottom: 5px; cursor: pointer; }
.nav-item:hover { background-color: #f1f5f9; color: var(--primary); }
.nav-item.active { background-color: #eff6ff; color: var(--primary); font-weight: 600; }
.nav-item.logout { color: var(--danger); margin-top: 20px; border-top: 1px dashed var(--border); }
.nav-item.logout:hover { background: #fef2f2; }

/* CONTENT AREA */
.content-wrapper { width: 100%; }
.tab-pane { display: none; animation: fadeUp 0.3s ease; }
.tab-pane.active { display: block; }
@keyframes fadeUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

.content-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
.content-header h2 { font-size: 1.5rem; color: var(--text-main); }

/* Tables */
.table-container { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow-x: auto; box-shadow: var(--shadow); }
.pro-table { width: 100%; border-collapse: collapse; min-width: 600px; }
.pro-table th { text-align: left; padding: 15px 20px; background: #f8fafc; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; border-bottom: 1px solid var(--border); }
.pro-table td { padding: 15px 20px; border-bottom: 1px solid #f1f5f9; font-size: 0.9rem; vertical-align: middle; }
.badge { padding: 4px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; }
.badge.success { background: #ecfdf5; color: #059669; }
.badge.warning { background: #fffbeb; color: #d97706; }

/* Forms */
.form-card { background: var(--surface); padding: 30px; border: 1px solid var(--border); border-radius: var(--radius); box-shadow: var(--shadow); }
.row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
.input-group { margin-bottom: 20px; }
.input-group label { display: block; margin-bottom: 8px; font-size: 0.9rem; font-weight: 600; }
input, select, textarea { width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: var(--radius); outline: none; }
input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); }
.btn-primary { background: var(--primary); color: white; padding: 10px 25px; border-radius: var(--radius); border: none; cursor: pointer; }
.btn-secondary { background: white; border: 1px solid var(--border); padding: 10px 25px; border-radius: var(--radius); cursor: pointer; }
.btn-xs { padding: 5px 10px; border-radius: 4px; border: 1px solid var(--border); background: white; cursor: pointer; }
</style>
@endsection

@section('content')
<div class="main-container">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="user-profile-summary">
            <div class="profile-img">JD</div>
            <div class="profile-info">
                <h3>{{ $user->name }}</h3>
                <span class="user-role">Member</span>
            </div>
        </div>

        <nav class="nav-menu">
            <p class="nav-label">My Account</p>
            <a href="#" class="nav-item active" onclick="showTab('dashboard', this)">
                <i class="fa-solid fa-chart-line"></i> Recent Orders
            </a>
            <a href="#" class="nav-item" onclick="showTab('orders', this)">
                <i class="fa-solid fa-box"></i> History Orders
            </a>

            <p class="nav-label">Settings</p>
            <a href="#" class="nav-item" onclick="showTab('addresses', this)">
                <i class="fa-solid fa-map-location-dot"></i> Addresses
            </a>
            <a href="#" class="nav-item" onclick="showTab('profile', this)">
                <i class="fa-solid fa-user-gear"></i> Edit Profile
            </a>
            <a href="#" class="nav-item logout"onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa-solid fa-power-off"></i> Log Out
            </a>
        </nav>
    </aside>

    <!-- CONTENT AREA -->
    <main class="content-wrapper">

        <!-- DASHBOARD TAB -->
        <div id="dashboard" class="tab-pane active">
            <header class="content-header">
                <h2>Account Overview</h2>
            </header>

            <div class="table-container">
                <h3 style="padding:20px; border-bottom:1px solid #eee; margin:0;">Recent Orders</h3>
                <table class="pro-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders->take(5) as $order)
                            <tr>
                                <td><strong>#{{ $order->id }}</strong></td>
                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                <td>${{ number_format($order->total, 2) }}</td>
                                <td>
                                    @if($order->status === 'completed')
                                        <span class="badge success">Completed</span>
                                    @elseif($order->status === 'processing')
                                        <span class="badge warning">Processing</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('orders.show', $order->id) }}" class="btn-xs"><i class="fa-solid fa-eye"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align:center; padding:20px;">No orders found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ADDRESSES TAB -->
        <div id="addresses" class="tab-pane">
            <header class="content-header">
                <h2>Saved Addresses</h2>
                <button class="btn-primary" onclick="openAddressModal()">+ Add New Address</button>
            </header>
            <div id="addressGrid" class="stats-grid" style="grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));"></div>
        </div>

        <!-- PROFILE TAB -->
        <div id="profile" class="tab-pane">
            <header class="content-header"><h2>Edit Profile</h2></header>
            <div class="form-card">
                <form id="profileForm">
                    <div class="row">
                        <div class="input-group"><label>First Name</label><input type="text" value="{{ $user->name }}"></div>
                        <div class="input-group"><label>Last Name</label><input type="text" value="{{ $user->name }}"></div>
                    </div>
                    <div class="input-group"><label>Email</label><input type="email" value="{{ $user->email }}"></div>
                    <div class="input-group"><label>Phone</label><input type="tel" value="{{ $user->phone }}"></div>
                    <div class="form-actions">
                        <button type="submit" class="btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>

    </main>
</div>
@endsection

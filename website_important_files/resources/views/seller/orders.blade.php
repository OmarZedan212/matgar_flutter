@extends('layouts.seller')
@section('title', __('messages.seller'))
@section('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
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
* { box-sizing: border-box; margin: 0; padding: 0; font-family: "Poppins", sans-serif; }
body {
  background-color: var(--bg-body);
  color: var(--text-main);
  line-height: 1.5;
}
a { text-decoration: none; color: inherit; transition: 0.2s; }
ul { list-style: none; }
.main-container {
  max-width: 1400px;
  margin: 30px auto;
  padding: 0 20px;
  display: grid;
  grid-template-columns: var(--sidebar-width) 1fr;
  gap: 30px;
  align-items: start;
}
aside.sidebar {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--radius);
  position: sticky;
  top: 20px;
  box-shadow: var(--shadow);
  overflow: hidden;
}
.user-profile-summary {
  padding: 25px 20px;
  border-bottom: 1px solid var(--border);
  display: flex;
  align-items: center;
  gap: 15px;
  background: #f1f5f9;
}
.profile-img {
  width: 50px;
  height: 50px;
  background: var(--text-main);
  color: white;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
}
.profile-info h3 { font-size: 1rem; margin: 0; }
.user-role {
  font-size: 0.75rem;
  color: var(--text-muted);
  font-weight: 600;
  text-transform: uppercase;
}
.nav-menu { padding: 20px; }
.nav-label {
  font-size: 0.7rem;
  font-weight: 700;
  text-transform: uppercase;
  color: #94a3b8;
  margin: 15px 0 8px 10px;
}
.nav-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px 15px;
  color: var(--text-muted);
  font-size: 0.9rem;
  font-weight: 500;
  border-radius: var(--radius);
  margin-bottom: 5px;
  cursor: pointer;
}
.nav-item:hover { background-color: #f1f5f9; color: var(--primary); }
.nav-item.active {
  background-color: #eff6ff;
  color: var(--primary);
  font-weight: 600;
}
.nav-item.logout {
  color: var(--danger);
  margin-top: 20px;
  border-top: 1px dashed var(--border);
}
.nav-item.logout:hover { background: #fef2f2; }
.content-wrapper { width: 100%; }
.content-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 25px;
}
.table-container {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--radius);
  overflow-x: auto;
  box-shadow: var(--shadow);
}
.pro-table {
  width: 100%;
  border-collapse: collapse;
  min-width: 600px;
}
.pro-table th {
  text-align: left;
  padding: 15px 20px;
  background: #f8fafc;
  color: var(--text-muted);
  font-size: 0.75rem;
  text-transform: uppercase;
  border-bottom: 1px solid var(--border);
}
.pro-table td {
  padding: 15px 20px;
  border-bottom: 1px solid #f1f5f9;
  font-size: 0.9rem;
  vertical-align: middle;
}
.badge {
  padding: 4px 10px;
  border-radius: 12px;
  font-size: 0.75rem;
  font-weight: 600;
}
.badge.red {
    background: #ffdede;
    color: #da0000;
}
.badge.success { background: #ecfdf5; color: #059669; }
.badge.warning { background: #fffbeb; color: #d97706; }
.badge.warning { background: #fffbeb; color: #d97706; }
.badge.blue { background: #eff6ff; color: #2563eb; }
</style>
@endsection

@section('content')
<div class="main-container">
@include('layouts.partials.seller-sidebar')

    <main class="content-wrapper">
        <header class="content-header">
            <h2>Order Management</h2>
            <select id="filterStatus" class="search-sm" onchange="renderOrders()">
                <option value="all">All Status</option>
                <option value="Pending">Pending</option>
                <option value="Shipped">Shipped</option>
                <option value="Delivered">Delivered</option>
            </select>
        </header>

        <div class="table-container">
            <table class="pro-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="ordersTableBody">
                </tbody>
            </table>
        </div>
    </main>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    window.showToast = function(message, isSuccess = true) {
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
        toast.style.backgroundColor = isSuccess ? "#10b981" : "#ef4444";
        toast.classList.add('show');
        setTimeout(() => { toast.classList.remove('show'); }, 3000);
    };

    let ordersData = @json($ordersData ?? []);


    window.renderOrders = function() {
    const tbody = document.getElementById('ordersTableBody');
    const filterStatEl = document.getElementById('filterStatus');
    const filterStat = filterStatEl ? filterStatEl.value : 'all';

    if (!tbody) return;
    tbody.innerHTML = "";

    ordersData.forEach(order => {
        if (filterStat !== 'all' && order.status !== filterStat) return;
        let badgeColor =
            order.status === 'Delivered' ? 'success' :
            (order.status === 'Shipped' ? 'blue' :
            (order.status === 'Pending' ? 'warning' : 'red'));

        tbody.innerHTML += `
            <tr>
                <td>${order.display_id}</td>
                <td>${order.customer}</td>
                <td>${order.date}</td>
                <td>$${order.total.toFixed ? order.total.toFixed(2) : order.total}</td>
                <td><span class="badge ${badgeColor}">${order.status}</span></td>
                <td>
                <a href="{{ route('seller.orders.show', ':id') }}"
       class="btn btn-sm btn-link"
       style="margin-right:8px;">View</a>
                    <select class="search-sm" style="width:100px; padding:5px;"
                            onchange="updateOrderStatus(${order.id}, this.value)">
                        <option value="Action" disabled selected>Update</option>
                        <option value="Pending">Pending</option>
                        <option value="Shipped">Ship</option>
                        <option value="Delivered">Complete</option>
                        <option value="Cancelled">Cancel</option>
                    </select>
                </td>
            </tr>`.replace(':id', order.id);;
    });
};


window.updateOrderStatus = function(id, newStatus) {
    const order = ordersData.find(o => o.id === id);
    if (!order) return;

    $.ajax({
        url: "{{ route('seller.update_order_status') }}",
        method: "POST",
        data: {
            id: id,
            status: newStatus
        },
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        success: function(res) {
            order.status = newStatus;
            renderOrders();
            showToast(`Order ${id} marked as ${newStatus}`, true);
        },
        error: function() {
            showToast("Failed to update order status", false);
        }
    });
};


    renderOrders();
});
</script>
@endsection

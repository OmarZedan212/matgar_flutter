@extends('layouts.seller')
@section('title', __('messages.seller'))
@section('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>

/* =========================================
   1. VARIABLES & RESET
   ========================================= */
   :root {
  --primary: #2563eb; /* Professional Blue */
  --primary-dark: #1e40af;
  --secondary: #64748b; /* Slate Gray */
  --success: #10b981; /* Green */
  --warning: #f59e0b; /* Orange/Yellow */
  --danger: #ef4444; /* Red */
  --surface: #ffffff; /* White Background */
  --bg-body: #f8fafc; /* Light Grey Background */
  --border: #e2e8f0;
  --text-main: #1e293b;
  --text-muted: #64748b;
  --sidebar-width: 260px;
  --radius: 8px;
  --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  font-family: "Poppins", sans-serif;
}
body {
  background-color: var(--bg-body);
  color: var(--text-main);
  line-height: 1.5;
}
a {
  text-decoration: none;
  color: inherit;
  transition: 0.2s;
}
ul {
  list-style: none;
}

/* =========================================
   2. MAIN LAYOUT
   ========================================= */
.main-container {
  max-width: 1400px;
  margin: 30px auto;
  padding: 0 20px;
  display: grid;
  grid-template-columns: var(--sidebar-width) 1fr;
  gap: 30px;
  align-items: start;
}

/* --- SIDEBAR --- */
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
.profile-info h3 {
  font-size: 1rem;
  margin: 0;
}
.user-role {
  font-size: 0.75rem;
  color: var(--text-muted);
  font-weight: 600;
  text-transform: uppercase;
}

/* Navigation */
.nav-menu {
  padding: 20px;
}
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
.nav-item:hover {
  background-color: #f1f5f9;
  color: var(--primary);
}
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
.nav-item.logout:hover {
  background: #fef2f2;
}

/* --- CONTENT --- */
.content-wrapper {
  width: 100%;
}
.tab-pane {
  display: none;
  animation: fadeUp 0.3s ease;
}
.tab-pane.active {
  display: block;
}
@keyframes fadeUp {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.content-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 25px;
}
.content-header h2 {
  font-size: 1.5rem;
  color: var(--text-main);
}

/* =========================================
   3. COMPONENTS
   ========================================= */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
  gap: 20px;
  margin-bottom: 30px;
}
.stat-card {
  background: var(--surface);
  padding: 25px;
  border-radius: var(--radius);
  border: 1px solid var(--border);
  box-shadow: var(--shadow);
  display: flex;
  align-items: center;
  gap: 20px;
}
.icon-bg {
  width: 55px;
  height: 55px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.4rem;
}
.icon-bg.blue {
  background: #eff6ff;
  color: var(--primary);
}
.icon-bg.orange {
  background: #fff7ed;
  color: var(--warning);
}
.icon-bg.green {
  background: #f0fdf4;
  color: var(--success);
}
.stat-card h4 {
  font-size: 0.85rem;
  color: var(--text-muted);
  margin-bottom: 5px;
}
.stat-num {
  font-size: 1.5rem;
  font-weight: 700;
}

/* Charts */
.charts-grid {
  display: grid;
  grid-template-columns: 2fr 1fr;
  gap: 20px;
  margin-bottom: 25px;
}
.chart-card {
  background: var(--surface);
  padding: 20px;
  border-radius: var(--radius);
  border: 1px solid var(--border);
  box-shadow: var(--shadow);
  height: 350px;
  display: flex;
  flex-direction: column;
}
canvas {
  width: 100% !important;
  height: 100% !important;
}

/* Tables */
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
.tbl-img {
  width: 40px;
  height: 40px;
  border-radius: 6px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #f1f5f9;
  color: #94a3b8;
}
.tbl-img img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.badge {
  padding: 4px 10px;
  border-radius: 12px;
  font-size: 0.75rem;
  font-weight: 600;
}
.badge.success {
  background: #ecfdf5;
  color: #059669;
}
.badge.warning {
  background: #fffbeb;
  color: #d97706;
}
.badge.danger {
  background: #fef2f2;
  color: #dc2626;
}

/* Forms & Inputs */
.form-card {
  background: var(--surface);
  padding: 30px;
  border: 1px solid var(--border);
  border-radius: var(--radius);
  box-shadow: var(--shadow);
}
.row {
  display: grid;
  grid-template-columns: 1fr 1fr 1.2fr;
  gap: 20px;
}
.input-group {
  margin-bottom: 20px;
}
.input-group label {
  display: block;
  margin-bottom: 8px;
  font-size: 0.9rem;
  font-weight: 600;
}
input,
select,
textarea {
  width: 100%;
  padding: 10px;
  border: 1px solid var(--border);
  border-radius: var(--radius);
  outline: none;
}
input:focus {
  border-color: var(--primary);
  box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

.btn-primary {
  background: var(--primary);
  color: white;
  padding: 10px 25px;
  border-radius: var(--radius);
  border: none;
  cursor: pointer;
}
.btn-secondary {
  background: white;
  border: 1px solid var(--border);
  padding: 10px 25px;
  border-radius: var(--radius);
  cursor: pointer;
}
.btn-xs {
  padding: 5px 10px;
  border-radius: 4px;
  border: 1px solid var(--border);
  background: white;
  cursor: pointer;
}
.btn-xs.edit {
  color: var(--primary);
  border-color: var(--primary);
  margin-right: 5px;
}

/* Image Upload Box */
.image-upload-box {
  width: 100%;
  height: 150px;
  border: 2px dashed #cbd5e1;
  border-radius: var(--radius);
  background: #f8fafc;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  margin-bottom: 20px;
  color: var(--text-muted);
}
.image-upload-box:hover {
  background: #f1f5f9;
  border-color: var(--primary);
}
.image-upload-box i {
  font-size: 2rem;
  margin-bottom: 10px;
}

/* =========================================
   4. MODALS
   ========================================= */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: none;
  justify-content: center;
  align-items: center;
  z-index: 9999;
}
.modal-overlay.open {
  display: flex;
  animation: fadeIn 0.2s ease;
}
.modal-box {
  background: white;
  width: 500px;
  padding: 30px;
  border-radius: 10px;
}
.modal-header {
  display: flex;
  justify-content: space-between;
  margin-bottom: 20px;
  border-bottom: 1px solid #eee;
  padding-bottom: 10px;
}
.close-modal {
  background: none;
  border: none;
  font-size: 1.5rem;
  cursor: pointer;
}
@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}


</style>

@endsection
@section('content')
<div class="main-container">

        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="user-profile-summary">
                <div class="profile-img" style="background:#2c3e50;">EW</div>
                <div class="profile-info">
                    <h3>ElectroWorld</h3>
                    <span class="user-role" style="color:#10b981;">
                        <i class="fa-solid fa-check-circle"></i> Verified Seller
                    </span>
                </div>
            </div>

            <nav class="nav-menu">
                <p class="nav-label">Management</p>
                <a href="#" class="nav-item active" onclick="showTab('dashboard', this)">
                    <i class="fa-solid fa-chart-line"></i> Dashboard
                </a>
                <a href="#" class="nav-item" onclick="showTab('inventory', this)">
                    <i class="fa-solid fa-box-open"></i> Inventory
                </a>
                <a href="#" class="nav-item" onclick="showTab('orders', this)">
                    <i class="fa-solid fa-clipboard-list"></i> Orders
                </a>
                <a href="#" class="nav-item" onclick="showTab('analytics', this)">
                    <i class="fa-solid fa-chart-pie"></i> Analytics
                </a>

                <p class="nav-label">Configuration</p>
                <a href="#" class="nav-item" onclick="showTab('settings', this)">
                    <i class="fa-solid fa-store"></i> Store Settings
                </a>
                <a href="home.html" class="nav-item logout">
                    <i class="fa-solid fa-power-off"></i> exit
                </a>
            </nav>
        </aside>

        <!-- CONTENT AREA -->
        <main class="content-wrapper">

            <!-- TAB 1: DASHBOARD -->
            <div id="dashboard" class="tab-pane active">
                <header class="content-header">
                    <h2>Store Overview</h2>
                </header>

                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="icon-bg blue"><i class="fa-solid fa-dollar-sign"></i></div>
                        <div><h4>Total Revenue</h4><span class="stat-num">$54,230</span></div>
                    </div>
                    <div class="stat-card">
                        <div class="icon-bg orange"><i class="fa-solid fa-box"></i></div>
                        <div><h4>Total Orders</h4><span class="stat-num">1,452</span></div>
                    </div>
                    <div class="stat-card">
                        <div class="icon-bg green"><i class="fa-solid fa-users"></i></div>
                        <div><h4>Products</h4><span class="stat-num">12</span></div>
                    </div>
                </div>
                    <div class="chart-card">
                        <h3>Revenue (This Week)</h3>
                        <div style="height:300px; width:100%;">
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div>
            </div>

            <!-- TAB 2: INVENTORY -->
            <div id="inventory" class="tab-pane">
                <header class="content-header">
                    <h2>Product Inventory</h2>
                    <div style="display:flex; gap:10px;">
                        <select id="filterCategory" class="search-sm" onchange="renderInventory()">
                            <option value="all">All Categories</option>
                            <optgroup label="Electronics">
                                <option value="mobiles">Mobiles</option>
                                <option value="laptops">Laptops</option>
                                <option value="smartwatches">Smartwatches</option>
                                <option value="cameras">Cameras</option>
                                <option value="accessories">Accessories</option>
                            </optgroup>
                            <optgroup label="Fashion">
                                <option value="mens-wear">Men's Wear</option>
                                <option value="womens-wear">Women's Wear</option>
                                <option value="shoes">Shoes</option>
                                <option value="bags">Bags</option>
                            </optgroup>
                            <optgroup label="Home & Living">
                                <option value="furniture">Furniture</option>
                                <option value="kitchen">Kitchen</option>
                                <option value="appliances">Appliances</option>
                                <option value="decor">Decor</option>
                            </optgroup>
                            <optgroup label="Beauty">
                                <option value="skincare">Skincare</option>
                                <option value="makeup">Makeup</option>
                                <option value="perfumes">Perfumes</option>
                            </optgroup>
                            <optgroup label="Sports">
                                <option value="gym">Gym Equipment</option>
                                <option value="sportswear">Sportswear</option>
                                <option value="supplements">Supplements</option>
                            </optgroup>
                        </select>
                        <button class="btn-primary" onclick="openProductModal()">+ Add Product</button>
                    </div>
                </header>

                <div class="table-container">
                    <table class="pro-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="inventoryTableBody">
                            <!-- JS WILL FILL THIS -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TAB 3: ORDERS -->
            <div id="orders" class="tab-pane">
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
            </div>

            <!-- TAB 4: ANALYTICS -->
            <div id="analytics" class="tab-pane">
                <header class="content-header"><h2>Performance Analytics</h2></header>

                <div class="charts-grid">
                    <div class="chart-card">
                        <h3>Top Selling Products</h3>
                        <div id="topProductsContainer" style="margin-top:20px; display:flex; flex-direction:column; gap:15px;">
                            <!-- JS WILL FILL THIS -->
                        </div>
                    </div>
                    <div class="chart-card">
                        <h3>Category Distribution</h3>
                        <div style="height:250px; width:100%;">
                            <canvas id="categoryChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 5: SETTINGS -->
            <div id="settings" class="tab-pane">
                <header class="content-header">
                    <h2>Store Configuration</h2>
                </header>

                <div class="form-card">
                    <form id="storeForm">
                    @csrf
                        <!-- GENERAL INFO -->
                        <h4 style="margin-bottom:15px; color:#2c3e50; border-bottom:1px solid #eee; padding-bottom:10px;">
                            <i class="fa-solid fa-store"></i> General Information
                        </h4>

                        <div class="row">
                            <div class="input-group">
                                <label>Store Name</label>
                                <input type="text" id="storeName" value="ElectroWorld Inc." required>
                            </div>
                            <div class="input-group">
                                <label>Default Currency</label>
                                <select id="storeCurrency">
                                    <option value="USD" selected>USD ($)</option>
                                    <option value="EGP">EGP (E£)</option>
                                    <option value="EUR">EUR (€)</option>
                                </select>
                            </div>
                        </div>

                        <div class="input-group">
                            <label>Store Description</label>
                            <textarea id="storeDesc" rows="3">We sell the best electronics in the region with official warranty.</textarea>
                        </div>

                        <!-- CONTACT DETAILS -->
                        <h4 style="margin:25px 0 15px; color:#2c3e50; border-bottom:1px solid #eee; padding-bottom:10px;">
                            <i class="fa-solid fa-address-book"></i> Contact Details
                        </h4>

                        <div class="row">
                            <div class="input-group">
                                <label>Business Email</label>
                                <input type="email" id="storeEmail" value="contact@electroworld.com" required>
                            </div>
                            <div class="input-group">
                                <label>Support Phone</label>
                                <input type="tel" id="storePhone" value="+20 123 456 789">
                            </div>
                        </div>

                        <div class="input-group">
                            <label>Physical Address</label>
                            <input type="text" id="storeAddress" value="123 Tech Street, Cairo, Egypt">
                        </div>

                        <!-- SOCIAL MEDIA -->
                        <h4 style="margin:25px 0 15px; color:#2c3e50; border-bottom:1px solid #eee; padding-bottom:10px;">
                            <i class="fa-solid fa-share-nodes"></i> Social Links
                        </h4>

                        <div class="row">
                            <div class="input-group">
                                <label>Facebook Page</label>
                                <input type="url" id="storeFb" placeholder="https://facebook.com/yourstore">
                            </div>
                            <div class="input-group">
                                <label>Instagram Profile</label>
                                <input type="url" id="storeInsta" placeholder="https://instagram.com/yourstore">
                            </div>
                        </div>

                        <div class="form-actions" style="margin-top:30px;">
                            <button class="btn-primary" type="submit" style="padding:12px 30px; font-size:1rem;">
                                <i class="fa-solid fa-save"></i> Save Configuration
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </main>
    </div>

    <!-- 3. ADD PRODUCT MODAL -->
    <div id="product-modal" class="modal-overlay">
        <div class="modal-box">
            <header class="modal-header">
                <h3>Add New Product</h3>
                <button class="close-modal" onclick="closeProductModal()">&times;</button>
            </header>

            <form id="addProductForm" enctype="multipart/form-data">
            @csrf
    <!-- Hidden ID for Edit Mode -->
    <input type="hidden" id="editProductId" name="id">

    <div class="image-upload-box" id="imageUploadBox">
        <i class="fa-solid fa-cloud-arrow-up"></i>
        <p>Click to upload image</p>
        <input type="file" id="pImage" name="image" hidden>
    </div>

    <div class="input-group">
        <label>Product Name</label>
        <input type="text" id="pName" name="name" required placeholder="e.g. Wireless Mouse">
    </div>

    <div class="row">
        <div class="input-group">
            <label>Price ($)</label>
            <input type="number" id="pPrice" name="price" required placeholder="0.00" step="0.01">
        </div>
        <div class="input-group">
            <label>Stock Quantity</label>
            <input type="number" id="pStock" name="qty" required placeholder="10">
        </div>
        <div class="input-group">
            <label>Category</label>
            <select id="pCategory" name="category"
                    style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                <option value="" disabled selected>Select a Category</option>

                <optgroup label="Electronics">
                    <option value="mobiles">Mobiles</option>
                    <option value="laptops">Laptops</option>
                    <option value="smartwatches">Smartwatches</option>
                    <option value="cameras">Cameras</option>
                    <option value="accessories">Accessories</option>
                </optgroup>

                <optgroup label="Fashion">
                    <option value="mens-wear">Men's Wear</option>
                    <option value="womens-wear">Women's Wear</option>
                    <option value="shoes">Shoes</option>
                    <option value="bags">Bags</option>
                </optgroup>

                <optgroup label="Home & Living">
                    <option value="furniture">Furniture</option>
                    <option value="kitchen">Kitchen</option>
                    <option value="appliances">Appliances</option>
                    <option value="decor">Decor</option>
                </optgroup>

                <optgroup label="Beauty">
                    <option value="skincare">Skincare</option>
                    <option value="makeup">Makeup</option>
                    <option value="perfumes">Perfumes</option>
                </optgroup>

                <optgroup label="Sports">
                    <option value="gym">Gym Equipment</option>
                    <option value="sportswear">Sportswear</option>
                    <option value="supplements">Supplements</option>
                </optgroup>
            </select>
        </div>
    </div>

    <div class="input-group">
        <label>Product Description</label>
        <textarea id="pDesc" name="description" rows="3"
                  placeholder="Enter product details..."
                  style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:8px; resize:vertical;"></textarea>
    </div>

    <div class="form-actions">
        <button type="button" class="btn-secondary" onclick="closeProductModal()">Cancel</button>
        <button type="submit" class="btn-primary" id="modalSubmitBtn">Add Product</button>
    </div>
</form>

        </div>
    </div>
@endsection
@section('scripts')
<script src="{{ asset('js/chart.js') }}"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {

    // =========================================
    // 0. CSRF (Laravel)
    // =========================================
    const csrfToken = document.querySelector('meta[name="csrf-token"]')
        ? document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        : '';

    // =========================================
    // 1. INTERNAL HELPER: TOAST (The Pop-up)
    // =========================================
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

        if (isSuccess) {
            toast.classList.add('success');
            toast.style.backgroundColor = "#10b981"; // Green
        } else {
            toast.classList.remove('success');
            toast.style.backgroundColor = "#ef4444"; // Red
        }

        toast.classList.add('show');
        setTimeout(() => { toast.classList.remove('show'); }, 3000);
    };

    // =========================================
    // 2. DATA SOURCES (no localStorage)
    // =========================================

    // بدل localStorage → بيانات جاية من Laravel في window.inventoryData
    let inventoryData = @json($inventoryData);

    // Orders (تقدر تبعتها من Laravel في window.ordersData)
    let ordersData = window.ordersData || [
        { id: "#ORD-9921", customer: "Jane Doe",  date: "Oct 24, 2025", total: 120.00, status: "Delivered" },
        { id: "#ORD-9922", customer: "Mike Ross", date: "Oct 25, 2025", total: 45.50,  status: "Pending" },
        { id: "#ORD-9923", customer: "Rachel G.", date: "Oct 26, 2025", total: 299.99, status: "Shipped" }
    ];

    const topProducts = window.topProducts || [
        { name: "Wireless Earbuds", sold: 1200, percent: 85 },
        { name: "Smart Watch",      sold: 940,  percent: 65 },
        { name: "Gaming Mouse",     sold: 600,  percent: 45 },
        { name: "USB-C Hub",        sold: 320,  percent: 25 }
    ];

    // Helper: إعادة الريندر فقط (مش بنخزن محلي)
    function saveInventory() {
        renderInventory();
    }

    // =========================================
    // 3. RENDER FUNCTIONS
    // =========================================

    // --- Render Inventory ---
    window.renderInventory = function() {
        const tbody = document.getElementById('inventoryTableBody');
        const filterCatEl = document.getElementById('filterCategory');
        const filterCat = filterCatEl ? filterCatEl.value : 'all';

        if (!tbody) return;
        tbody.innerHTML = "";

        inventoryData.forEach(item => {
            if (filterCat !== 'all' && item.category !== filterCat) return;

            const qty = item.qty || 0;
            let stockBadge = qty > 10 ? 'success' : (qty > 0 ? 'warning' : 'danger');
            let stockText = qty > 0 ? 'Active' : 'Out of Stock';

            const imgSrc = item.image_path? "{{asset('storage')}}" + '/' + item.image_path : '';


            const row = `
                <tr>
                    <td style="display:flex; gap:10px; align-items:center;">
                        <div class="tbl-img bg-gray">
                            <img src="${imgSrc}"
                                 onerror="this.src=''"
                                 style="width:100%; height:100%; object-fit:cover;">
                        </div>
                        <div>
                            <strong>${item.name}</strong><br>
                            <small style="color:#888;">ID: #${item.id}</small>
                        </div>
                    </td>
                    <td>${item.category || ''}</td>
                    <td>$${parseFloat(item.price || 0).toFixed(2)}</td>
                    <td>
                        <span style="font-weight:bold; color:${qty < 5 ? '#ef4444' : '#333'}">
                            ${qty} Units
                        </span>
                    </td>
                    <td><span class="badge ${stockBadge}">${stockText}</span></td>
                    <td>
                        <button class="btn-xs edit" onclick="editProduct(${item.id})">
                            <i class="fa-solid fa-pen"></i>
                        </button>
                        <button class="btn-xs" style="color:red;" onclick="deleteProduct(${item.id})">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>`;
            tbody.innerHTML += row;
        });
    };

    // --- Render Orders ---
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
                (order.status === 'Shipped' ? 'blue' : 'warning');

            tbody.innerHTML += `
                <tr>
                    <td>${order.id}</td>
                    <td>${order.customer}</td>
                    <td>${order.date}</td>
                    <td>$${order.total}</td>
                    <td><span class="badge ${badgeColor}">${order.status}</span></td>
                    <td>
                        <select class="search-sm" style="width:100px; padding:5px;"
                                onchange="updateOrderStatus('${order.id}', this.value)">
                            <option value="Action" disabled selected>Update</option>
                            <option value="Shipped">Ship</option>
                            <option value="Delivered">Complete</option>
                            <option value="Cancelled">Cancel</option>
                        </select>
                    </td>
                </tr>`;
        });
    };

    // --- Render Analytics ---
    window.renderAnalytics = function() {
        const container = document.getElementById('topProductsContainer');
        if (!container) return;
        container.innerHTML = "";

        topProducts.forEach(prod => {
            container.innerHTML += `
                <div>
                    <div style="display:flex; justify-content:space-between; font-size:0.9rem; font-weight:600; margin-bottom:5px;">
                        <span>${prod.name}</span>
                        <span style="color:#64748b;">${prod.sold} sold</span>
                    </div>
                    <div style="width:100%; height:8px; background:#f1f5f9; border-radius:10px; overflow:hidden;">
                        <div style="height:100%; width:${prod.percent}%; background:linear-gradient(90deg, #2563eb, #3b82f6);"></div>
                    </div>
                </div>`;
        });
    };

    // =========================================
    // 3.1 UPSERT HELPER (Laravel AJAX → front-end)
    // =========================================
    window.upsertProductFromServer = function(product) {
        if (!product) return;

        // هنا لو أسماء الأعمدة عندك مختلفة عدّل الماب ده
        const mapped = {
            id:          product.id,
            name:        product.name,
            category:    product.category || product.category_name || '',
            price:       product.price,
            qty:       product.qty ?? product.quantity ?? 0,
            description: product.description || '',
            image_path:  product.image_path || ''
        };

        const index = inventoryData.findIndex(p => p.id == mapped.id);
        console.log(index);
        if (index !== -1) {
            inventoryData[index] = mapped;
        } else {
            inventoryData.unshift(mapped);
        }
        console.log(inventoryData);
        renderInventory();
    };

    // Initial Render (أول ما الصفحة تفتح)
    renderInventory();
    renderOrders();
    renderAnalytics();

    // =========================================
    // 4. ACTIONS (Add / Edit / Settings) – Laravel AJAX
    // =========================================

    const addForm     = document.getElementById('addProductForm');
    const editIdInput = document.getElementById('editProductId');
    const modalTitle  = document.querySelector('.modal-header h3');
    const modalBtn    = document.getElementById('modalSubmitBtn');
    const imageUploadBox = document.getElementById('imageUploadBox');
    const pImageInput    = document.getElementById('pImage');

    // صورة المنتج - نفس سلوكك القديم
    if (imageUploadBox && pImageInput) {
        imageUploadBox.addEventListener('click', () => {
            pImageInput.click();
        });

        pImageInput.addEventListener('change', () => {
            if (pImageInput.files && pImageInput.files[0]) {
                imageUploadBox.querySelector('p').textContent = pImageInput.files[0].name;
            }
        });
    }

    // --- Add / Edit Product via Laravel AJAX ---
    if (addForm) {
        addForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const editId  = editIdInput ? editIdInput.value : '';
            const formData = new FormData(addForm);

            if (editId) {
                formData.append('id', editId);
                formData.append('_method', 'PUT');
            }

            let url  = "{{ route('seller.store_product') }}";
            if (editId) {
                url = "{{ route('seller.update_product') }}";
            }

            const btn = modalBtn || addForm.querySelector('button[type="submit"]');
            const originalText = btn ? btn.innerHTML : '';
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = editId ? 'Saving...' : 'Adding...';
            }

            $.ajax({
                url: url,
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                success: function(res) {
                    if (res.product) {
                        upsertProductFromServer(res.product);
                    }
                    showToast(editId ? 'Product Updated Successfully!' : 'Product Added Successfully!', true);

                    addForm.reset();
                    if (editIdInput) editIdInput.value = '';
                    if (imageUploadBox) {
                        const textP = imageUploadBox.querySelector('p');
                        if (textP) textP.textContent = 'Click to upload image';
                    }

                    if (modalTitle) modalTitle.innerText = "Add Product";
                    if (modalBtn)   modalBtn.innerText   = "Add Product";

                    if (typeof closeProductModal === 'function') {
                        closeProductModal();
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                        let messages = [];
                        Object.keys(xhr.responseJSON.errors).forEach(function(key) {
                            messages = messages.concat(xhr.responseJSON.errors[key]);
                        });
                        alert(messages.join("\n"));
                    } else {
                        showToast('Failed to save product', false);
                    }
                },
                complete: function() {
                    if (btn) {
                        btn.disabled = false;
                        btn.innerHTML = originalText;
                    }
                }
            });
        });
    }

    // --- Store Settings Form via Laravel AJAX ---
    const storeForm = document.getElementById('storeForm');
    if (storeForm) {
        storeForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const btn = storeForm.querySelector('button');
            const originalText = btn ? btn.innerHTML : '';
            if (btn) {
                btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';
                btn.disabled = true;
            }

            const formData = $(storeForm).serialize();

            $.ajax({
                url: "{{ route('seller.update_settings') }}",
                method: "PUT",
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                success: function(res) {
                    showToast("Store Settings Saved!", true);

                    const storeName = res.store_name || document.getElementById('storeName')?.value || '';
                    const profileTitle = document.querySelector('.profile-info h3');
                    if (profileTitle && storeName) {
                        profileTitle.innerText = storeName;
                    }
                },
                error: function() {
                    showToast("Failed to save store settings", false);
                },
                complete: function() {
                    if (btn) {
                        btn.innerHTML = originalText;
                        btn.disabled = false;
                    }
                }
            });
        });
    }

    // =========================================
    // 5. GLOBAL UI FUNCTIONS (delete / edit / orders / tabs / modal)
    // =========================================

    // Delete Product via Laravel AJAX
    window.deleteProduct = function(id) {
        if (!confirm("Delete this product?")) return;

        $.ajax({
            url: "{{ route('seller.delete_product', '') }}/" + id ,
            method: "POST",
            data: {
                id: id,
                _method: 'DELETE'
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            success: function(res) {
                inventoryData = inventoryData.filter(p => p.id != id);
                saveInventory();
                showToast("Product Deleted", false);
            },
            error: function() {
                showToast("Failed to delete product", false);
            }
        });
    };

    // Edit Product (تعبية الفورم + فتح المودال)
    window.editProduct = function(id) {
        const product = inventoryData.find(p => p.id == id);
        if (!product) return;

        const pName  = document.getElementById('pName');
        const pCat   = document.getElementById('pCategory');
        const pPrice = document.getElementById('pPrice');
        const pStock = document.getElementById('pStock');
        const pDesc  = document.getElementById('pDesc');

        if (pName)  pName.value  = product.name || '';
        if (pCat)   pCat.value   = product.category || '';
        if (pPrice) pPrice.value = product.price || 0;
        if (pStock) pStock.value = product.qty || 0;
        if (pDesc)  pDesc.value  = product.description || '';

        if (editIdInput) editIdInput.value = id;

        if (modalTitle) modalTitle.innerText = "Edit Product";
        if (modalBtn)   modalBtn.innerText   = "Save Changes";

        if (typeof openProductModal === 'function') {
            openProductModal();
        }
    };

    // Update Order Status via Laravel AJAX
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

    window.showTab = function(tabId, link) {
        document.querySelectorAll('.tab-pane').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
        const tab = document.getElementById(tabId);
        if (tab) tab.classList.add('active');
        if (link) link.classList.add('active');
    };

    const modal = document.getElementById('product-modal');
    window.openProductModal = () => {
        if (modalTitle && modalTitle.innerText !== "Edit Product") {
            if (addForm) addForm.reset();
            if (editIdInput) editIdInput.value = "";
        }
        if (modal) modal.classList.add('open');
    };
    window.closeProductModal = () => {
        if (modal) modal.classList.remove('open');
    };

    // =========================================
    // 6. CHARTS (كامِل – ما اتمسحش)
    // =========================================
    function initCharts() {
        const salesCanvas   = document.getElementById('salesChart');
        const catCanvas     = document.getElementById('categoryChart');
        const trafficCanvas = document.getElementById('trafficChart');

        // 1. Line Chart (Revenue)
        if (salesCanvas && window.Chart) {
            const ctx1 = salesCanvas.getContext('2d');
            let gradient = ctx1.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(37, 99, 235, 0.2)');
            gradient.addColorStop(1, 'rgba(37, 99, 235, 0.0)');

            new Chart(ctx1, {
                type: 'line',
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [{
                        label: 'Revenue',
                        data: [150, 230, 180, 320, 290, 450, 520],
                        borderColor: '#2563eb',
                        backgroundColor: gradient,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });
        }

        // 2. Polar Area Chart (Category Distribution)
        if (catCanvas && window.Chart) {
            new Chart(catCanvas.getContext('2d'), {
                type: 'polarArea',
                data: {
                    labels: ['Electronics', 'Fashion', 'Home & Living'],
                    datasets: [{
                        data: [18, 12, 7],
                        backgroundColor: [
                            'rgba(37, 99, 235, 0.7)',
                            'rgba(16, 185, 129, 0.7)',
                            'rgba(245, 158, 11, 0.7)'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        r: { ticks: { display: false }, grid: { display: false } }
                    },
                    plugins: {
                        legend: { position: 'right' }
                    }
                }
            });
        }

        // 3. Doughnut Chart (Traffic)
        if (trafficCanvas && window.Chart) {
            new Chart(trafficCanvas.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Social', 'Direct', 'Organic'],
                    datasets: [{
                        data: [35, 45, 20],
                        backgroundColor: ['#2563eb', '#64748b', '#93c5fd']
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });
        }
    }

    initCharts();

    // =========================================
    // 7. SIDEBAR SCRIPT (بسيط – لو عندك IDs غيّرها)
    // =========================================
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar       = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('open');
            if (sidebarOverlay) sidebarOverlay.classList.toggle('show');
        });
    }
    if (sidebarOverlay && sidebar) {
        sidebarOverlay.addEventListener('click', () => {
            sidebar.classList.remove('open');
            sidebarOverlay.classList.remove('show');
        });
    }

});
</script>

@endsection

@extends('layouts.app')
@section('title', __('Shipping'))

@section('style')
<style>
:root {
            --primary: #2563eb;
            --dark: #1f2937;
            --light-bg: #f9fafb;
            --white: #ffffff;
            --border: #e5e7eb;
        }

        body {
            background-color: var(--light-bg);
        }

        .shipping-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 3rem 20px;
        }

        /* --- Page Header --- */
        .shipping-header {
            text-align: center;
            margin-bottom: 3rem;
            background: linear-gradient(rgba(37, 99, 235, 0.9), rgba(30, 64, 175, 0.9)), url('https://via.placeholder.com/1200x300/111/fff?text=Logistics');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 4rem 1rem;
            border-radius: 12px;
        }

        .shipping-header h1 { font-size: 2.5rem; margin-bottom: 0.5rem; }
        .shipping-header p { font-size: 1.1rem; opacity: 0.9; }

        /* --- Shipping Rates Table --- */
        .rates-section {
            background: var(--white);
            padding: 2.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            margin-bottom: 3rem;
        }

        .section-title {
            color: var(--dark);
            margin-bottom: 1.5rem;
            padding-bottom: 10px;
            border-bottom: 2px solid #f3f4f6;
        }

        .shipping-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .shipping-table th {
            text-align: left;
            background: #f8fafc;
            padding: 15px;
            color: var(--dark);
            font-weight: 600;
        }

        .shipping-table td {
            padding: 15px;
            border-bottom: 1px solid var(--border);
            color: #4b5563;
        }

        .shipping-table tr:last-child td { border-bottom: none; }

        .free-badge {
            background-color: #dcfce7;
            color: #166534;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-left: 10px;
        }

        /* --- Process Cards --- */
        .process-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .process-card {
            background: var(--white);
            padding: 2rem;
            border-radius: 12px;
            text-align: center;
            border: 1px solid var(--border);
        }

        .process-icon {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .process-card h4 { color: var(--dark); margin-bottom: 0.5rem; }
        .process-card p { color: #6b7280; font-size: 0.9rem; }

        /* --- Info Grid (Restrictions etc) --- */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }

        .info-card {
            background: var(--white);
            padding: 2rem;
            border-radius: 12px;
        }

        .info-card h3 { color: var(--dark); margin-bottom: 1rem; font-size: 1.2rem; }
        .info-card ul { margin-left: 20px; color: #4b5563; }
        .info-card li { margin-bottom: 0.5rem; }

        @media (max-width: 768px) {
            .info-grid { grid-template-columns: 1fr; }
            .shipping-table { display: block; overflow-x: auto; }
        }
</style>
@endsection

@section('content')
<main class="shipping-container">

        <div class="shipping-header">
            <h1>Shipping & Delivery</h1>
            <p>Fast, reliable delivery to every doorstep in Egypt.</p>
        </div>

        <section class="process-grid">
            <div class="process-card">
                <i class="fa-solid fa-clipboard-check process-icon"></i>
                <h4>1. Order Processing</h4>
                <p>Orders are processed within 24 hours of confirmation.</p>
            </div>
            <div class="process-card">
                <i class="fa-solid fa-box process-icon"></i>
                <h4>2. Packing</h4>
                <p>Items are safely packed and handed to our courier partners.</p>
            </div>
            <div class="process-card">
                <i class="fa-solid fa-truck-fast process-icon"></i>
                <h4>3. Out for Delivery</h4>
                <p>You will receive an SMS/Call when the courier is nearby.</p>
            </div>
            <div class="process-card">
                <i class="fa-solid fa-house-chimney process-icon"></i>
                <h4>4. Delivered</h4>
                <p>Enjoy your purchase! You can pay Cash on Delivery.</p>
            </div>
        </section>

        <section class="rates-section">
            <h2 class="section-title">Shipping Rates & Timelines</h2>
            <p style="margin-bottom: 1rem; color: #6b7280;">Orders over <strong>1,000 EGP</strong> qualify for <span class="free-badge">FREE SHIPPING</span></p>

            <table class="shipping-table">
                <thead>
                    <tr>
                        <th>Region</th>
                        <th>Estimated Time</th>
                        <th>Standard Cost</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Greater Cairo & Giza</strong></td>
                        <td>1 - 2 Business Days</td>
                        <td>50 EGP</td>
                    </tr>
                    <tr>
                        <td><strong>Alexandria & Delta</strong></td>
                        <td>2 - 3 Business Days</td>
                        <td>60 EGP</td>
                    </tr>
                    <tr>
                        <td><strong>Canal Cities</strong> (Port Said, Suez, Ismailia)</td>
                        <td>2 - 3 Business Days</td>
                        <td>65 EGP</td>
                    </tr>
                    <tr>
                        <td><strong>Upper Egypt</strong> (Beni Suef to Aswan)</td>
                        <td>3 - 5 Business Days</td>
                        <td>80 EGP</td>
                    </tr>
                    <tr>
                        <td><strong>Red Sea & Sinai</strong></td>
                        <td>4 - 6 Business Days</td>
                        <td>95 EGP</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <section class="info-grid">
            <div class="info-card">
                <h3><i class="fa-solid fa-triangle-exclamation" style="color: #f59e0b; margin-right: 8px;"></i> Delivery Notes</h3>
                <ul>
                    <li>Orders placed after 2 PM will be processed the next business day.</li>
                    <li>Delivery times do not include Fridays or Public Holidays.</li>
                    <li>Please ensure your phone number is active so the courier can reach you.</li>
                </ul>
            </div>
            <div class="info-card">
                <h3><i class="fa-solid fa-globe" style="color: #2563eb; margin-right: 8px;"></i> International Shipping</h3>
                <p style="color: #4b5563; line-height: 1.6;">Currently, Matgar only ships within Egypt. We are working on expanding our services to Saudi Arabia and the UAE soon. Stay tuned!</p>
            </div>
        </section>

    </main>
@endsection
@section('script')
<script>
    document.addEventListener("DOMContentLoaded", function() {

        // =========================================
        // 1. INTERNAL HELPER: TOAST (The Pop-up)
        // =========================================
        function showToast(message, isSuccess = true) {
            // Try to find container, create if missing
            let toast = document.getElementById('toast-notification');
            if (!toast) {
                toast = document.createElement('div');
                toast.id = 'toast-notification';
                toast.className = 'toast-notification';
                document.body.appendChild(toast);
            }

            // Set Content
            toast.innerHTML = isSuccess
                ? `<i class="fa-solid fa-check-circle"></i> ${message}`
                : `<i class="fa-solid fa-circle-exclamation"></i> ${message}`;

            // Set Color
            if (isSuccess) {
                toast.classList.add('success');
                toast.style.backgroundColor = "#10b981"; // Green
            } else {
                toast.classList.remove('success');
                toast.style.backgroundColor = "#ef4444"; // Red
            }

            // Animation
            toast.classList.add('show');
            setTimeout(() => { toast.classList.remove('show'); }, 3000);
        }

        // =========================================
        // 2. DATA SOURCES
        // =========================================

        // Load Inventory from LocalStorage
        let inventoryData = JSON.parse(localStorage.getItem('siteProducts')) || [];

        // Mock Orders
        let ordersData = [
            { id: "#ORD-9921", customer: "Jane Doe", date: "Oct 24, 2025", total: 120.00, status: "Delivered" },
            { id: "#ORD-9922", customer: "Mike Ross", date: "Oct 25, 2025", total: 45.50, status: "Pending" },
            { id: "#ORD-9923", customer: "Rachel G.", date: "Oct 26, 2025", total: 299.99, status: "Shipped" }
        ];

        const topProducts = [
            { name: "Wireless Earbuds", sold: 1200, percent: 85 },
            { name: "Smart Watch", sold: 940, percent: 65 },
            { name: "Gaming Mouse", sold: 600, percent: 45 },
            { name: "USB-C Hub", sold: 320, percent: 25 }
        ];

        // Helper: Save Changes
        function saveInventory() {
            localStorage.setItem('siteProducts', JSON.stringify(inventoryData));
            renderInventory();
        }

        // =========================================
        // 3. RENDER FUNCTIONS
        // =========================================

        // --- Render Inventory ---
        window.renderInventory = function() {
            const tbody = document.getElementById('inventoryTableBody');
            const filterCat = document.getElementById('filterCategory') ? document.getElementById('filterCategory').value : 'all';
            if(!tbody) return;
            tbody.innerHTML = "";

            inventoryData.forEach(item => {
                if (filterCat !== 'all' && item.category !== filterCat) return;

                const qty = item.qty || 0;
                let stockBadge = qty > 10 ? 'success' : (qty > 0 ? 'warning' : 'danger');
                let stockText = qty > 0 ? 'Active' : 'Out of Stock';

                const row = `
                    <tr>
                        <td style="display:flex; gap:10px; align-items:center;">
                            <div class="tbl-img bg-gray"><img src="${item.img || ''}" onerror="this.src='https://via.placeholder.com/50'" style="width:100%; height:100%; object-fit:cover;"></div>
                            <div><strong>${item.name}</strong><br><small style="color:#888;">ID: #${item.id}</small></div>
                        </td>
                        <td>${item.category}</td>
                        <td>$${parseFloat(item.price).toFixed(2)}</td>
                        <td><span style="font-weight:bold; color:${qty < 5 ? '#ef4444' : '#333'}">${qty} Units</span></td>
                        <td><span class="badge ${stockBadge}">${stockText}</span></td>
                        <td>
                            <button class="btn-xs edit" onclick="editProduct(${item.id})"><i class="fa-solid fa-pen"></i></button>
                            <button class="btn-xs" style="color:red;" onclick="deleteProduct(${item.id})"><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>`;
                tbody.innerHTML += row;
            });
        };

        // --- Render Orders ---
        window.renderOrders = function() {
            const tbody = document.getElementById('ordersTableBody');
            const filterStat = document.getElementById('filterStatus') ? document.getElementById('filterStatus').value : 'all';
            if(!tbody) return;
            tbody.innerHTML = "";

            ordersData.forEach(order => {
                if (filterStat !== 'all' && order.status !== filterStat) return;
                let badgeColor = order.status === 'Delivered' ? 'success' : (order.status === 'Shipped' ? 'blue' : 'warning');

                tbody.innerHTML += `
                    <tr>
                        <td>${order.id}</td> <td>${order.customer}</td> <td>${order.date}</td> <td>$${order.total}</td>
                        <td><span class="badge ${badgeColor}">${order.status}</span></td>
                        <td>
                            <select class="search-sm" style="width:100px; padding:5px;" onchange="updateOrderStatus('${order.id}', this.value)">
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
            if(!container) return;
            container.innerHTML = "";

            topProducts.forEach(prod => {
                container.innerHTML += `
                    <div>
                        <div style="display:flex; justify-content:space-between; font-size:0.9rem; font-weight:600; margin-bottom:5px;">
                            <span>${prod.name}</span> <span style="color:#64748b;">${prod.sold} sold</span>
                        </div>
                        <div style="width:100%; height:8px; background:#f1f5f9; border-radius:10px; overflow:hidden;">
                            <div style="height:100%; width:${prod.percent}%; background:linear-gradient(90deg, #2563eb, #3b82f6);"></div>
                        </div>
                    </div>`;
            });
        };

        // Initial Load
        renderInventory();
        renderOrders();
        renderAnalytics();
        initCharts();

        // =========================================
        // 4. ACTIONS (Add / Edit / Settings)
        // =========================================

        // Add/Edit Product Form
        const addForm = document.getElementById('addProductForm');
        const editIdInput = document.getElementById('editProductId');
        const modalTitle = document.querySelector('.modal-header h3');
        const modalBtn = document.getElementById('modalSubmitBtn');

        if(addForm) {
            addForm.addEventListener('submit', (e) => {
                e.preventDefault();

                const name = document.getElementById('pName').value;
                const category = document.getElementById('pCategory').value;
                const price = parseFloat(document.getElementById('pPrice').value);
                const qty = parseInt(document.getElementById('pStock').value);
                const desc = document.getElementById('pDesc').value;
                const editId = editIdInput.value;

                if (editId) {
                    const product = inventoryData.find(p => p.id == editId);
                    if(product) {
                        product.name = name; product.category = category; product.price = price;
                        product.qty = qty; product.description = desc;
                        showToast("Product Updated Successfully!");
                    }
                } else {
                    const newItem = {
                        id: Math.floor(Math.random() * 100000),
                        name: name, category: category, price: price, qty: qty, description: desc,
                        oldPrice: price * 1.2, rating: 0, badge: "New", img: "https://via.placeholder.com/150"
                    };
                    inventoryData.unshift(newItem);
                    showToast("Product Added Successfully!");
                }
                saveInventory();
                closeProductModal();
            });
        }

        // Settings Form
        const storeForm = document.getElementById('storeForm');
        if(storeForm) {
            // Load Saved
            const savedConfig = JSON.parse(localStorage.getItem('storeConfig'));
            if (savedConfig) {
                document.getElementById('storeName').value = savedConfig.name || "";
                document.getElementById('storeEmail').value = savedConfig.email || "";
            }

            storeForm.addEventListener('submit', (e) => {
                e.preventDefault();
                const btn = storeForm.querySelector('button');
                const originalText = btn.innerHTML;
                btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';

                const config = {
                    name: document.getElementById('storeName').value,
                    email: document.getElementById('storeEmail').value,
                };
                localStorage.setItem('storeConfig', JSON.stringify(config));

                setTimeout(() => {
                    btn.innerHTML = originalText;
                    showToast("Store Settings Saved!", true);
                    document.querySelector('.profile-info h3').innerText = config.name;
                }, 800);
            });
        }

        // =========================================
        // 5. GLOBAL UI FUNCTIONS
        // =========================================

        window.deleteProduct = function(id) {
            if(confirm("Delete this product?")) {
                inventoryData = inventoryData.filter(p => p.id !== id);
                saveInventory();
                showToast("Product Deleted", false);
            }
        };

        window.editProduct = function(id) {
            const product = inventoryData.find(p => p.id === id);
            if(!product) return;
            document.getElementById('pName').value = product.name;
            document.getElementById('pCategory').value = product.category;
            document.getElementById('pPrice').value = product.price;
            document.getElementById('pStock').value = product.qty || 0;
            document.getElementById('pDesc').value = product.description || "";
            editIdInput.value = id;
            modalTitle.innerText = "Edit Product";
            modalBtn.innerText = "Save Changes";
            openProductModal();
        };

        window.updateOrderStatus = function(id, newStatus) {
            const order = ordersData.find(o => o.id === id);
            if(order) {
                order.status = newStatus;
                renderOrders();
                showToast(`Order ${id} marked as ${newStatus}`);
            }
        };

        window.showTab = function(tabId, link) {
            document.querySelectorAll('.tab-pane').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
            document.getElementById(tabId).classList.add('active');
            if(link) link.classList.add('active');
        };

        const modal = document.getElementById('product-modal');
        window.openProductModal = () => {
            if (modalTitle.innerText !== "Edit Product") {
                addForm.reset(); editIdInput.value = "";
            }
            modal.classList.add('open');
        };
        window.closeProductModal = () => modal.classList.remove('open');

        // =========================================
        // 6. CHARTS
        // =========================================
        function initCharts() {
            const salesC = document.getElementById('salesChart');
            const catC = document.getElementById('categoryChart');
            const trafficC = document.getElementById('trafficChart');

            if (salesC) {
                new Chart(salesC.getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                        datasets: [{ label: 'Revenue', data: [150, 230, 180, 320, 290, 450, 500], borderColor: '#2563eb', fill: false }]
                    },
                    options: { responsive: true, maintainAspectRatio: false }
                });
            }
            if (catC) {
                new Chart(catC.getContext('2d'), {
                    type: 'polarArea',
                    data: {
                        labels: ['Electronics', 'Fashion', 'Home', 'Beauty', 'Sports'],
                        datasets: [{ data: [12, 19, 3, 5, 2], backgroundColor: ['#2563eb', '#3b82f6', '#10b981', '#f59e0b', '#ef4444'] }]
                    },
                    options: { responsive: true, maintainAspectRatio: false, scales: { r: { ticks: { display: false } } }, plugins: { legend: { position: 'right' } } }
                });
            }
            if (trafficC) {
                new Chart(trafficC.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Social', 'Direct', 'Organic'],
                        datasets: [{ data: [35, 45, 20], backgroundColor: ['#2563eb', '#64748b', '#93c5fd'] }]
                    },
                    options: { responsive: true, maintainAspectRatio: false }
                });
            }
        }
    // =========================================
    // 7. INITIALIZE CHARTS
    // =========================================
    function initCharts() {
        const salesCanvas = document.getElementById('salesChart');
        const catCanvas = document.getElementById('categoryChart'); // Updated ID
        const trafficCanvas = document.getElementById('trafficChart');

        // 1. Line Chart (Revenue)
        if (salesCanvas) {
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

        // 2. Polar Area Chart (Category Distribution) - UPDATED
        if (catCanvas) {
            new Chart(catCanvas.getContext('2d'), {
                type: 'polarArea',
                data: {
                    labels: ['Electronics', 'Fashion', 'Home & Living'], // New Labels
                    datasets: [{
                        data: [18, 12, 7], // Mock Data (Items sold per category)
                        backgroundColor: [
                            'rgba(37, 99, 235, 0.7)',  // Blue
                            'rgba(16, 185, 129, 0.7)', // Green
                            'rgba(245, 158, 11, 0.7)'  // Orange
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        r: { ticks: { display: false }, grid: { display: false } } // Hide ugly circular lines
                    },
                    plugins: {
                        legend: { position: 'right' }
                    }
                }
            });
        }

        // 3. Doughnut Chart (Traffic)
        if (trafficCanvas) {
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

        renderInventory();
        renderOrders();
        renderAnalytics();
        initCharts();
    });
</script>
@endsection

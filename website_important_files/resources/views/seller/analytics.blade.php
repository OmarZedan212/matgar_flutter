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
</style>
@endsection

@section('content')
<div class="main-container">
    @include('layouts.partials.seller-sidebar')

    <main class="content-wrapper">
        <header class="content-header"><h2>Performance Analytics</h2></header>

        <div class="charts-grid">
            <div class="chart-card">
                <h3>Top Selling Products</h3>
                <div id="topProductsContainer" style="margin-top:20px; display:flex; flex-direction:column; gap:15px;">
                </div>
            </div>
            <div class="chart-card">
                <h3>Category Distribution</h3>
                <div style="height:250px; width:100%;">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/chart.js') }}"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const topProducts = window.topProducts || [
        { name: "Wireless Earbuds", sold: 1200, percent: 85 },
        { name: "Smart Watch",      sold: 940,  percent: 65 },
        { name: "Gaming Mouse",     sold: 600,  percent: 45 },
        { name: "USB-C Hub",        sold: 320,  percent: 25 }
    ];

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

    function initCategoryChart() {
        const catCanvas = document.getElementById('categoryChart');
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
    }

    renderAnalytics();
    initCategoryChart();
});
</script>
@endsection

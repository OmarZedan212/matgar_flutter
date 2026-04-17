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
.content-wrapper {
  width: 100%;
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
        <header class="content-header">
            <h2>Store Overview</h2>
        </header>

        <div class="stats-grid">
    <div class="stat-card">
        <div class="icon-bg blue"><i class="fa-solid fa-dollar-sign"></i></div>
        <div>
            <h4>Total Revenue</h4>
            <span class="stat-num">
                ${{ number_format($totalRevenue ?? 0, 2) }}
            </span>
        </div>
    </div>

    <div class="stat-card">
        <div class="icon-bg orange"><i class="fa-solid fa-box"></i></div>
        <div>
            <h4>Total Orders</h4>
            <span class="stat-num">
                {{ number_format($totalOrders ?? 0) }}
            </span>
        </div>
    </div>

    <div class="stat-card">
        <div class="icon-bg green"><i class="fa-solid fa-users"></i></div>
        <div>
            <h4>Products</h4>
            <span class="stat-num">
                {{ number_format($totalProducts ?? 0) }}
            </span>
        </div>
    </div>
</div>


        <div class="chart-card">
            <h3>Revenue (This Week)</h3>
            <div style="height:300px; width:100%;">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
    </main>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/chart.js') }}"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const salesCanvas = document.getElementById('salesChart');
    if (salesCanvas && window.Chart) {
        const ctx1 = salesCanvas.getContext('2d');
        let gradient = ctx1.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(37, 99, 235, 0.2)');
        gradient.addColorStop(1, 'rgba(37, 99, 235, 0.0)');

        const labels = @json($salesLabels ?? []);
        const data   = @json($salesData ?? []);

        new Chart(ctx1, {
            type: 'line',
            data: {
                labels: labels,          // ['Mon', 'Tue', ...]
                datasets: [{
                    label: 'Revenue',
                    data: data,          // [150, 230, ...]
                    borderColor: '#2563eb',
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
});
</script>
@endsection

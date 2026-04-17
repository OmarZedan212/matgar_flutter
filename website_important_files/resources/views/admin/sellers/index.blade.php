@extends('layouts.seller')
@section('title', __('Sellers'))

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
  --shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
}
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  font-family: "Poppins", sans-serif;
}

/* Global */
body {
  background-color: var(--bg-body);
  color: var(--text-main);
  line-height: 1.5;
  font-family: "Poppins", sans-serif;
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
/* Table Styles */
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
  padding: 15px 20px;
  background: #f8fafc;
  font-size: 0.75rem;
  text-transform: uppercase;
  color: var(--text-muted);
  border-bottom: 1px solid var(--border);
}

.pro-table td {
  padding: 15px 20px;
  border-bottom: 1px solid #f1f5f9;
  font-size: 0.9rem;
}

.badge {
  padding: 4px 10px;
  border-radius: 12px;
  font-size: 0.75rem;
  font-weight: 600;
}


.btn-xs {
  padding: 6px 12px;
  border-radius: 6px;
  border: 1px solid var(--border);
  background: white;
  cursor: pointer;
  font-size: 0.8rem;
}

.btn-xs.edit { color: var(--primary); border-color: var(--primary); }
.btn-xs.delete { color: var(--danger); border-color: var(--danger); }
.btn-xs.approve { color: var(--success); border-color: var(--success); }

.content-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 25px;
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
.badge.pending {
    background: #e5e7eb; /* light gray background */
    color: #6b7280;      /* gray text */
}
.badge.approved {
    background: #d1fae5; /* light green background */
    color: #059669;      /* green text */
}
/* Target the table cells and headers */
table th, table td {
    text-align: center !important;   /* Centers text/buttons horizontally */
    vertical-align: middle !important; /* Centers content vertically */
}

</style>
@endsection


@section('content')
<div class="main-container">

    {{-- Sidebar --}}
    @include('layouts.partials.admin-sidebar')

    <main class="content-wrapper">

        <header class="content-header">
            <h2>Sellers</h2>
        </header>

        <div class="table-container">

            @if(session('success'))
                <div style="padding:15px; background:#ecfdf5; margin:10px; border-radius:8px; color:#059669; font-weight:600;">
                    {{ session('success') }}
                </div>
            @endif

            <table class="pro-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th style="width:180px;">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($sellers as $seller)
                        <tr>
                            <td>{{ $seller->user_id }}</td>
                            <td>{{ $seller->shop_name }}</td>
                            <td>{{ $seller->business_email }}</td>
                            <td>{{ $seller->support_phone }}</td>
                            <td>
                                {{-- Status badge --}}
                                <span class="badge {{ $seller->approved ? 'approved' : 'pending' }}">
                                    {{ $seller->approved ? 'Approved' : 'Pending' }}
                                </span>
                            </td>

                            

                        <td> 
                            {{-- Approve button: only show if NOT approved --}}       
                            @if(!$seller->approved)
                                <form action="{{ route('admin.sellers.approve', $seller->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn-xs approve">
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                </form>
                            @endif
                            {{-- Edit --}}
                            <a href="{{ route('admin.sellers.edit', $seller->id) }}"class="btn btn-sm btn-primary">
                                <button class="btn-xs edit" onclick="editCategory(${cat.id})">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                            </a>

                            {{-- Delete --}}
                            <form action="{{ route('admin.sellers.destroy', $seller->id) }}"
                                    method="POST"
                                    style="display:inline-block;"
                                    onsubmit="return confirm('Delete this seller?');">
                                @csrf
                                @method('DELETE')
                        <button class="btn-xs" style="color:red;" onclick="deleteCategory(${cat.id})">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                            </form>

                        </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center; padding:20px; color:var(--text-muted);">
                                No sellers found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

        <div style="margin-top:20px;">
            {{ $sellers->links() }}
        </div>

    </main>
</div>
@endsection


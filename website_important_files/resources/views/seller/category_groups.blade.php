@extends('layouts.seller')
@section('title', __('Category Groups'))

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
.badge.success { background: #ecfdf5; color: #059669; }
.badge.warning { background: #fffbeb; color: #d97706; }
.badge.danger { background: #fef2f2; color: #dc2626; }
.btn-primary {
  background: var(--primary);
  color: white;
  padding: 10px 25px;
  border-radius: var(--radius);
  border: none;
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
.modal-overlay.open { display: flex; }
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
.input-group { margin-bottom: 20px; }
.input-group label {
  display: block;
  margin-bottom: 8px;
  font-size: 0.9rem;
  font-weight: 600;
}
.row {
  display: grid;
  grid-template-columns: 1fr 1fr 1.2fr;
  gap: 20px;
}
input, select, textarea {
  width: 100%;
  padding: 10px;
  border: 1px solid var(--border);
  border-radius: var(--radius);
  outline: none;
}
.form-actions {
  display:flex;
  justify-content:flex-end;
  gap:10px;
  margin-top:20px;
}
.btn-secondary {
  background: white;
  border: 1px solid var(--border);
  padding: 10px 25px;
  border-radius: var(--radius);
  cursor: pointer;
}
</style>
@endsection

@section('content')
<div class="main-container">
    @include('layouts.partials.seller-sidebar')

    <main class="content-wrapper">
        <header class="content-header">
            <h2>Category Groups</h2>
            <button class="btn-primary" onclick="openGroupModal()">+ Add Group</button>
        </header>

        <div class="table-container">
            <table class="pro-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Categories</th>
                        <th>Status</th>
                        <th style="width:140px;">Action</th>
                    </tr>
                </thead>
                <tbody id="groupsTableBody"></tbody>
            </table>
        </div>
    </main>
</div>

<div id="group-modal" class="modal-overlay">
    <div class="modal-box">
        <header class="modal-header">
            <h3 id="groupModalTitle">Add Group</h3>
            <button class="close-modal" onclick="closeGroupModal()">&times;</button>
        </header>

        <form id="groupForm">
            @csrf
            <input type="hidden" id="groupId" name="id">

            <div class="input-group">
                <label>Group Name</label>
                <input type="text" id="groupName" name="name" required>
            </div>

            <div class="input-group">
                <label>Slug</label>
                <input type="text" id="groupSlug" name="slug" placeholder="electronics">
            </div>

            <div class="input-group">
                <label>Status</label>
                <select id="groupStatus" name="status">
                    <option value="active" selected>Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <div class="form-actions">
                <button type="button" class="btn-secondary" onclick="closeGroupModal()">Cancel</button>
                <button type="submit" class="btn-primary" id="groupSubmitBtn">Add</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

    // Toast
    window.showToast = function (message, isSuccess = true) {
        let toast = document.getElementById('toast-notification');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'toast-notification';
            toast.className = 'toast-notification';
            document.body.appendChild(toast);
        }
        toast.innerHTML = (isSuccess
            ? '<i class="fa-solid fa-check-circle"></i> '
            : '<i class="fa-solid fa-circle-exclamation"></i> ') + message;
        toast.style.backgroundColor = isSuccess ? "#10b981" : "#ef4444";
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 3000);
    };

    let groupsData = @json($groups ?? []);

    window.renderGroups = function () {
        const tbody = document.getElementById('groupsTableBody');
        if (!tbody) return;
        tbody.innerHTML = '';

        groupsData.forEach(g => {
            const statusBadge = g.status === 'active' ? 'success' : 'danger';
            const statusText  = g.status === 'active' ? 'Active' : 'Inactive';

            tbody.innerHTML += `
                <tr>
                    <td>${g.name ?? ''}</td>
                    <td>${g.slug ?? ''}</td>
                    <td>${g.categories_count ?? 0}</td>
                    <td><span class="badge ${statusBadge}">${statusText}</span></td>
                    <td>
                        <button class="btn-xs edit" onclick="editGroup(${g.id})">
                            <i class="fa-solid fa-pen"></i>
                        </button>
                        <button class="btn-xs" style="color:red;" onclick="deleteGroup(${g.id})">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
        });
    };

    renderGroups();

    const modal        = document.getElementById('group-modal');
    const groupForm    = document.getElementById('groupForm');
    const groupIdInput = document.getElementById('groupId');
    const nameInput    = document.getElementById('groupName');
    const slugInput    = document.getElementById('groupSlug');
    const statusSelect = document.getElementById('groupStatus');
    const modalTitle   = document.getElementById('groupModalTitle');
    const submitBtn    = document.getElementById('groupSubmitBtn');

    window.openGroupModal = function () {
        if (groupForm) groupForm.reset();
        if (groupIdInput) groupIdInput.value = '';
        if (modalTitle) modalTitle.textContent = 'Add Group';
        if (submitBtn) submitBtn.textContent = 'Add';
        if (modal) modal.classList.add('open');
    };

    window.closeGroupModal = function () {
        if (modal) modal.classList.remove('open');
    };

    window.editGroup = function (id) {
        const g = groupsData.find(x => x.id == id);
        if (!g) return;

        if (groupIdInput) groupIdInput.value = g.id;
        if (nameInput)    nameInput.value    = g.name ?? '';
        if (slugInput)    slugInput.value    = g.slug ?? '';
        if (statusSelect) statusSelect.value = g.status ?? 'active';

        if (modalTitle) modalTitle.textContent = 'Edit Group';
        if (submitBtn)  submitBtn.textContent  = 'Save';
        if (modal) modal.classList.add('open');
    };

    if (groupForm) {
        groupForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const isEdit = !!groupIdInput.value;
            const formData = $(groupForm).serialize();
            const url = isEdit
                ? "{{ route('admin.category_groups.update') }}"
                : "{{ route('admin.category_groups.store') }}";

            const btn = submitBtn;
            const originalText = btn ? btn.innerHTML : '';
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = isEdit ? 'Saving...' : 'Adding...';
            }

            $.ajax({
                url: url,
                method: "POST",
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                success: function (res) {
                    if (res.group) {
                        const g = res.group;
                        const mapped = {
                            id: g.id,
                            name: g.name,
                            slug: g.slug,
                            status: g.status ?? 'active',
                            categories_count: g.categories_count ?? 0,
                        };
                        const idx = groupsData.findIndex(x => x.id == mapped.id);
                        if (idx !== -1) {
                            groupsData[idx] = mapped;
                        } else {
                            groupsData.unshift(mapped);
                        }
                    }
                    renderGroups();
                    showToast(isEdit ? 'Group updated successfully' : 'Group added successfully', true);
                    closeGroupModal();
                },
                error: function (xhr) {
                    if (xhr.status === 422 && xhr.responseJSON?.errors) {
                        let messages = [];
                        Object.values(xhr.responseJSON.errors).forEach(arr => {
                            messages = messages.concat(arr);
                        });
                        alert(messages.join("\n"));
                    } else {
                        showToast('Failed to save group', false);
                    }
                },
                complete: function () {
                    if (btn) {
                        btn.disabled = false;
                        btn.innerHTML = originalText;
                    }
                }
            });
        });
    }

    window.deleteGroup = function (id) {
        if (!confirm('Delete this group?')) return;

        $.ajax({
            url: "{{ route('admin.category_groups.delete') }}",
            method: "POST",
            data: {
                id: id,
                _method: 'DELETE',
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            success: function (res) {
                if (res.success === false && res.message) {
                    showToast(res.message, false);
                    return;
                }
                groupsData = groupsData.filter(x => x.id != id);
                renderGroups();
                showToast('Group deleted', false);
            },
            error: function () {
                showToast('Failed to delete group', false);
            }
        });
    };
});
</script>
@endsection

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
.btn-primary {
  background: var(--primary);
  color: white;
  padding: 10px 25px;
  border-radius: var(--radius);
  border: none;
  cursor: pointer;
}
</style>
@endsection

@section('content')


<div class="main-container">
        @include('layouts.partials.admin-sidebar')

    <main class="content-wrapper">
        <header class="content-header">
            <h2>Store Configuration</h2>
        </header>

        <div class="form-card">
            <form id="storeForm">
                @csrf
                <h4 style="margin-bottom:15px; color:#2c3e50; border-bottom:1px solid #eee; padding-bottom:10px;">
                    <i class="fa-solid fa-store"></i> General Information
                </h4>

                <div class="row">
                    <div class="input-group">
                        <label>Store Name</label>
                        <input
                            type="text"
                            id="storeName"
                            name="shop_name"
                            value="{{ old('shop_name',  $seller->shop_name) }}"
                            required
                        >
                    </div>
                </div>

                <div class="input-group">
                    <label>Store Description</label>
                    <textarea
                        id="storeDesc"
                        name="description"
                        rows="3"
                    >{{ old('description',  $seller->description) }}</textarea>
                </div>

                <h4 style="margin:25px 0 15px; color:#2c3e50; border-bottom:1px solid #eee; padding-bottom:10px;">
                    <i class="fa-solid fa-address-book"></i> Contact Details
                </h4>

                <div class="row">
                    <div class="input-group">
                        <label>Business Email</label>
                        <input
                            type="email"
                            id="storeEmail"
                            name="business_email"
                            value="{{ old('business_email', $seller->business_email ) }}"
                            required
                        >
                    </div>
                    <div class="input-group">
                        <label>Support Phone</label>
                        <input
                            type="tel"
                            id="storePhone"
                            name="support_phone"
                            value="{{ old('support_phone', $seller->support_phone) }}"
                        >
                    </div>
                </div>

                <div class="input-group">
                    <label>Physical Address</label>
                    <input
                        type="text"
                        id="storeAddress"
                        name="address"
                        value="{{ old('address', $seller->address) }}"
                    >
                </div>

                <h4 style="margin:25px 0 15px; color:#2c3e50; border-bottom:1px solid #eee; padding-bottom:10px;">
                    <i class="fa-solid fa-share-nodes"></i> Social Links
                </h4>

                <div class="row">
                    <div class="input-group">
                        <label>Facebook Page</label>
                        <input
                            type="url"
                            id="storeFb"
                            name="facebook_page"
                            value="{{ old('facebook_page', $seller->facebook_page) }}"
                            placeholder="https://facebook.com/yourstore"
                        >
                    </div>
                    <div class="input-group">
                        <label>Instagram Profile</label>
                        <input
                            type="url"
                            id="storeInsta"
                            name="instagram_profile"
                            value="{{ old('instagram_profile', $seller->instagram_profile ) }}"
                            placeholder="https://instagram.com/yourstore"
                        >
                    </div>
                </div>
                <div class="form-group form-check mt-3">
                    <input type="checkbox"
                        name="approved"
                        id="approved"
                        class="form-check-input"
                        {{ old('approved', $seller->approved) ? 'checked' : '' }}>
                    <label class="form-check-label" for="approved">
                        Approved
                    </label>
                </div>
                <div class="form-actions" style="margin-top:30px;">
                    <button class="btn-primary" type="submit" style="padding:12px 30px; font-size:1rem;">
                        
                        <i class="fa-solid fa-save"></i> Update Seller Data
                        
                    </button>
                </div>
            </form>
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
                url: "{{ route('admin.sellers.update', $seller->id) }}",
                method: "PUT",
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                success: function(res) {
                  @if(optional($seller)->approved)
                  showToast("Store Settings Saved!", true);
                        @elseif($hasSeller)
                    showToast("Request Data Updated!", true);
                    @else
                    showToast("Request Sent!", true);
                    @endif

                    const storeName = res.store_name
                        || document.getElementById('storeName')?.value
                        || '';

                    const profileTitle = document.querySelector('.profile-info h3');
                    if (profileTitle && storeName) {
                        profileTitle.innerText = storeName;
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422 && xhr.responseJSON?.errors) {
                        let messages = [];
                        Object.values(xhr.responseJSON.errors).forEach(arr => {
                            messages = messages.concat(arr);
                        });
                        alert(messages.join("\n"));
                    } else {
                        showToast("Failed to save store settings", false);
                    }
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
});
</script>
@endsection

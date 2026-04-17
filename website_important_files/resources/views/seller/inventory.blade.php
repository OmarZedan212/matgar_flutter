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
  width: 220px;
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
                        <th>Cost</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="inventoryTableBody">
                </tbody>
            </table>
        </div>
    </main>
</div>

<div id="product-modal" class="modal-overlay">
    <div class="modal-box">
        <header class="modal-header">
            <h3>Add New Product</h3>
            <button class="close-modal" onclick="closeProductModal()">&times;</button>
        </header>

        <form id="addProductForm" enctype="multipart/form-data">
            @csrf
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
                    <label>Cost ($)</label>
                    <input type="number" id="pCost" name="cost" required placeholder="0.00" step="0.01">
                </div>
                <div class="input-group">
                    <label>Stock Quantity</label>
                    <input type="number" id="pStock" name="qty" required placeholder="10">
                </div>
                <div class="input-group">
                    <label>Category</label>
                    <select id="pCategory" name="category_id"
                            style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                        <option value="" disabled selected>Select a Category</option>
                        @foreach($category_groups as $cat_group)
                        <optgroup label="{{$cat_group->name}}">
                            @foreach($cat_group->categories as $cat)
                            <option value="{{$cat->id}}">{{$cat->name}}</option>
                            @endforeach
                        </optgroup>
                        @endforeach

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

    let inventoryData = @json($inventoryData);

    window.renderInventory = function() {
        const tbody = document.getElementById('inventoryTableBody');
        const filterCatEl = document.getElementById('filterCategory');
        const filterCat = filterCatEl ? filterCatEl.value : 'all';

        if (!tbody) return;
        tbody.innerHTML = "";
        inventoryData.forEach(item => {
            const catId = item.category_id != null ? String(item.category_id) : null;

            if (filterCat !== 'all' && catId !== filterCat) return;

            const qty = item.qty || 0;
            let stockBadge = qty > 10 ? 'success' : (qty > 0 ? 'warning' : 'danger');
            let stockText = qty > 0 ? 'Active' : 'Out of Stock';
            const imgSrc = item.image_path ? "{{ asset('storage') }}/" + item.image_path : '';
            const cat = item.category? item.category.name : '';

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
                    <td>${cat}</td>
                    <td>$${parseFloat(item.price || 0).toFixed(2)}</td>
                    <td>$${parseFloat(item.cost || 0).toFixed(2)}</td>
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

    window.upsertProductFromServer = function(product) {
        if (!product) return;

        const mapped = {
            id:          product.id,
            name:        product.name,
            category_id:  product.category_id ?? (product.category ? product.category.id : null),
            category:     product.category || null,
            price:       product.price,
            cost:       product.cost,
            qty:       product.qty ?? product.quantity ?? 0,
            description: product.description || '',
            image_path:  product.image_path || ''
        };

        const index = inventoryData.findIndex(p => p.id == mapped.id);
        if (index !== -1) {
            inventoryData[index] = mapped;
        } else {
            inventoryData.unshift(mapped);
        }
        renderInventory();
    };

    renderInventory();

    const addForm       = document.getElementById('addProductForm');
    const editIdInput   = document.getElementById('editProductId');
    const modalTitle    = document.querySelector('.modal-header h3');
    const modalBtn      = document.getElementById('modalSubmitBtn');
    const imageUploadBox = document.getElementById('imageUploadBox');
    const pImageInput    = document.getElementById('pImage');

    if (imageUploadBox && pImageInput) {
        imageUploadBox.addEventListener('click', () => pImageInput.click());
        pImageInput.addEventListener('change', () => {
            if (pImageInput.files && pImageInput.files[0]) {
                imageUploadBox.querySelector('p').textContent = pImageInput.files[0].name;
            }
        });
    }

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
                    closeProductModal();
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

    window.deleteProduct = function(id) {
        if (!confirm("Delete this product?")) return;

        $.ajax({
            url: "{{ route('seller.delete_product', '') }}/" + id,
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
                renderInventory();
                showToast("Product Deleted", false);
            },
            error: function() {
                showToast("Failed to delete product", false);
            }
        });
    };

    window.editProduct = function(id) {
        const product = inventoryData.find(p => p.id == id);
        if (!product) return;

        const pName  = document.getElementById('pName');
        const pCat   = document.getElementById('pCategory');
        const pPrice = document.getElementById('pPrice');
        const pCost = document.getElementById('pCost');
        const pStock = document.getElementById('pStock');
        const pDesc  = document.getElementById('pDesc');

        if (pName)  pName.value  = product.name || '';
        if (pCat)   pCat.value   = product.category_id || '';
        if (pPrice) pPrice.value = product.price || 0;
        if (pCost) pCost.value = product.cost || 0;
        if (pStock) pStock.value = product.qty || 0;
        if (pDesc)  pDesc.value  = product.description || '';

        if (editIdInput) editIdInput.value = id;

        if (modalTitle) modalTitle.innerText = "Edit Product";
        if (modalBtn)   modalBtn.innerText   = "Save Changes";

        openProductModal();
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
});
</script>
@endsection

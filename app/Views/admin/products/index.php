<?= $this->extend('layout/admin_layout') ?>

<?= $this->section('content') ?>
    <!-- HEADER SECTION -->
    <div class="dv-header animate__animated animate__fadeIn">
        <div>
            <span class="sub-label">Inventory Management</span>
            <h1 style="font-family: 'Playfair Display', serif; color: #fff;">Product Catalog</h1>
        </div>
        <button class="btn-prime" onclick="openModal()">
            <i class="fas fa-plus"></i> &nbsp; Enroll New Artifact
        </button>
    </div>

    <!-- DATA TABLE -->
    <section class="data-vault animate__animated animate__fadeInUp">
        <table>
            <thead>
                <tr>
                    <th>Artifact</th>
                    <th>Valuation</th>
                    <th>Inventory</th>
                    <th>State</th>
                    <th style="text-align: right;">Authorization</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($products)): foreach($products as $p): ?>
                <tr>
                    <td data-label="Artifact">
                        <div class="user-flex">
                            <div class="avatar-box" style="border-radius: 12px; width: 55px; height: 55px; border: 1px solid var(--border);">
                                <?php
                                if (!empty($p['image'])) {

                                    // 1️⃣ Jika image berupa URL
                                    if (filter_var($p['image'], FILTER_VALIDATE_URL)) {
                                        $imagePath = $p['image'];
                                    }

                                    // 2️⃣ Jika image file lokal
                                    elseif (file_exists(FCPATH . 'uploads/products/' . $p['image'])) {
                                        $imagePath = base_url('uploads/products/' . $p['image']);
                                    }

                                    // 3️⃣ Jika path rusak
                                    else {
                                        $imagePath = 'https://ui-avatars.com/api/?name=' . urlencode($p['name']) . '&background=0d0d0d&color=f5deb3&bold=true';
                                    }

                                } else {
                                    // 4️⃣ Jika kosong
                                    $imagePath = 'https://ui-avatars.com/api/?name=' . urlencode($p['name']) . '&background=0d0d0d&color=f5deb3&bold=true';
                                }
                                ?>
                                <img src="<?= $imagePath ?>" alt="Artifact" style="width:100%; height:100%; object-fit:cover;">
                            </div>
                            <div style="text-align: left;">
                                <strong style="display: block; color: #fff; font-size: 15px;"><?= esc($p['name']) ?></strong>
                                <span style="font-size: 10px; color: var(--gold-dim);">ID: #<?= $p['id'] ?></span>
                            </div>
                        </div>
                    </td>
                    <td data-label="Valuation">
                        <span style="color: var(--gold); font-weight: 600;">Rp <?= number_format($p['price'], 0, ',', '.') ?></span>
                    </td>
                    <td data-label="Inventory">
                        <span style="color: #eee; opacity: 0.8;"><?= $p['stock'] ?> Units</span>
                    </td>
                    <td data-label="State">
                        <?php if($p['status'] == 'available'): ?>
                            <span class="badge badge-admin" style="background: rgba(46, 204, 113, 0.1); color: #2ecc71; border: 1px solid rgba(46, 204, 113, 0.2);">AVAILABLE</span>
                        <?php else: ?>
                            <span class="badge badge-customer" style="background: rgba(231, 76, 60, 0.1); color: #e74c3c; border: 1px solid rgba(231, 76, 60, 0.2);">SOLD OUT</span>
                        <?php endif; ?>
                    </td>
                    <td data-label="Authorization">
                        <div style="display: flex; gap: 8px; justify-content: flex-end;">
                            <button class="btn-icon" title="Modify" onclick="editProduct(<?= htmlspecialchars(json_encode($p)) ?>)">
                                <i class="fas fa-pen-nib"></i>
                            </button>
                            <button class="btn-icon btn-del" title="Terminate" onclick="confirmDelete(<?= $p['id'] ?>)">
                                <i class="fas fa-user-xmark"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; else: ?>
                <tr>
                    <td colspan="5" style="text-align:center; padding: 80px; opacity:0.2; letter-spacing: 5px;">VAULT REGISTRY EMPTY</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>

    <!-- PRODUCT MODAL -->
    <div id="productModal" class="modal">
        <div class="modal-content" style="max-width: 500px;">
            <h2 id="modalTitle" style="font-family: 'Playfair Display', serif; color: #fff; margin-bottom: 25px; font-size: 1.8rem; text-align: center;">Register Artifact</h2>
            
            <form action="<?= base_url('admin/save_product') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="prodId">
                
                <label class="form-label">Artifact Name</label>
                <input type="text" name="name" id="prodName" class="form-input" required placeholder="Ex: Black Ivory Signature">

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div>
                        <label class="form-label">Tier / Category</label>
                        <select name="category_id" id="prodCat" class="form-input">
                            <?php foreach($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>"><?= $cat['category_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Valuation (IDR)</label>
                        <input type="number" name="price" id="prodPrice" class="form-input" required placeholder="0">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div>
                        <label class="form-label">Vault Supply</label>
                        <input type="number" name="stock" id="prodStock" class="form-input" required placeholder="0">
                    </div>
                    <div>
                        <label class="form-label">Availability</label>
                        <select name="status" id="prodStatus" class="form-input">
                            <option value="available">Available</option>
                            <option value="sold out">Sold Out</option>
                        </select>
                    </div>
                </div>

                <label class="form-label">Visual Asset</label>
                <input type="file" name="image" class="form-input" accept="image/*">

                <label class="form-label">Extraction Note (Description)</label>
                <textarea name="description" id="prodDesc" class="form-input" rows="3" style="height: auto; resize: none;" placeholder="Provide technical details of the artifact..."></textarea>

                <div style="display: flex; gap: 12px; margin-top: 10px;">
                    <button type="button" class="btn-prime" onclick="closeModal()" style="background: transparent; color: #555; border: 1px solid var(--border);">Abort</button>
                    <button type="submit" class="btn-prime" style="flex: 1;">Commit Transmission</button>
                </div>
            </form>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    const modal = document.getElementById('productModal');

    function closeModal() { modal.style.display = 'none'; }
    
    function openModal() {
        document.getElementById('modalTitle').innerText = 'Register Artifact';
        document.getElementById('prodId').value = '';
        document.getElementById('prodName').value = '';
        document.getElementById('prodCat').selectedIndex = 0;
        document.getElementById('prodPrice').value = '';
        document.getElementById('prodStock').value = '';
        document.getElementById('prodStatus').value = 'available';
        document.getElementById('prodDesc').value = '';
        modal.style.display = 'flex';
    }

    function editProduct(data) {
        document.getElementById('modalTitle').innerText = 'Modify Artifact';
        document.getElementById('prodId').value = data.id;
        document.getElementById('prodName').value = data.name;
        document.getElementById('prodCat').value = data.category_id;
        document.getElementById('prodPrice').value = data.price;
        document.getElementById('prodStock').value = data.stock;
        document.getElementById('prodStatus').value = data.status;
        document.getElementById('prodDesc').value = data.description;
        modal.style.display = 'flex';
    }

    function confirmDelete(id) {
        Swal.fire({
            title: 'Terminate Artifact?',
            text: "This action will remove the artifact from the vault permanently.",
            icon: 'warning',
            background: '#0d0d0d', 
            color: '#f5deb3',
            showCancelButton: true,
            confirmButtonColor: '#e74c3c', 
            confirmButtonText: 'TERMINATE',
            cancelButtonText: 'ABORT'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?= base_url('admin/delete_product/') ?>/" + id;
            }
        })
    }

    // Flash Messages Integration
    <?php if(session()->getFlashdata('success')): ?>
        Swal.fire({ 
            icon: 'success', 
            title: 'Transmission Success', 
            text: '<?= session()->getFlashdata('success') ?>', 
            background: '#0d0d0d', 
            color: '#f5deb3', 
            confirmButtonColor: '#f5deb3'
        });
    <?php endif; ?>

    window.onclick = function(e) { if(e.target == modal) closeModal(); }
</script>
<?= $this->endSection() ?>
<?= $this->extend('layout/admin_layout') ?>

<?= $this->section('content') ?>
    <!-- HEADER -->
    <div class="dv-header animate__animated animate__fadeIn">
        <div>
            <span class="sub-label">Audit & Logistics</span>
            <h1 class="serif italic" style="font-size: 3rem; color: #fff; margin-top:5px;">Transmission Registry</h1>
        </div>
        <div style="text-align: right">
            <p style="font-size: 11px; opacity: 0.4;">Logged as: <b><?= session()->get('user_name') ?></b></p>
        </div>
    </div>

    <!-- DATA TABLE -->
    <section class="data-vault animate__animated animate__fadeInUp" style="animation-delay: 0.2s">
        <table>
            <thead>
                <tr>
                    <th>Customer / Code</th>
                    <th>Experience</th>
                    <th>Valuation</th>
                    <th>Status</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($orders)): ?>
                    <?php foreach($orders as $o): ?>
                    <tr>
                        <td data-label="Customer / Code">
                            <strong style="color: #fff; display: block; font-size: 16px;"><?= esc($o['customer_name']) ?></strong>
                            <span style="font-family: monospace; font-size: 11px; opacity: 0.4; letter-spacing: 1px;">#<?= esc($o['order_code']) ?></span>
                        </td>
                        <td data-label="Experience">
                            <div style="font-size: 11px; text-transform: uppercase; letter-spacing: 1px;">
                                <i class="fas <?= $o['service_type'] == 'dine-in' ? 'fa-chair' : ($o['service_type'] == 'delivery' ? 'fa-truck' : 'fa-box-archive') ?>" 
                                style="margin-right: 8px; color: var(--gold-dim)"></i>
                                <?= esc($o['service_type']) ?>
                                <br><small style="opacity: 0.4;"><?= esc($o['location']) ?></small>
                            </div>
                        </td>
                        <td data-label="Valuation">
                            <b style="color: var(--gold); font-size: 16px;">Rp <?= number_format($o['total_amount'], 0, ',', '.') ?></b>
                        </td>
                        <td data-label="Status">
                            <span class="st-badge <?= esc($o['status']) ?>">
                                <?= esc($o['status']) ?>
                            </span>
                        </td>
                        <td data-label="Action" style="text-align: right;">
                            <div style="display: flex; gap: 8px; justify-content: flex-end; align-items: center;">
                                
                                <!-- Button Detail -->
                                <button class="btn-icon" title="View Details" onclick="viewDetails(<?= $o['id'] ?>, '<?= $o['order_code'] ?>')">
                                    <i class="fas fa-search-plus"></i>
                                </button>
                                
                                <?php if($o['status'] === 'pending'): ?>
                                    <button class="btn-prime" onclick="updateStatus(<?= $o['id'] ?>, 'processing')">Confirm</button>

                                <?php elseif($o['status'] === 'processing'): ?>
                                    <?php if($o['service_type'] === 'delivery'): ?>
                                        <button class="btn-prime" style="background: #6c5ce7; border-color: #6c5ce7; color: #fff;" 
                                                onclick="updateStatus(<?= $o['id'] ?>, 'out-for-delivery')">
                                            <i class="fas fa-paper-plane"></i> Dispatch
                                        </button>
                                    <?php else: ?>
                                        <button class="btn-prime" style="background: transparent; border: 1px solid var(--gold); color: var(--gold);" 
                                                onclick="updateStatus(<?= $o['id'] ?>, 'completed')">
                                            Serve
                                        </button>
                                    <?php endif; ?>

                                <?php elseif($o['status'] === 'out-for-delivery'): ?>
                                    <?php 
                                        $phone = $o['customer_phone'] ?? '';
                                        if(str_starts_with($phone, '0')) $phone = '62' . substr($phone, 1);
                                    ?>
                                    <a href="https://wa.me/<?= $phone ?>?text=Halo%20<?= urlencode($o['customer_name']) ?>..." 
                                    target="_blank" class="btn-icon btn-wa" title="Nudge via WhatsApp">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                <?php endif; ?>

                                <!-- TOMBOL CANCEL (Muncul selama belum selesai/batal) -->
                                <?php if(!in_array($o['status'], ['completed', 'cancelled'])): ?>
                                    <button class="btn-icon btn-del" title="Cancel Transmission" 
                                            onclick="updateStatus(<?= $o['id'] ?>, 'cancelled')">
                                        <i class="fas fa-ban"></i>
                                    </button>
                                <?php endif; ?>

                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5" style="text-align: center; padding: 100px; opacity: 0.3;">No transmissions recorded.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>

    <!-- MODAL DETAIL -->
    <div id="orderModal" class="modal">
        <div class="modal-content animate__animated animate__zoomIn animate__faster" style="max-width: 550px;">
            <h2 id="modalTitle" class="serif italic" style="color: var(--gold); margin-bottom: 30px; font-size: 2rem;">Registry Detail</h2>
            
            <div id="itemsContainer" style="max-height: 400px; overflow-y: auto; padding-right: 10px;">
                <!-- Content loaded via AJAX -->
            </div>

            <div style="margin-top: 40px; display: flex; gap: 15px;">
                <button class="btn-prime" style="flex: 1; background: transparent; color: #555; border: 1px solid var(--border);" onclick="closeModal()">Close Registry</button>
                <button class="btn-prime" style="flex: 1;" onclick="window.print()"><i class="fas fa-print" style="margin-right: 10px;"></i> Print</button>
            </div>
        </div>
    </div>

    <!-- CSS KHUSUS HALAMAN ORDER -->
    <style>
        .serif { font-family: 'Playfair Display', serif; }
        .italic { font-style: italic; }

        /* Status Badge Styling */
        .st-badge { padding: 6px 14px; border-radius: 50px; font-size: 9px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; border: 1px solid transparent; display: inline-block; }
        .pending { color: #f39c12; background: rgba(243, 156, 18, 0.1); border-color: rgba(243, 156, 18, 0.2); }
        .paid { color: #2ecc71; background: rgba(46, 204, 113, 0.1); border-color: rgba(46, 204, 113, 0.2); }
        .completed { color: #3498db; background: rgba(52, 152, 219, 0.1); border-color: rgba(52, 152, 219, 0.2); }
        .cancelled { color: #e74c3c; background: rgba(231, 76, 60, 0.1); border-color: rgba(231, 76, 60, 0.2); }

        /* Item Row in Modal */
        .item-row { display: flex; justify-content: space-between; align-items: center; padding: 18px 0; border-bottom: 1px solid var(--border); }
        .item-row:last-child { border-bottom: none; }
        .processing {
            color: #3498db;
            background: rgba(52, 152, 219, 0.1);
            border-color: rgba(52, 152, 219, 0.2);
        }
        /* Status Out for Delivery - Amethyst Purple */
        .out-for-delivery { 
            color: #a29bfe; 
            background: rgba(162, 155, 254, 0.1); 
            border-color: rgba(162, 155, 254, 0.2); 
        }

        /* Hover effect khusus WA */
        .btn-wa:hover {
            color: #25d366 !important;
            border-color: #25d366 !important;
            background: rgba(37, 211, 102, 0.05) !important;
        }
        /* Status Cancelled - Crimson Red */
        .cancelled { 
            color: #e74c3c; 
            background: rgba(231, 76, 60, 0.1); 
            border: 1px solid rgba(231, 76, 60, 0.2); 
        }

        /* Memastikan tombol icon cancel terlihat elegan */
        .btn-del:hover {
            color: #e74c3c !important;
            border-color: #e74c3c !important;
            background: rgba(231, 76, 60, 0.05) !important;
        }
    </style>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <script>
        function viewDetails(id, code) {
            document.getElementById('modalTitle').innerText = 'Registry: #' + code;
            const container = document.getElementById('itemsContainer');
            container.innerHTML = `
                <div style="text-align:center; padding: 60px;">
                    <i class="fas fa-circle-notch fa-spin" style="color:var(--gold); font-size: 2rem;"></i>
                    <p style="margin-top:15px; opacity:0.5; font-size: 11px; letter-spacing: 2px;">DECRYPTING TRANSMISSION...</p>
                </div>`;
            
            document.getElementById('orderModal').style.display = 'flex';

            fetch('<?= base_url('admin/order_items') ?>/' + id)
                .then(res => res.json())
                .then(data => {
                    container.innerHTML = '';
                    if(data.length === 0) {
                        container.innerHTML = '<p style="text-align:center; padding: 40px; opacity:0.5;">No items found in this record.</p>';
                        return;
                    }
                    data.forEach(item => {
                        container.innerHTML += `
                            <div class="item-row">
                                <div>
                                    <span style="color:#fff; font-weight:600; font-size:15px; display:block; margin-bottom:4px;">${item.product_name}</span>
                                    <span style="color:var(--gold); opacity:0.5; font-size:10px; font-weight:700; letter-spacing:1px;">QUANTITY: ${item.quantity}</span>
                                </div>
                                <b style="color: #fff; font-size: 14px;">Rp ${new Intl.NumberFormat('id-ID').format(item.subtotal)}</b>
                            </div>
                        `;
                    });
                })
                .catch(err => {
                    container.innerHTML = '<p style="color:#e74c3c; text-align:center; padding: 20px;">FAILED TO RETRIEVE LEDGER DATA.</p>';
                });
        }

        function closeModal() {
            const modal = document.getElementById('orderModal');
            const content = modal.querySelector('.modal-content');
            content.classList.replace('animate__zoomIn', 'animate__zoomOut');
            setTimeout(() => {
                modal.style.display = 'none';
                content.classList.replace('animate__zoomOut', 'animate__zoomIn');
            }, 200);
        }

        function updateStatus(id, status) {
            const isCancel = (status === 'cancelled');
            
            Swal.fire({
                title: isCancel ? 'Abort Transmission?' : 'Update Transmission?',
                text: isCancel 
                    ? "Warning: This action will terminate the order registry permanently." 
                    : "Proceed to mark this registry as " + status.toUpperCase() + "?",
                icon: isCancel ? 'warning' : 'question',
                showCancelButton: true,
                background: '#0d0d0d',
                color: '#f5deb3',
                confirmButtonColor: isCancel ? '#e74c3c' : '#f5deb3',
                cancelButtonColor: '#151515',
                confirmButtonText: isCancel 
                    ? '<span style="color:#fff; font-weight:800">TERMINATE</span>' 
                    : '<span style="color:#050505; font-weight:800">CONFIRM</span>',
                cancelButtonText: 'ABORT',
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '<?= base_url('admin/update_order_status') ?>/' + id;
                    
                    const input = document.createElement('input');
                    input.type = 'hidden'; 
                    input.name = 'status'; 
                    input.value = status;
                    
                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '<?= csrf_token() ?>';
                    csrf.value = '<?= csrf_hash() ?>';

                    form.appendChild(input);
                    form.appendChild(csrf);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // Handle Flashdata
        <?php if(session()->getFlashdata('success')): ?>
            Swal.fire({ 
                icon: 'success', title: 'Ledger Updated', 
                text: '<?= session()->getFlashdata('success') ?>', 
                background: '#0d0d0d', color: '#f5deb3', confirmButtonColor: '#f5deb3' 
            });
        <?php endif; ?>
    </script>
<?= $this->endSection() ?>
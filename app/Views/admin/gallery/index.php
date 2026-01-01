<?php 
/** 
 * Memberikan petunjuk tipe data ke VS Code agar tidak error P1006
 * @var array<int, array<string, mixed>> $gallery 
 */ 
?>
<?= $this->extend('layout/admin_layout') ?>

<?= $this->section('content') ?>
    <div class="dv-header animate__animated animate__fadeIn">
        <div class="header-titles">
            <span class="sub-label">Sovereign Visual Assets</span>
            <h1 class="serif italic dashboard-title">Visual Archive 
                <span class="asset-count-pill"><?= count($gallery) ?> Units</span>
            </h1>
        </div>
        <button class="btn-prime glow-effect" onclick="openGalleryModal()">
            <i class="fas fa-plus-circle"></i> Enroll New Asset
        </button>
    </div>

    <!-- DATA VAULT -->
    <section class="data-vault premium-card">
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th style="width: 150px;">Asset Preview</th>
                        <th>Identity & Logs</th>
                        <th>Collection</th>
                        <th>State</th>
                        <th style="text-align: right;">Authorization</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($gallery)):  foreach($gallery as $g): ?>
                    <tr class="vault-row">
                        <td data-label="Asset Preview">
                            <div class="asset-frame">
                                <?php
                                $thumb = 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?q=80&w=300&auto=format&fit=crop';
                                if (!empty($g['image'])) {
                                    $imgName = (string)$g['image']; // Cast ke string
                                    if (filter_var($imgName, FILTER_VALIDATE_URL)) {
                                        $thumb = $imgName;
                                    } elseif (file_exists(FCPATH . 'uploads/gallery/' . $imgName)) {
                                        $thumb = base_url('uploads/gallery/' . $imgName);
                                    }
                                }
                                ?>
                                <img src="<?= $thumb ?>" class="premium-thumb" loading="lazy">
                                <div class="thumb-overlay" onclick="window.open('<?= (string)$thumb ?>')">
                                    <i class="fas fa-expand-alt"></i>
                                    <span>ENLARGE</span>
                                </div>
                            </div>
                        </td>
                        <td data-label="Identity">
                            <div class="meta-info">
                                <strong class="asset-title"><?= esc((string)$g['title']) ?></strong>
                                <span class="uid">REGISTRY ID: CT-<?= str_pad((string)$g['id'], 4, '0', STR_PAD_LEFT) ?></span>
                            </div>
                        </td>
                        <td data-label="Collection">
                            <!-- PERBAIKAN DI SINI: Cast ke (string) sebelum esc dan strtoupper -->
                            <span class="collection-pill"><?= strtoupper(esc((string)($g['category'] ?? 'General'))) ?></span>
                        </td>
                        <td data-label="State">
                            <?php if($g['is_active']): ?>
                                <div class="status-indicator live">
                                    <span class="pulse-dot"></span>
                                    <span class="status-label">LIVE</span>
                                </div>
                            <?php else: ?>
                                <div class="status-indicator hidden">
                                    <span class="static-dot"></span>
                                    <span class="status-label">ARCHIVED</span>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td data-label="Authorization" style="text-align: right;">
                            <div class="action-group">
                                <!-- PERBAIKAN DI SINI: Cast hasil json_encode ke string -->
                                <button class="btn-icon-premium" title="Modify" onclick='editGallery(<?= htmlspecialchars((string)json_encode($g), ENT_QUOTES, 'UTF-8') ?>)'>
                                    <i class="fas fa-sliders-h"></i>
                                </button>
                                <button class="btn-icon-premium del" title="Purge" onclick="confirmDelete(<?= (int)$g['id'] ?>)">
                                    <i class="fas fa-fire-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td colspan="5" class="empty-state-container">
                            <div class="empty-state">
                                <i class="fas fa-box-open"></i>
                                <p>Visual registry is currently empty.</p>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- REFINED ULTRA-COMPACT MODAL -->
    <div id="galleryModal" class="modal glass-modal">
        <div class="modal-content-elite animate__animated animate__zoomIn animate__faster">
            <div class="modal-header-premium">
                <h2 id="modalTitle" class="serif italic">Visual Registry</h2>
                <button type="button" class="close-premium" onclick="closeGalleryModal()">&times;</button>
            </div>
            
            <form action="<?= base_url('admin/save_gallery') ?>" method="post" enctype="multipart/form-data" class="premium-form">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="galId">
                
                <div class="input-group">
                    <label class="label-elite">Asset Identity</label>
                    <input type="text" name="title" id="galTitle" class="input-elite" required placeholder="Subject identity...">
                </div>

                <div class="grid-row">
                    <div class="grid-col">
                        <label class="label-elite">Collection</label>
                        <select name="category" id="galCategory" class="input-elite">
                            <option value="interior">Interior</option>
                            <option value="brewing">Brewing</option>
                            <option value="events">Events</option>
                        </select>
                    </div>
                    <div class="grid-col">
                        <label class="label-elite">Vault State</label>
                        <select name="is_active" id="galStatus" class="input-elite">
                            <option value="1">Visible (Live)</option>
                            <option value="0">Hidden (Archive)</option>
                        </select>
                    </div>
                </div>

                <div class="input-group">
                    <label class="label-elite">Visual Manifest (Image)</label>
                    <div class="file-custom-area">
                        <input type="file" name="image" class="file-hidden" id="galImage" accept="image/*">
                        <label for="galImage" class="file-label-proxy">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <span>Select Image File</span>
                        </label>
                    </div>
                </div>

                <div class="modal-footer-premium">
                    <button type="button" class="btn-abort" onclick="closeGalleryModal()">Discard</button>
                    <button type="submit" class="btn-commit">Commit Registry</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        /* Tetap sama dengan sebelumnya untuk estetika Master Console */
        .dashboard-title { font-size: 3.2rem; line-height: 1; margin-bottom: 5px; color: #fff; }
        .asset-count-pill { font-size: 0.9rem; font-family: 'Poppins'; background: rgba(245, 222, 179, 0.1); color: var(--gold); padding: 4px 12px; border-radius: 50px; font-weight: 400; font-style: normal; vertical-align: middle; }
        .premium-card { background: var(--carbon); border: 1px solid var(--border); border-radius: 30px; padding: 20px; box-shadow: 0 25px 50px rgba(0,0,0,0.5); }
        .asset-frame { position: relative; width: 130px; height: 85px; border-radius: 15px; overflow: hidden; border: 1px solid rgba(255,255,255,0.08); background: #000; }
        .premium-thumb { width: 100%; height: 100%; object-fit: cover; transition: 0.5s transform ease; }
        .asset-frame:hover .premium-thumb { transform: scale(1.1); }
        .thumb-overlay { position: absolute; inset: 0; background: rgba(0,0,0,0.6); display: flex; flex-direction: column; align-items: center; justify-content: center; opacity: 0; transition: 0.3s opacity; cursor: pointer; backdrop-filter: blur(2px); }
        .asset-frame:hover .thumb-overlay { opacity: 1; }
        .thumb-overlay i { color: var(--gold); font-size: 1.2rem; margin-bottom: 5px; }
        .thumb-overlay span { font-size: 8px; font-weight: 800; letter-spacing: 1px; color: #fff; }
        .meta-info { display: flex; flex-direction: column; gap: 4px; }
        .asset-title { color: #fff; font-size: 1.1rem; letter-spacing: -0.3px; }
        .uid { font-family: monospace; font-size: 10px; color: var(--gold-dim); letter-spacing: 1px; }
        .collection-pill { font-size: 9px; font-weight: 800; color: var(--gold); border: 1px solid rgba(245, 222, 179, 0.2); padding: 5px 12px; border-radius: 8px; background: rgba(245, 222, 179, 0.05); }
        .status-indicator { display: inline-flex; align-items: center; gap: 8px; font-size: 10px; font-weight: 900; letter-spacing: 1px; }
        .pulse-dot { width: 6px; height: 6px; background: #2ecc71; border-radius: 50%; box-shadow: 0 0 10px #2ecc71; animation: pulse 1.5s infinite; }
        .static-dot { width: 6px; height: 6px; background: #555; border-radius: 50%; }
        .status-indicator.live { color: #2ecc71; }
        .status-indicator.hidden { color: #555; }
        @keyframes pulse { 0% { opacity: 1; transform: scale(1); } 50% { opacity: 0.5; transform: scale(1.2); } 100% { opacity: 1; transform: scale(1); } }
        .btn-icon-premium { width: 40px; height: 40px; border-radius: 12px; background: #151515; border: 1px solid var(--border); color: #666; transition: 0.3s; cursor: pointer; }
        .btn-icon-premium:hover { border-color: var(--gold); color: var(--gold); background: #1a1a1a; transform: translateY(-3px); }
        .btn-icon-premium.del:hover { border-color: #e74c3c; color: #e74c3c; }
        .glass-modal { background: rgba(0,0,0,0.85); backdrop-filter: blur(10px); }
        .modal-content-elite { background: #0d0d0d; border: 1px solid rgba(245, 222, 179, 0.15); border-radius: 25px; width: 95%; max-width: 420px; box-shadow: 0 50px 100px rgba(0,0,0,0.8); }
        .modal-header-premium { padding: 20px 25px; border-bottom: 1px solid rgba(255,255,255,0.05); display: flex; justify-content: space-between; align-items: center; }
        .close-premium { background: none; border: none; color: #555; font-size: 28px; cursor: pointer; transition: 0.3s; }
        .close-premium:hover { color: #fff; }
        .premium-form { padding: 25px; }
        .label-elite { font-size: 9px; font-weight: 800; color: var(--gold); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; display: block; opacity: 0.7; }
        .input-elite { width: 100%; background: #050505; border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 12px 15px; color: #fff; font-size: 13px; margin-bottom: 20px; transition: 0.3s; }
        .input-elite:focus { border-color: var(--gold-dim); outline: none; }
        .grid-row { display: flex; gap: 15px; }
        .grid-col { flex: 1; }
        .file-hidden { display: none; }
        .file-label-proxy { display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px; border: 1px dashed rgba(245, 222, 179, 0.2); border-radius: 15px; cursor: pointer; transition: 0.3s; background: rgba(0,0,0,0.2); }
        .file-label-proxy:hover { background: rgba(245, 222, 179, 0.03); border-color: var(--gold-dim); }
        .file-label-proxy i { font-size: 1.5rem; color: var(--gold); margin-bottom: 10px; opacity: 0.5; }
        .file-label-proxy span { font-size: 10px; font-weight: 800; color: #555; text-transform: uppercase; }
        .modal-footer-premium { display: flex; gap: 12px; margin-top: 25px; }
        .btn-abort { flex: 1; background: transparent; border: 1px solid #222; color: #444; border-radius: 12px; font-size: 11px; font-weight: 700; cursor: pointer; }
        .btn-commit { flex: 2; background: var(--gold); color: #000; border: none; border-radius: 12px; padding: 14px; font-size: 11px; font-weight: 800; text-transform: uppercase; cursor: pointer; box-shadow: 0 10px 20px rgba(245, 222, 179, 0.1); }
    </style>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <script>
        function closeGalleryModal() { 
            const modal = document.getElementById('galleryModal');
            const content = modal.querySelector('.modal-content-elite');
            content.classList.replace('animate__zoomIn', 'animate__zoomOut');
            setTimeout(() => {
                modal.style.display = 'none';
                content.classList.replace('animate__zoomOut', 'animate__zoomIn');
            }, 200);
        }
        
        function openGalleryModal() {
            document.getElementById('modalTitle').innerText = 'Visual Registry';
            document.getElementById('galId').value = '';
            document.getElementById('galTitle').value = '';
            document.getElementById('galStatus').value = '1';
            document.getElementById('galleryModal').style.display = 'flex';
        }

        function editGallery(data) {
            document.getElementById('modalTitle').innerText = 'Modify Archive';
            document.getElementById('galId').value = data.id;
            document.getElementById('galTitle').value = data.title;
            document.getElementById('galCategory').value = data.category;
            document.getElementById('galStatus').value = data.is_active;
            document.getElementById('galleryModal').style.display = 'flex';
        }

        function confirmDelete(id) {
            Swal.fire({
                title: 'Burn Registry?',
                text: "This visual will be permanently purged from the archive.",
                icon: 'warning',
                background: '#0d0d0d', color: '#f5deb3',
                showCancelButton: true,
                confirmButtonColor: '#e74c3c', 
                confirmButtonText: 'PURGE RECORD',
                cancelButtonText: 'ABORT'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?= base_url('admin/delete_gallery/') ?>/" + id;
                }
            })
        }

        document.getElementById('galImage').addEventListener('change', function() {
            const fileName = this.files[0] ? this.files[0].name : "Select Image File";
            document.querySelector('.file-label-proxy span').innerText = fileName;
        });
    </script>
<?= $this->endSection() ?>
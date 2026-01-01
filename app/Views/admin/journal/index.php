<?= $this->extend('layout/admin_layout') ?>

<?= $this->section('content') ?>
    <div class="dv-header animate__animated animate__fadeIn">
        <div>
            <span class="sub-label">Content Management</span>
            <h1 class="serif italic" style="font-size: 3rem; color: #fff; margin-top:5px;">Roast Journal</h1>
        </div>
        <button class="btn-prime" onclick="openBlogModal()">+ Draft New Story</button>
    </div>

    <section class="data-vault animate__animated animate__fadeInUp" style="animation-delay: 0.2s">
        <table>
            <thead>
                <tr>
                    <th>Article</th>
                    <th>Category</th>
                    <th>Engagement</th>
                    <th>State</th>
                    <th style="text-align: right;">Management</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($blogs)): foreach($blogs as $b): ?>
                <tr>
                    <td data-label="Article">
                        <div class="user-flex">
                            <div class="avatar-box" style="width: 60px; height: 60px; border-radius: 12px;">
                                <?php
                                if (!empty($b['thumbnail'])) {

                                    // 1️⃣ Jika thumbnail berupa URL
                                    if (filter_var($b['thumbnail'], FILTER_VALIDATE_URL)) {
                                        $thumbPath = $b['thumbnail'];
                                    }

                                    // 2️⃣ Jika thumbnail file lokal
                                    elseif (file_exists(FCPATH . 'uploads/blog/' . $b['thumbnail'])) {
                                        $thumbPath = base_url('uploads/blog/' . $b['thumbnail']);
                                    }

                                    // 3️⃣ Jika path rusak
                                    else {
                                        $thumbPath = 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?q=80&w=150&auto=format&fit=crop';
                                    }

                                } else {
                                    // 4️⃣ Jika kosong
                                    $thumbPath = 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?q=80&w=150&auto=format&fit=crop';
                                }
                                ?>
                                <img src="<?= $thumbPath ?>" alt="Journal Thumbnail"
                                    style="width:100%; height:100%; object-fit:cover;">
                            </div>
                            <div style="text-align: left;">
                                <strong style="display: block; color: #fff; font-size: 15px;"><?= esc($b['title']) ?></strong>
                                <span style="font-size: 10px; color: var(--gold-dim); letter-spacing: 1px;">
                                    ID: #<?= $b['id'] ?> <?= $b['is_featured'] ? '• ⭐ Featured' : '' ?>
                                </span>
                            </div>
                        </div>
                    </td>
                    <td data-label="Category">
                        <span style="color: var(--gold); font-size: 11px; text-transform:uppercase; letter-spacing:1px;">
                            <?= esc($b['category_name'] ?? 'Uncategorized') ?>
                        </span>
                    </td>
                    <td data-label="Engagement">
                        <span style="font-size: 12px; opacity: 0.7;"><?= $b['read_time'] ?> Min Read</span>
                    </td>
                    <td data-label="State">
                        <span class="badge" style="background: <?= $b['status'] == 'published' ? 'rgba(46,204,113,0.1)' : 'rgba(231,76,60,0.1)' ?>; color: <?= $b['status'] == 'published' ? '#2ecc71' : '#e74c3c' ?>; border: 1px solid currentColor;">
                            <?= strtoupper(esc((string)$b['status'])) ?>
                        </span>
                    </td>
                    <td data-label="Management" style="text-align: right;">
                        <div style="display: flex; gap: 8px; justify-content: flex-end;">
                            <button class="btn-icon" title="Modify Journal" onclick='editBlog(<?= htmlspecialchars(json_encode($b), ENT_QUOTES, 'UTF-8') ?>)'><i class="fas fa-pen-nib"></i></button>
                            <button class="btn-icon btn-del" title="Terminate" onclick="confirmDelete(<?= $b['id'] ?>)"><i class="fas fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; else: ?>
                <tr><td colspan="5" style="text-align:center; padding: 100px; opacity:0.2;">NO STORIES TRANSMITTED</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>

    <!-- MODAL JOURNAL -->
    <div id="blogModal" class="modal">
        <div class="modal-content-compact">
            <div class="modal-header-slim">
                <h2 id="modalTitle" class="serif italic">Draft Story</h2>
                <button type="button" class="close-slim" onclick="closeBlogModal()">&times;</button>
            </div>
            
            <form action="<?= base_url('admin/save_journal') ?>" method="post" enctype="multipart/form-data" class="form-slim">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="blogId">
                
                <!-- Full Width Title -->
                <div class="field-group">
                    <label class="label-tiny">Journal Title</label>
                    <input type="text" name="title" id="blogTitle" class="input-slim" required placeholder="Enter title...">
                </div>

                <!-- Row 1: Category & Time (Dibuat berdampingan di mobile untuk hemat tempat) -->
                <div class="row-slim">
                    <div class="col-6">
                        <label class="label-tiny">Category</label>
                        <select name="category_id" id="blogCat" class="input-slim">
                            <?php foreach($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="label-tiny">Read Time (Min)</label>
                        <input type="number" name="read_time" id="blogTime" class="input-slim" required>
                    </div>
                </div>

                <!-- Row 2: State & Featured -->
                <div class="row-slim">
                    <div class="col-6">
                        <label class="label-tiny">State</label>
                        <select name="status" id="blogStatus" class="input-slim">
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="label-tiny">Featured</label>
                        <select name="is_featured" id="blogFeatured" class="input-slim">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                </div>

                <!-- Text Areas -->
                <div class="field-group">
                    <label class="label-tiny">Excerpt</label>
                    <textarea name="excerpt" id="blogExcerpt" class="input-slim" rows="2" style="resize:none;" required placeholder="Short summary..."></textarea>
                </div>

                <div class="field-group">
                    <label class="label-tiny">Content</label>
                    <textarea name="content" id="blogContent" class="input-slim" rows="4" style="min-height: 80px;" required placeholder="Story details..."></textarea>
                </div>

                <!-- Thumbnail & Footer -->
                <div class="footer-slim">
                    <div class="thumb-upload">
                        <label class="label-tiny">Thumbnail</label>
                        <input type="file" name="thumbnail" class="input-file-tiny" accept="image/*">
                    </div>
                    <div class="btn-group-slim">
                        <button type="button" class="btn-abort-slim" onclick="closeBlogModal()">Abort</button>
                        <button type="submit" class="btn-commit-slim">Commit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <style>
        /* CSS ULTRA COMPACT */
        .modal-content-compact {
            background: #0d0d0d;
            width: 95%;
            max-width: 480px; /* Lebih kecil dari sebelumnya */
            max-height: 90vh; /* Membatasi tinggi agar tidak tumpah */
            border-radius: 15px;
            border: 1px solid rgba(245, 222, 179, 0.15);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            animation: modalEntrance 0.3s ease-out;
        }

        .modal-header-slim {
            padding: 12px 18px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header-slim h2 { font-size: 1.1rem; color: #fff; margin: 0; }
        .close-slim { background: none; border: none; color: #555; font-size: 24px; cursor: pointer; }

        .form-slim {
            padding: 15px;
            overflow-y: auto; /* Scroll internal jika form kepanjangan */
            flex: 1;
        }

        .label-tiny { 
            font-size: 9px; 
            color: var(--gold); 
            text-transform: uppercase; 
            letter-spacing: 1px; 
            font-weight: 700; 
            display: block; 
            margin-bottom: 4px; 
        }

        .input-slim {
            width: 100%;
            background: #050505;
            border: 1px solid rgba(255,255,255,0.08);
            padding: 7px 10px;
            border-radius: 8px;
            color: #fff;
            font-size: 11px;
            margin-bottom: 10px;
        }

        .row-slim { display: flex; gap: 10px; }
        .col-6 { flex: 0 0 calc(50% - 5px); }

        .footer-slim {
            padding: 12px 0 0;
            border-top: 1px solid rgba(255,255,255,0.05);
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .input-file-tiny { font-size: 9px; color: #555; }

        .btn-group-slim { display: flex; gap: 8px; }
        .btn-abort-slim { flex: 1; background: transparent; border: 1px solid #222; color: #555; padding: 10px; border-radius: 8px; font-size: 10px; cursor: pointer; }
        .btn-commit-slim { flex: 2; background: var(--gold); border: none; color: #000; padding: 10px; border-radius: 8px; font-size: 10px; font-weight: 800; text-transform: uppercase; cursor: pointer; }

        /* Penyesuaian khusus layar sangat kecil */
        @media (max-height: 600px) {
            .input-slim { padding: 5px 8px; margin-bottom: 6px; }
            .modal-content-compact { max-height: 98vh; }
        }
    </style>

    <style>
        .serif { font-family: 'Playfair Display', serif; }
        .italic { font-style: italic; }
        .form-row { display: flex; gap: 20px; margin-bottom: 5px; }
        
        @media (max-width: 768px) {
            .form-row { flex-direction: column; gap: 0; }
        }
    </style>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <script>
        function closeBlogModal() { document.getElementById('blogModal').style.display = 'none'; }
        
        function openBlogModal() {
            document.getElementById('modalTitle').innerText = 'Draft New Story';
            document.getElementById('blogId').value = '';
            document.getElementById('blogTitle').value = '';
            document.getElementById('blogTime').value = '';
            document.getElementById('blogExcerpt').value = '';
            document.getElementById('blogContent').value = '';
            document.getElementById('blogStatus').value = 'draft';
            document.getElementById('blogFeatured').value = '0';
            document.getElementById('blogModal').style.display = 'flex';
        }

        function editBlog(data) {
            document.getElementById('modalTitle').innerText = 'Modify Journal';
            document.getElementById('blogId').value = data.id;
            document.getElementById('blogTitle').value = data.title;
            document.getElementById('blogCat').value = data.category_id;
            document.getElementById('blogTime').value = data.read_time;
            document.getElementById('blogStatus').value = data.status;
            document.getElementById('blogExcerpt').value = data.excerpt;
            document.getElementById('blogContent').value = data.content;
            document.getElementById('blogFeatured').value = data.is_featured;
            document.getElementById('blogModal').style.display = 'flex';
        }

        function confirmDelete(id) {
            Swal.fire({
                title: 'Terminate Story?',
                text: "This will remove the journal from public record.",
                icon: 'warning',
                background: '#0d0d0d', color: '#f5deb3',
                showCancelButton: true,
                confirmButtonColor: '#e74c3c', 
                confirmButtonText: 'TERMINATE',
                cancelButtonText: 'ABORT'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?= base_url('admin/delete_journal/') ?>/" + id;
                }
            })
        }

        // Handle Flashdata
        <?php if(session()->getFlashdata('success')): ?>
            Swal.fire({ 
                icon: 'success', title: 'Journal Updated', 
                text: '<?= session()->getFlashdata('success') ?>', 
                background: '#0d0d0d', color: '#f5deb3', confirmButtonColor: '#f5deb3' 
            });
        <?php endif; ?>
    </script>
<?= $this->endSection() ?>
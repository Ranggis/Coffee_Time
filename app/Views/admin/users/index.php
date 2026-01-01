<?= $this->extend('layout/admin_layout') ?>

<?= $this->section('content') ?>
    <div class="dv-header animate__animated animate__fadeIn">
        <div>
            <span class="sub-label">Sovereign Registry</span>
            <h1>Access Control</h1>
        </div>
        <button class="btn-prime" onclick="openModal()">+ New Enrollment</button>
    </div>

    <section class="data-vault animate__animated animate__fadeInUp">
        <table>
            <thead>
                <tr>
                    <th>Member Identity</th>
                    <th>Contact Address</th>
                    <th>Privilege</th>
                    <th style="text-align: right;">Authorization</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($users)): foreach($users as $u): ?>
                <tr>
                    <td data-label="Member Identity">
                        <div class="user-flex">
                            <div class="avatar-box">
                                <?php
                                if (!empty($u['avatar'])) {

                                    // 1️⃣ Jika avatar berupa URL
                                    if (filter_var($u['avatar'], FILTER_VALIDATE_URL)) {
                                        $avatar = $u['avatar'];
                                    }

                                    // 2️⃣ Jika file lokal
                                    elseif (file_exists(FCPATH . 'uploads/users/' . $u['avatar'])) {
                                        $avatar = base_url('uploads/users/' . $u['avatar']);
                                    }

                                    // 3️⃣ Jika path rusak
                                    else {
                                        $avatar = 'https://ui-avatars.com/api/?name='
                                            . urlencode($u['username'])
                                            . '&background=0d0d0d&color=f5deb3&bold=true';
                                    }

                                } else {
                                    // 4️⃣ Default avatar
                                    $avatar = 'https://ui-avatars.com/api/?name='
                                        . urlencode($u['username'])
                                        . '&background=0d0d0d&color=f5deb3&bold=true';
                                }
                                ?>
                                <img src="<?= $avatar ?>" alt="User Avatar">

                            </div>
                            <div style="text-align: left;">
                                <strong style="display: block; color: #fff; font-size: 15px;"><?= esc($u['username']) ?></strong>
                                <span style="font-size: 10px; color: #555;">UID: CT-<?= $u['id'] ?></span>
                            </div>
                        </div>
                    </td>
                    <td data-label="Contact Address"><?= esc($u['email']) ?></td>
                    <td data-label="Privilege">
                        <span class="badge <?= $u['role'] == 'admin' ? 'badge-admin' : 'badge-customer' ?>">
                            <?= esc($u['role']) ?>
                        </span>
                    </td>
                    <td data-label="Authorization">
                        <div style="display: flex; gap: 8px; justify-content: flex-end;">
                            <button class="btn-icon" title="Edit" onclick="editUser(<?= htmlspecialchars(json_encode($u)) ?>)"><i class="fas fa-pen-nib"></i></button>
                            <button class="btn-icon btn-del" title="Delete" onclick="confirmDelete(<?= $u['id'] ?>)"><i class="fas fa-user-xmark"></i></button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; else: ?>
                <tr><td colspan="4" style="text-align:center; padding: 80px; opacity:0.2;">VAULT REGISTRY EMPTY</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>

    <!-- MODAL -->
    <div id="userModal" class="modal">
        <div class="modal-content">
            <h2 id="modalTitle" style="font-family: 'Playfair Display', serif; color: #fff; margin-bottom: 30px; font-size: 1.8rem;">Identity Enrollment</h2>
            <form action="<?= base_url('admin/save_user') ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="userId">
                
                <label class="form-label">Username</label>
                <input type="text" name="username" id="userName" class="form-input" required placeholder="Ex: Arcturus">

                <label class="form-label">Email Address</label>
                <input type="email" name="email" id="userEmail" class="form-input" required placeholder="contact@domain.com">

                <label class="form-label">Clearance Role</label>
                <select name="role" id="userRole" class="form-input">
                    <option value="customer">Customer</option>
                    <option value="admin">Admin</option>
                </select>

                <label class="form-label">Encryption Key (Password)</label>
                <input type="password" name="password" id="userPassword" class="form-input" placeholder="••••••••">
                <small id="passHint" style="display: none; font-size: 9px; color: #555; margin-top: -10px; display: block; margin-bottom: 15px;">*Kosongkan jika tidak ingin ganti</small>

                <div style="display: flex; gap: 12px; margin-top: 10px;">
                    <button type="button" class="btn-prime" onclick="closeModal()" style="background: transparent; color: #555; border: 1px solid var(--border);">Abort</button>
                    <button type="submit" class="btn-prime" style="flex: 1;">Commit Change</button>
                </div>
            </form>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <script>
        function closeModal() { document.getElementById('userModal').style.display = 'none'; }
        
        function openModal() {
            document.getElementById('modalTitle').innerText = 'New Identity';
            document.getElementById('userId').value = '';
            document.getElementById('userName').value = '';
            document.getElementById('userEmail').value = '';
            document.getElementById('userPassword').required = true;
            document.getElementById('passHint').style.display = 'none';
            document.getElementById('userModal').style.display = 'flex';
        }

        function editUser(data) {
            document.getElementById('modalTitle').innerText = 'Modify Identity';
            document.getElementById('userId').value = data.id;
            document.getElementById('userName').value = data.username;
            document.getElementById('userEmail').value = data.email;
            document.getElementById('userRole').value = data.role;
            document.getElementById('userPassword').required = false;
            document.getElementById('passHint').style.display = 'block';
            document.getElementById('userModal').style.display = 'flex';
        }

        function confirmDelete(id) {
            Swal.fire({
                title: 'Purge Identity?',
                text: "This user will lose all access privileges.",
                icon: 'warning',
                background: '#0d0d0d', color: '#f5deb3',
                showCancelButton: true,
                confirmButtonColor: '#e74c3c', 
                confirmButtonText: 'PURGE',
                cancelButtonText: 'ABORT'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?= base_url('admin/delete_user/') ?>/" + id;
                }
            })
        }

        window.onclick = function(e) { if(e.target == document.getElementById('userModal')) closeModal(); }
    </script>
<?= $this->endSection() ?>
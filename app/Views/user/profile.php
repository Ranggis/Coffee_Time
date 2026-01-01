<?= $this->extend('layout/user_layout') ?>

<?= $this->section('content') ?>
<style>
    :root { 
        --gold: #f5deb3; 
        --gold-glow: rgba(245, 222, 179, 0.3);
        --onyx: #050505; 
        --carbon: #0d0d0d; 
        --border: rgba(255, 255, 255, 0.05); 
    }
    
    .profile-container { max-width: 850px; margin: 0 auto; padding: 60px 20px; }
    
    /* Identity Card Elite */
    .identity-card { 
        background: linear-gradient(145deg, #0f0b0c, #070404);
        border: 1px solid var(--border); 
        border-radius: 40px; padding: 50px; text-align: center; margin-bottom: 40px;
        box-shadow: 0 30px 60px rgba(0,0,0,0.5);
        position: relative;
    }
    
    .avatar-wrapper {
        width: 140px; height: 140px; margin: 0 auto 25px; position: relative;
        border-radius: 50%; padding: 5px;
        background: linear-gradient(to bottom, var(--gold), transparent);
        box-shadow: 0 0 30px var(--gold-glow);
    }
    
    .avatar-wrapper img { 
        width: 100%; height: 100%; object-fit: cover; border-radius: 50%; 
        border: 4px solid var(--carbon);
    }

    .btn-upload-proxy {
        position: absolute; bottom: 5px; right: 5px; width: 40px; height: 40px;
        background: var(--gold); border-radius: 50%; display: flex; 
        align-items: center; justify-content: center; color: var(--onyx);
        cursor: pointer; border: 4px solid var(--carbon); transition: 0.4s;
        box-shadow: 0 5px 15px rgba(0,0,0,0.5);
    }
    .btn-upload-proxy:hover { transform: scale(1.1) rotate(15deg); background: #fff; }

    /* Modern Form Elite */
    .form-elite { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; }
    .input-group { position: relative; }
    .input-group.full { grid-column: span 2; }
    
    .input-group label {
        display: block; font-size: 9px; text-transform: uppercase; 
        letter-spacing: 3px; color: var(--gold); opacity: 0.6; margin-bottom: 12px;
        font-weight: 700;
    }

    .form-control-elite {
        width: 100%; background: rgba(255,255,255,0.02); border: 1px solid var(--border);
        padding: 18px 25px; border-radius: 20px; color: #fff; font-family: inherit;
        font-size: 14px; transition: 0.5s cubic-bezier(0.23, 1, 0.32, 1); outline: none;
    }
    
    .form-control-elite:focus { 
        border-color: var(--gold); 
        background: rgba(255,255,255,0.05);
        box-shadow: 0 0 20px rgba(245, 222, 179, 0.1);
        transform: translateY(-2px);
    }

    .btn-save-profile {
        grid-column: span 2; background: var(--gold); color: var(--onyx);
        border: none; padding: 22px; border-radius: 20px; font-weight: 900;
        text-transform: uppercase; letter-spacing: 4px; font-size: 11px;
        cursor: pointer; transition: 0.4s; margin-top: 20px;
        box-shadow: 0 15px 30px rgba(245, 222, 179, 0.2);
    }
    
    .btn-save-profile:hover { 
        background: #fff; transform: translateY(-5px); 
        box-shadow: 0 20px 40px rgba(255, 255, 255, 0.1);
    }

    @media (max-width: 600px) {
        .form-elite { grid-template-columns: 1fr; }
        .input-group.full { grid-column: span 1; }
        .btn-save-profile { grid-column: span 1; padding: 18px; }
        .identity-card { padding: 30px; }
    }
</style>

<div class="profile-container">
    <!-- Header Title -->
    <div style="margin-bottom: 50px; text-align: center;" id="profileHeader">
        <span style="font-size: 10px; text-transform: uppercase; letter-spacing: 6px; color: var(--gold); opacity: 0.5;">Coffee Time</span>
        <h1 style="font-family: 'Playfair Display', serif; font-style: italic; color: #fff; font-size: clamp(2.5rem, 5vw, 3.5rem); line-height: 1.2;">Identity Vault</h1>
    </div>

    <form action="<?= base_url('user/update_profile') ?>" method="POST" enctype="multipart/form-data" id="profileForm">
        <?= csrf_field() ?>
        
        <!-- Profile Card -->
        <div class="identity-card profile-card">
            <div class="avatar-wrapper">
                <?php
                $avatarPath = 'https://ui-avatars.com/api/?name='.urlencode($user['username']).'&background=0d0d0d&color=f5deb3&bold=true';
                if (!empty($user['avatar'])) {
                    if (filter_var($user['avatar'], FILTER_VALIDATE_URL)) {
                        $avatarPath = $user['avatar'];
                    } elseif (file_exists(FCPATH . 'uploads/users/' . $user['avatar'])) {
                        $avatarPath = base_url('uploads/users/' . $user['avatar']);
                    }
                }
                ?>
                <img src="<?= $avatarPath ?>?v=<?= time() ?>" id="avatarPreview">
                <label for="avatarInput" class="btn-upload-proxy" title="Change Visual Identity">
                    <i class="fas fa-camera"></i>
                </label>
                <input type="file" name="avatar" id="avatarInput" hidden accept="image/*" onchange="previewImg(this)">
            </div>
            <h2 style="color: #fff; font-family: 'Playfair Display', serif;"><?= esc($user['username']) ?></h2>
            <p style="font-size: 11px; opacity: 0.4; text-transform: uppercase; letter-spacing: 2px;">Registry ID: CT-00<?= $user['id'] ?></p>
        </div>

        <!-- Inputs Grid -->
        <div class="form-elite profile-form">
            <div class="input-group">
                <label><i class="fas fa-user-shield" style="margin-right: 8px; opacity:0.5;"></i> Codename</label>
                <input type="text" name="username" class="form-control-elite" value="<?= esc($user['username']) ?>" required>
            </div>

            <div class="input-group">
                <label><i class="fas fa-envelope-open" style="margin-right: 8px; opacity:0.5;"></i> Digital Address</label>
                <input type="email" name="email" class="form-control-elite" value="<?= esc($user['email']) ?>" required>
            </div>

            <div class="input-group">
                <label><i class="fas fa-phone" style="margin-right: 8px; opacity:0.5;"></i> Voice Connection</label>
                <input type="text" name="phone" class="form-control-elite" value="<?= esc($user['phone']) ?>" placeholder="628xxxxxxxx">
            </div>

            <div class="input-group">
                <label><i class="fas fa-key" style="margin-right: 8px; opacity:0.5;"></i> Encryption Key</label>
                <input type="password" name="password" class="form-control-elite" placeholder="••••••••••••">
            </div>

            <div class="input-group full">
                <label><i class="fas fa-map-marker-alt" style="margin-right: 8px; opacity:0.5;"></i> Dispatch Coordinates</label>
                <textarea name="address" class="form-control-elite" rows="3" placeholder="Enter full delivery coordinates..."><?= esc($user['address']) ?></textarea>
            </div>

            <button type="submit" class="btn-save-profile">Synchronize Identity</button>
        </div>
    </form>
</div>

<script>
    // Real-time Preview Engine
    function previewImg(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('avatarPreview');
                preview.style.opacity = '0';
                setTimeout(() => {
                    preview.src = e.target.result;
                    preview.style.opacity = '1';
                }, 300);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Form Confirmation
    document.getElementById('profileForm').onsubmit = function() {
        Swal.fire({
            title: 'Synchronizing...',
            text: 'Uploading identity data to the vault.',
            allowOutsideClick: false,
            background: '#0d0d0d',
            color: '#f5deb3',
            didOpen: () => { Swal.showLoading(); }
        });
    };
    document.addEventListener('DOMContentLoaded', () => {

        const PAGE_KEY = 'profilePageAnimated';

        const header = document.getElementById('profileHeader');
        const card   = document.querySelector('.profile-card');
        const form   = document.querySelector('.profile-form');

        const hasAnimated = sessionStorage.getItem(PAGE_KEY);

        if (!hasAnimated) {

            // Header
            if (header) {
                header.classList.add(
                    'animate__animated',
                    'animate__fadeInDown'
                );
            }

            // Identity card
            if (card) {
                card.classList.add(
                    'animate__animated',
                    'animate__fadeInUp'
                );
                card.style.animationDelay = '0.1s';
            }

            // Form
            if (form) {
                form.classList.add(
                    'animate__animated',
                    'animate__fadeInUp'
                );
                form.style.animationDelay = '0.25s';
            }

            sessionStorage.setItem(PAGE_KEY, 'true');

        } else {
            // Pastikan tampil normal tanpa animasi
            [header, card, form].forEach(el => {
                if (!el) return;
                el.style.opacity = 1;
                el.style.transform = 'none';
            });
        }
    });
</script>
<?= $this->endSection() ?>
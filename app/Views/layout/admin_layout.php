<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Coffee Time | Admin' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@600;700&family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400&family=Poppins:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --onyx: #050505; --carbon: #0d0d0d; --carbon-light: #151515;
            --gold: #f5deb3; --gold-dim: rgba(245, 222, 179, 0.4);
            --gold-ultra-low: rgba(245, 222, 179, 0.05); --border: rgba(245, 222, 179, 0.1); 
            --success: #2ecc71; --danger: #e74c3c;
            --sidebar-w: 260px; --transit: cubic-bezier(0.4, 0, 0.2, 1);
            --max-w: 1100px; 
        }

        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-thumb { background: var(--gold-dim); border-radius: 10px; }

        * { margin: 0; padding: 0; box-sizing: border-box; outline: none; -webkit-tap-highlight-color: transparent; }
        
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: var(--onyx); color: #d1d1d1; 
            min-height: 100vh; display: flex; overflow-x: hidden;
            background-image: radial-gradient(circle at 50% 0%, #1a1510 0%, var(--onyx) 75%);
        }

        /* SIDEBAR & OVERLAY */
        .sidebar-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.7); backdrop-filter: blur(4px); z-index: 9998; opacity: 0; visibility: hidden; transition: 0.4s var(--transit); }
        .sidebar-overlay.active { opacity: 1; visibility: visible; }

        aside.sidebar { 
            width: var(--sidebar-w); background: var(--carbon); border-right: 1px solid var(--border); 
            height: 100vh; position: fixed; left: 0; top: 0; z-index: 9999; 
            display: flex; flex-direction: column; transition: transform 0.5s var(--transit), opacity 0.5s; 
        }
        
        .side-close { display: none; position: absolute; top: 20px; right: 20px; width: 35px; height: 35px; background: var(--gold-ultra-low); border: 1px solid var(--border); border-radius: 10px; color: var(--gold); align-items: center; justify-content: center; cursor: pointer; }
        .side-brand { padding: 45px 30px; text-align: center; border-bottom: 1px solid var(--border); }
        .side-brand h2 { font-family: 'Dancing Script', cursive; color: var(--gold); font-size: 2rem; }
        .side-brand p { font-size: 8px; letter-spacing: 4px; color: var(--gold-dim); text-transform: uppercase; margin-top: 5px; font-weight: 700; }

        .side-nav { flex: 1; padding: 25px 15px; list-style: none; overflow-y: auto; }
        .side-nav a { display: flex; align-items: center; gap: 14px; padding: 12px 18px; border-radius: 12px; color: rgba(255,255,255,0.3); font-size: 11.5px; font-weight: 600; text-transform: uppercase; text-decoration: none; transition: 0.3s; letter-spacing: 0.8px; margin-bottom: 6px; position: relative; }
        .side-nav a i { width: 18px; font-size: 13px; }
        .side-nav a:hover, .side-nav a.active { color: var(--gold); background: var(--gold-ultra-low); }
        .side-nav a.active { color: #fff; background: rgba(245, 222, 179, 0.08); border: 1px solid var(--border); }

        .nav-badge { position: absolute; right: 15px; background: var(--gold); color: var(--onyx); font-size: 9px; padding: 2px 7px; border-radius: 50px; font-weight: 800; }
        .side-footer { padding: 20px 15px; border-top: 1px solid var(--border); }
        .logout-btn { display: flex; align-items: center; gap: 10px; padding: 12px 18px; color: var(--danger); font-size: 11px; font-weight: 700; text-transform: uppercase; text-decoration: none; border-radius: 12px; transition: 0.3s; opacity: 0.7; }
        .logout-btn:hover { background: rgba(231, 76, 60, 0.1); opacity: 1; }

        /* WORKSPACE */
        main.workspace { flex: 1; margin-left: var(--sidebar-w); padding: 50px 35px; width: calc(100% - var(--sidebar-w)); display: flex; justify-content: center; }
        .container-limited { width: 100%; max-width: var(--max-w); }

        .mobile-top-bar { display: none; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .hamb-trigger { width: 45px; height: 45px; background: var(--carbon-light); border: 1px solid var(--border); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--gold); cursor: pointer; }

        /* Responsiveness */
        @media (max-width: 1100px) {
            aside.sidebar { transform: translateX(-100%); opacity: 0; }
            aside.sidebar.active { transform: translateX(0); opacity: 1; }
            main.workspace { margin-left: 0; padding: 25px 20px; }
            .mobile-top-bar { display: flex; }
            .side-close { display: flex; }
        }

        /* Tambahkan CSS Modal & Tabel di sini agar Global */
        .dv-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 40px; }
        .dv-header h1 { font-family: 'Playfair Display', serif; font-size: 2.4rem; color: #fff; line-height: 1; }
        .dv-header .sub-label { font-size: 9px; color: var(--gold); letter-spacing: 5px; text-transform: uppercase; font-weight: 700; opacity: 0.5; display: block; margin-bottom: 8px; }
        .data-vault { background: var(--carbon); border-radius: 25px; border: 1px solid var(--border); padding: 10px; box-shadow: 0 30px 60px rgba(0,0,0,0.4); overflow: hidden; }
        table { width: 100%; border-collapse: collapse; }
        th { padding: 20px 25px; font-size: 10px; color: var(--gold); letter-spacing: 2px; text-transform: uppercase; text-align: left; opacity: 0.4; border-bottom: 1px solid var(--border); }
        td { padding: 20px 25px; border-bottom: 1px solid rgba(255,255,255,0.03); font-size: 14px; color: #eee; transition: 0.3s; }
        tr:hover td { background: rgba(255,255,255,0.01); }
        .user-flex { display: flex; align-items: center; gap: 15px; }
        .avatar-box { width: 42px; height: 42px; border-radius: 12px; background: var(--carbon-light); border: 1px solid var(--border); overflow: hidden; }
        .avatar-box img { width: 100%; height: 100%; object-fit: cover; }
        .badge { padding: 5px 14px; border-radius: 50px; font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
        .badge-admin { background: var(--gold); color: var(--onyx); }
        .badge-customer { border: 1px solid var(--border); color: #888; }
        .btn-prime { padding: 14px 28px; background: var(--gold); color: var(--onyx); border-radius: 12px; border: none; font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; cursor: pointer; transition: 0.3s; }
        .btn-icon { width: 38px; height: 38px; border-radius: 10px; background: var(--carbon-light); border: 1px solid var(--border); color: #666; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; }
        .btn-icon:hover { color: var(--gold); border-color: var(--gold); }
        .btn-del:hover { color: var(--danger) !important; border-color: var(--danger) !important; }

        /* Modal refined */
        .modal { display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, 0.85); z-index: 10000; align-items: center; justify-content: center; backdrop-filter: blur(10px); padding: 15px; }
        .modal-content { background: #0d0d0d; width: 100%; max-width: 400px; border-radius: 24px; border: 1px solid rgba(245, 222, 179, 0.15); padding: 35px; position: relative; animation: modalEntrance 0.4s ease; }
        @keyframes modalEntrance { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
        .form-label { font-size: 9px; color: var(--gold); text-transform: uppercase; letter-spacing: 1.5px; font-weight: 700; display: block; margin-bottom: 8px; }
        .form-input { width: 100%; background: #050505; border: 1px solid rgba(255, 255, 255, 0.08); padding: 12px 16px; border-radius: 12px; color: #fff; font-size: 13px; margin-bottom: 15px; }
        
        @media (max-width: 768px) {
            table, thead, tbody, th, td, tr { display: block; }
            thead { display: none; }
            tr { background: var(--carbon); border: 1px solid var(--border); border-radius: 20px; padding: 20px; margin-bottom: 20px; }
            td { text-align: right; padding: 12px 0; position: relative; border-bottom: 1px solid rgba(255,255,255,0.05); display: flex; justify-content: space-between; align-items: center; }
            td::before { content: attr(data-label); font-size: 9px; text-transform: uppercase; color: var(--gold); opacity: 0.5; font-weight: 700; }
        }
    </style>
</head>
<body>

    <div class="sidebar-overlay" id="overlay" onclick="toggleSidebar()"></div>

    <aside class="sidebar" id="sidebar">
        <div class="side-close" onclick="toggleSidebar()"><i class="fas fa-times"></i></div>
        <div class="side-brand">
            <h2>Coffee Time</h2>
            <p>Master Console</p>
        </div>
        
        <ul class="side-nav">
            <li><a href="<?= base_url('admin') ?>" class="<?= (url_is('admin')) ? 'active' : '' ?>"><i class="fas fa-chart-line"></i> Overview</a></li>
            <li><a href="<?= base_url('admin/orders') ?>" class="<?= (url_is('admin/orders*')) ? 'active' : '' ?>"><i class="fas fa-receipt"></i> Reservations 
                <?php if(isset($new_orders) && $new_orders > 0): ?><span class="nav-badge" style="background:var(--success); color:#fff"><?= $new_orders ?></span><?php endif; ?>
            </a></li>
            <li><a href="<?= base_url('admin/products') ?>" class="<?= (url_is('admin/products*')) ? 'active' : '' ?>"><i class="fas fa-coffee"></i> Product Catalog</a></li>
            <li><a href="<?= base_url('admin/journal') ?>" class="<?= (url_is('admin/journal*')) ? 'active' : '' ?>"><i class="fas fa-feather-pointed"></i> Roast Journal</a></li>
            <li><a href="<?= base_url('admin/gallery') ?>" class="<?= (url_is('admin/gallery*')) ? 'active' : '' ?>"><i class="fas fa-images"></i> Visual Archive</a></li>
            <li><a href="<?= base_url('admin/inbox') ?>" class="<?= (url_is('admin/inbox*')) ? 'active' : '' ?>"><i class="fas fa-envelope-open-text"></i> Concierge Inbox 
                <?php if(isset($new_messages) && $new_messages > 0): ?><span class="nav-badge" style="background:var(--success); color:#fff"><?= $new_messages ?></span><?php endif; ?>
            </a></li>
            <li><a href="<?= base_url('admin/users') ?>" class="<?= (url_is('admin/users*')) ? 'active' : '' ?>"><i class="fas fa-user-shield"></i> Access Control</a></li>
        </ul>
        
        <div class="side-footer">
            <a href="<?= base_url('auth/logout') ?>" class="logout-btn"><i class="fas fa-power-off"></i> Terminate Control</a>
        </div>
    </aside>

    <main class="workspace">
        <div class="container-limited">
            <div class="mobile-top-bar">
                <div class="hamb-trigger" onclick="toggleSidebar()"><i class="fas fa-bars-staggered"></i></div>
                <h2 style="font-family: 'Dancing Script', cursive; color:var(--gold); font-size: 1.5rem;">Coffee Time</h2>
                <div style="width: 45px;"></div> 
            </div>

            <!-- AREA KONTEN UTAMA -->
            <?= $this->renderSection('content') ?>

        </div>
    </main>

    <script>
        function toggleSidebar() { 
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }

        window.addEventListener('resize', () => {
            if(window.innerWidth > 1100) {
                document.getElementById('sidebar').classList.remove('active');
                document.getElementById('overlay').classList.remove('active');
            }
        });

        let lastOrders = <?= (int)($new_orders ?? 0) ?>;
        let lastMessages = <?= (int)($new_messages ?? 0) ?>;

        function showToast(icon, title, text) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: icon,
                title: title,
                text: text,
                showConfirmButton: false,
                timer: 3500,
                timerProgressBar: true,
                background: '#0d0d0d',
                color: '#f5deb3'
            });
        }

        async function checkNotifications() {
            try {
                const res = await fetch('<?= base_url('admin/notifications') ?>');
                const data = await res.json();

                // 🔔 ORDER BARU
                if (data.orders > lastOrders) {
                    showToast(
                        'success',
                        `${data.orders - lastOrders} new reservation(s)`,
                        'Incoming order requires action'
                    );
                    lastOrders = data.orders;
                }

                // 📩 MESSAGE BARU
                if (data.messages > lastMessages) {
                    showToast(
                        'info',
                        `${data.messages - lastMessages} new message(s)`,
                        'Unread concierge inbox'
                    );
                    lastMessages = data.messages;
                }

            } catch (e) {
                console.warn('Notification check failed');
            }
        }

        // ⏱ CEK TIAP 15 DETIK
        setInterval(checkNotifications, 15000);
    </script>
    <!-- AREA SCRIPTS HALAMAN -->
    <?= $this->renderSection('scripts') ?>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Story | Coffee Time</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@600;700&family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400&family=Poppins:wght@200;300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- Icons & Anim -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <!-- Library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* 
        ========================================================================
        I. DESIGN SYSTEM (MASTER CONSISTENCY)
        ========================================================================
        */
        :root {
            --onyx: #070404;          
            --dark-gray: #120b0c;
            --gold: #f5deb3;         
            --gold-soft: rgba(245, 222, 179, 0.6);
            --gold-low: rgba(245, 222, 179, 0.1);
            --white: #ffffff;
            --header-h: 90px;
            --transit: cubic-bezier(0.23, 1, 0.32, 1);
            --z-nav: 8000;
            --z-sidebar: 9000;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; -webkit-tap-highlight-color: transparent; }
        html { scroll-behavior: smooth; overflow-x: hidden; }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--onyx);
            color: var(--gold);
            line-height: 1.8;
            overflow-x: hidden;
        }

        /* TEXTURE OVERLAY */
        body::after {
            content: ""; position: fixed; inset: 0;
            background-image: url("https://www.transparenttextures.com/patterns/black-linen.png");
            opacity: 0.15; pointer-events: none; z-index: 99999;
        }

        h1, h2, h3, h4 { font-family: 'Playfair Display', serif; color: var(--white); font-weight: 700; }
        .hand { font-family: 'Dancing Script', cursive; }
        a { text-decoration: none; color: inherit; transition: 0.4s var(--transit); }
        ul { list-style: none; }

        .reveal { opacity: 0; transform: translateY(60px); transition: 1.5s var(--transit); }
        .reveal.active { opacity: 1; transform: translateY(0); }

        /* 
        ========================================================================
        II. STICKY NAVIGATION (RESTORED SEARCH ICON)
        ========================================================================
        */
        header {
            position: fixed; top: 0; left: 0; width: 100%; height: var(--header-h);
            z-index: var(--z-nav); display: flex; align-items: center;
            background: linear-gradient(to bottom, rgba(7,4,4,0.9), transparent);
            transition: 0.6s var(--transit);
        }

        header.scrolled {
            height: 75px; background: rgba(7,4,4,0.98);
            backdrop-filter: blur(20px); border-bottom: 1px solid var(--gold-low);
            box-shadow: 0 10px 50px rgba(0,0,0,0.8);
        }

        nav {
            width: 100%; max-width: 1500px; margin: auto; padding: 0 50px;
            display: grid; grid-template-columns: 1fr auto 1fr; align-items: center;
        }

        .brand { display: flex; align-items: center; gap: 15px; font-family: 'Dancing Script', cursive; font-size: 32px; color: var(--gold); justify-self: start; }
        .brand i { font-size: 24px; filter: drop-shadow(0 0 10px rgba(245,222,179,0.5)); }

        .nav-menu { display: flex; gap: 35px; justify-content: center; }
        .nav-menu a {
            font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 2.5px;
            opacity: 0.5; position: relative; padding-bottom: 5px;
        }
        .nav-menu a:hover, .nav-menu a.active { opacity: 1; color: var(--white); }
        .nav-menu a::after { content: ""; position: absolute; left: 50%; bottom: 0; width: 0; height: 1.5px; background: var(--gold); transition: 0.4s; transform: translateX(-50%); }
        .nav-menu a:hover::after, .nav-menu a.active::after { width: 100%; }

        .nav-extra { display: flex; align-items: center; gap: 25px; justify-self: end; }
        .nav-extra i { font-size: 19px; transition: 0.3s; }
        .nav-extra i:hover { transform: translateY(-4px) scale(1.1); color: var(--white); }

        .hamb-btn { width: 45px; height: 45px; display: none; cursor: pointer; flex-direction: column; justify-content: center; align-items: center; gap: 7px; background: var(--gold-low); border-radius: 50%; transition: 0.3s; }
        .hamb-btn span { width: 22px; height: 1.5px; background: var(--gold); transition: 0.4s; }

        /* 
        ========================================================================
        III. MOBILE PANEL (CENTERED)
        ========================================================================
        */
        .panel-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.9); backdrop-filter: blur(15px); z-index: 8500; opacity: 0; visibility: hidden; transition: 0.6s; }
        .panel-overlay.active { opacity: 1; visibility: visible; }

        .mobile-panel {
            position: fixed; top: 0; right: -100%; width: 100%; max-width: 450px; height: 100vh;
            background: var(--onyx); z-index: var(--z-sidebar); padding: 100px 40px;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            transition: 0.8s var(--transit); border-left: 1px solid var(--gold-low);
        }
        .mobile-panel.active { right: 0; }

        .panel-links { text-align: center; width: 100%; }
        .panel-links li { margin-bottom: 30px; opacity: 0; transform: translateY(30px); transition: 0.6s; }
        .mobile-panel.active .panel-links li { opacity: 1; transform: translateY(0); }

        /* Staggered Anim */
        .mobile-panel.active li:nth-child(1) { transition-delay: 0.1s; }
        .mobile-panel.active li:nth-child(2) { transition-delay: 0.2s; }
        .mobile-panel.active li:nth-child(3) { transition-delay: 0.3s; }
        .mobile-panel.active li:nth-child(4) { transition-delay: 0.4s; }
        .mobile-panel.active li:nth-child(5) { transition-delay: 0.5s; }
        .mobile-panel.active li:nth-child(6) { transition-delay: 0.6s; }

        .panel-links a { font-family: 'Playfair Display', serif; font-size: 2.8rem; font-weight: 700; color: var(--white); display: block; }
        .panel-links a:hover { color: var(--gold); letter-spacing: 5px; }
        .panel-close { position: absolute; top: 40px; right: 40px; font-size: 30px; cursor: pointer; transition: 0.4s; }

        /* 
        ========================================================================
        IV. STORY PAGE SECTIONS
        ========================================================================
        */
        
        /* HERO */
        .story-hero { height: 75vh; position: relative; display: flex; align-items: center; justify-content: center; text-align: center; overflow: hidden; }
        .hero-bg { position: absolute; inset: 0; z-index: 1; background: linear-gradient(rgba(7,4,4,0.4), var(--onyx)), url('https://images.unsplash.com/photo-1447933601403-0c6688de566e?auto=format&fit=crop&w=1920&q=80') center/cover; filter: brightness(0.4); transform: scale(1.1); transition: 1.5s var(--transit); }
        .hero-inner { position: relative; z-index: 5; margin-top: 150px; animation: floatingHero 6s infinite ease-in-out; }
        @keyframes floatingHero { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-20px); } }
        .hero-inner h1 { font-family: 'Dancing Script', cursive; font-size: clamp(4rem, 12vw, 7.5rem); color: var(--gold); }
        .hero-inner p { font-size: 13px; letter-spacing: 10px; text-transform: uppercase; color: var(--gold-soft); font-weight: 600; }

        /* THE LEGACY TEXT */
        .section { padding: 150px 60px; max-width: 1500px; margin: auto; }
        .legacy-grid { display: grid; grid-template-columns: 1fr 1.2fr; gap: 100px; align-items: center; }
        .legacy-content { position: relative; }
        .dec-num { font-family: 'Playfair Display'; font-size: 12rem; position: absolute; top: -100px; left: -50px; color: var(--gold-low); z-index: -1; font-weight: 900; }
        .legacy-img-box { border-radius: 40px; overflow: hidden; border: 1px solid var(--gold-low); box-shadow: 0 40px 80px rgba(0,0,0,0.6); }
        .legacy-img-box img { width: 100%; transition: 1.5s var(--transit); }
        .legacy-img-box:hover img { transform: scale(1.1); filter: contrast(1.1); }

        /* 1. INFINITE ATMOSPHERE LOOP */
        .loop-section { width: 100%; overflow: hidden; background: var(--dark-gray); padding: 100px 0; border-top: 1px solid var(--gold-low); border-bottom: 1px solid var(--gold-low); }
        .loop-track { display: flex; width: calc(400px * 12); animation: scrollAtmos 45s linear infinite; gap: 40px; }
        .loop-item { width: 400px; height: 500px; flex-shrink: 0; border-radius: 30px; overflow: hidden; border: 1px solid var(--gold-low); filter: grayscale(80%); transition: 0.8s var(--transit); }
        .loop-item:hover { filter: grayscale(0%); border-color: var(--gold); transform: scale(1.05) translateY(-10px); z-index: 5; }
        .loop-item img { width: 100%; height: 100%; object-fit: cover; }
        @keyframes scrollAtmos { 0% { transform: translateX(0); } 100% { transform: translateX(calc(-400px * 6)); } }

        /* 2. INFINITE ARCHITECTS LOOP */
        .architects-section { padding: 150px 0; overflow: hidden; background: var(--onyx); text-align: center; }
        .architect-track { display: flex; width: calc(420px * 10); animation: scrollArch 35s linear infinite; gap: 50px; padding: 50px 0; }
        .architect-track:hover { animation-play-state: paused; }

        .contrib-card {
            width: 380px; flex-shrink: 0; background: var(--dark-gray); border: 1px solid var(--gold-low);
            padding: 70px 45px; border-radius: 50px; transition: 0.6s var(--transit);
            text-align: center; backdrop-filter: blur(15px); position: relative;
        }
        .contrib-card:hover { transform: translateY(-30px); border-color: var(--gold); box-shadow: 0 40px 80px rgba(0,0,0,0.8); }
        .contrib-card img { width: 140px; height: 140px; border-radius: 50%; border: 3px solid var(--gold); margin-bottom: 30px; object-fit: cover; padding: 6px; }
        .contrib-card h3 { font-size: 2rem; margin-bottom: 8px; color: var(--white); }
        .contrib-card span { font-size: 11px; text-transform: uppercase; letter-spacing: 5px; color: var(--gold-soft); display: block; margin-bottom: 30px; font-weight: 700; }
        
        .contrib-socials { display: flex; justify-content: center; gap: 20px; padding-top: 25px; border-top: 1px solid var(--gold-low); }
        .contrib-socials a { font-size: 20px; color: var(--gold-soft); transition: 0.4s; }
        .contrib-socials a:hover { color: var(--white); transform: translateY(-5px); }

        @keyframes scrollArch { 0% { transform: translateX(0); } 100% { transform: translateX(calc(-420px * 5)); } }

        /* 
        ========================================================================
        V. RICH FOOTER SYSTEM (MASTER CONSISTENCY)
        ========================================================================
        */
        footer { background: #060404; border-top: 1px solid var(--gold-low); padding: 120px 60px 40px; position: relative; }
        .footer-grid { max-width: 1600px; margin: auto; display: grid; grid-template-columns: 1.5fr 1fr 1fr 1.5fr; gap: 80px; }

        .f-brand h2 { font-family: 'Dancing Script', cursive; font-size: 50px; color: var(--gold); margin-bottom: 25px; }
        .f-desc { opacity: 0.5; font-size: 14px; max-width: 350px; margin-bottom: 30px; line-height: 2; }
        
        .f-socials { display: flex; gap: 20px; }
        .f-socials a { width: 45px; height: 45px; border: 1px solid var(--gold-low); border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: 0.4s; font-size: 18px; }
        .f-socials a:hover { background: var(--gold); color: var(--onyx); transform: translateY(-5px) rotate(360deg); }

        .f-title { font-size: 13px; text-transform: uppercase; letter-spacing: 3px; color: var(--white); margin-bottom: 40px; font-weight: 700; }
        
        .f-links li { margin-bottom: 18px; }
        .f-links a { font-size: 14px; opacity: 0.4; font-weight: 300; transition: 0.3s; }
        .f-links a:hover { opacity: 1; padding-left: 10px; color: var(--gold); }

        .f-contact p { font-size: 14px; opacity: 0.6; margin-bottom: 15px; display: flex; align-items: center; gap: 15px; }
        .f-contact i { color: var(--gold); width: 20px; text-align: center; }

        .f-newsletter p { font-size: 13px; opacity: 0.5; margin-bottom: 25px; }
        .f-newsletter input { width: 100%; background: transparent; border: none; border-bottom: 1px solid var(--gold-low); padding: 15px 0; color: #fff; outline: none; transition: 0.3s; font-family: inherit; }
        .f-newsletter input:focus { border-color: var(--gold); }
        .f-btn { margin-top: 30px; display: inline-block; padding: 12px 35px; background: var(--gold); color: var(--onyx); font-size: 11px; font-weight: 800; border-radius: 50px; text-transform: uppercase; letter-spacing: 2px; cursor: pointer; transition: 0.3s; }
        .f-btn:hover { background: var(--white); transform: translateY(-3px); box-shadow: 0 10px 20px rgba(255,255,255,0.1); }

        .footer-bottom { text-align: center; margin-top: 100px; padding-top: 40px; border-top: 1px solid var(--gold-low); font-size: 11px; opacity: 0.3; letter-spacing: 2px; text-transform: uppercase; }

        /* USER DROPDOWN STYLING */
        .user-profile-wrap { 
            position: relative; 
            z-index: 10001; /* Pastikan di atas segalanya */
        }

        .user-trigger { 
            display: flex; 
            align-items: center; 
            gap: 12px; 
            cursor: pointer; 
            padding: 6px 18px; 
            background: transparent; 
            border-radius: 100px; /* Pill Shape */
            border: 1px solid transparent; 
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
            box-shadow: 0 4px 15px transparent;
        }

        .user-trigger:hover { 
            background: transparent; 
            border-color: transparent;
            box-shadow: 0 0 20px transparent;
            transform: translateY(-2px);
        }

        .user-trigger i:first-child {
            font-size: 20px;
            color: var(--gold);
            filter: drop-shadow(0 0 5px rgba(245, 222, 179, 0.3));
        }

        .user-alias { 
            font-size: 10px; 
            font-weight: 800; 
            text-transform: uppercase; 
            letter-spacing: 2px; 
            color: var(--white);
            text-shadow: 0 2px 4px rgba(0,0,0,0.5);
        }

        /* Animasi Putar Panah saat Dropdown Aktif */
        .user-trigger .fa-chevron-down {
            font-size: 8px;
            transition: 0.4s var(--transit);
            opacity: 0.5;
        }
        .user-dropdown.active ~ .user-trigger .fa-chevron-down,
        .user-profile-wrap:has(.user-dropdown.active) .fa-chevron-down {
            transform: rotate(180deg);
            opacity: 1;
        }

        /* --- DROPDOWN PANEL (GLASSMORPHISM 2.0) --- */
        .user-dropdown {
            position: absolute; 
            top: calc(100% + 15px); 
            right: 0; 
            width: 240px;
            background: rgba(14, 9, 10, 0.85); /* Ultra Dark Coffee */
            backdrop-filter: blur(25px) saturate(150%);
            -webkit-backdrop-filter: blur(25px) saturate(150%);
            border: 1px solid rgba(245, 222, 179, 0.2);
            border-radius: 22px; 
            padding: 12px; 
            box-shadow: 0 30px 100px rgba(0,0,0,0.9), 
                        inset 0 0 20px rgba(245, 222, 179, 0.03);
            opacity: 0; 
            visibility: hidden; 
            transform: translateY(15px) scale(0.95);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            transform-origin: top right;
        }

        .user-dropdown.active { 
            opacity: 1; 
            visibility: visible; 
            transform: translateY(0) scale(1); 
        }

        /* Item Links */
        .user-dropdown a {
            display: flex; 
            align-items: center; 
            gap: 14px; 
            padding: 12px 16px;
            font-size: 11px; 
            font-weight: 600;
            text-transform: uppercase; 
            letter-spacing: 1.5px;
            color: rgba(255,255,255,0.6); 
            border-radius: 14px; 
            transition: all 0.3s var(--transit);
            position: relative;
            overflow: hidden;
        }

        .user-dropdown a i { 
            font-size: 16px; 
            width: 24px; 
            text-align: center; 
            color: var(--gold-soft);
            transition: 0.3s;
        }

        /* Hover Effect: Sweep Background */
        .user-dropdown a:hover { 
            background: rgba(245, 222, 179, 0.08); 
            color: var(--gold); 
            padding-left: 22px; 
        }

        .user-dropdown a:hover i {
            color: var(--white);
            transform: scale(1.1);
            filter: drop-shadow(0 0 8px var(--gold-soft));
        }

        /* Logout Special Treatment */
        .drop-divider { 
            height: 1px; 
            background: linear-gradient(90deg, transparent, rgba(245, 222, 179, 0.1), transparent); 
            margin: 8px 0; 
        }

        .logout-link { 
            color: rgba(231, 76, 60, 0.6) !important; 
        }

        .logout-link:hover { 
            background: rgba(231, 76, 60, 0.1) !important; 
            color: #ff4757 !important; 
        }

        .logout-link i { color: inherit !important; }

        /* ========================================================================
        VII. RESPONSIVE ENGINE (REFINED)
        ======================================================================== */

        @media (max-width: 1200px) {
            nav { 
                padding: 0 25px; 
                grid-template-columns: 1fr auto; /* Hanya Brand dan Nav-Extra */
            }
            
            .nav-menu { display: none; } /* Menu utama pindah ke sidebar */
            
            /* TAMPILAN PROFILE TETAP ADA DI MOBILE */
            .nav-extra { 
                display: flex; 
                gap: 15px; 
                align-items: center; 
            }

            .user-alias { 
                font-size: 10px; 
                max-width: 80px; /* Batasi panjang nama agar tidak merusak layout */
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }

            .user-trigger { 
                padding: 8px 15px; 
                background: var(--gold-low); 
                border: 1px solid var(--border);
            }

            /* FIX: Aktifkan kembali dropdown di mobile */
            .user-dropdown { 
                display: block; /* Hapus display: none */
                position: absolute;
                top: calc(100% + 10px);
                right: 0; /* Menempel ke kanan container nav-extra */
                width: 210px;
                z-index: 10000;
            }

            .hamb-btn { 
                display: flex; 
                order: 2; /* Pastikan hamburger paling kanan */
            }

            .footer-grid { grid-template-columns: 1fr 1fr; gap: 60px; }
            .flex-box { flex-direction: column; text-align: center; }
            .hero-inner { margin-top: 100px; }
        }

        @media (max-width: 768px) {
            .hero h1 { font-size: 3.2rem; }
            .section { padding: 80px 20px; }
            
            /* Layout HP Portrait */
            .user-alias, .user-trigger i:last-child { 
                display: none; /* Sembunyikan nama & panah kecil agar tidak sesak */
            }
            
            .user-trigger {
                width: 42px; 
                height: 42px; 
                padding: 0; 
                justify-content: center;
                border-radius: 50%;
            }

            .user-dropdown {
                right: -10px; /* Geser sedikit agar pas dengan tepi layar HP */
                width: 190px;
            }

            .footer-grid { grid-template-columns: 1fr; text-align: center; }
            .f-contact p { justify-content: center; }
            .mobile-panel { max-width: 100%; }
            .f-socials { justify-content: center; }

            .steam {
                height: 120px;
                filter: blur(16px);
            }
        }

        /* RESPONSIVE */
        @media (max-width: 1200px) {
            nav { padding: 0 30px; grid-template-columns: 1fr auto; }
            .nav-menu { display: none; }
            .hamb-btn { display: flex; }
            .legacy-grid { grid-template-columns: 1fr; text-align: center; }
            .dec-num { display: none; }
            .footer-grid { grid-template-columns: 1fr 1fr; gap: 60px; }
        }
        @media (max-width: 768px) {
            .hero-inner { margin-top: 130px; }
            .footer-grid { grid-template-columns: 1fr; text-align: center; }
            .mobile-panel { max-width: 100%; }
            .f-contact p { justify-content: center; }
            .section { padding: 80px 25px; }
            .f-socials { justify-content: center; }
        }
    </style>
</head>
<body>
    <!-- 1. NAVIGATION (SEARCH ICON RESTORED) -->
    <header id="navbar">
        <nav>
            <a href="<?= base_url('/') ?>" class="brand">
                <i class="fas fa-mug-hot"></i><span>Coffee Time</span>
            </a>

            <!-- Desktop Navigation -->
            <ul class="nav-menu">
                <li><a href="<?= base_url('/') ?>">Home</a></li>
                <li><a href="<?= base_url('menu') ?>">Menu</a></li>
                <li><a href="<?= base_url('gallery')?>">Gallery</a></li>
                <li><a href="<?= base_url('blog') ?>">Journal</a></li>
                <li><a href="<?= base_url('about') ?>" class="active">Story</a></li>
                <li><a href="<?= base_url('contact') ?>">Contact</a></li>
            </ul>

             <div class="nav-extra">
                <?php if(session()->get('is_logged_in')): ?>
                    <!-- USER DROPDOWN SYSTEM -->
                    <div class="user-profile-wrap">
                        <div class="user-trigger" id="userTrigger">
                            <i class="fas fa-user-circle"></i>
                            <span class="user-alias"><?= session()->get('user_name') ?></span>
                            <i class="fas fa-chevron-down" style="font-size: 8px; opacity: 0.5;"></i>
                        </div>
                        
                        <div class="user-dropdown" id="userDropdown">
                            <a href="<?= base_url('user/history') ?>"><i class="fas fa-history"></i> My Orders</a>
                            <a href="<?= base_url('user/profile') ?>"><i class="fas fa-cog"></i> Settings</a>
                            <div class="drop-divider"></div>
                            <a href="<?= base_url('auth/logout') ?>" class="logout-link"><i class="fas fa-power-off"></i> Terminate Session</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="<?= base_url('auth/login') ?>" class="login-trigger">
                        <i class="fas fa-user-circle"></i>
                    </a>
                <?php endif; ?>

                <div class="hamb-btn" id="open-panel">
                    <span></span><span></span><span></span>
                </div>
            </div>
        </nav>
    </header>

    <!-- 2. MOBILE PANEL (CONSISTENT) -->
    <div class="panel-overlay" id="overlay"></div>
    <aside class="mobile-panel" id="panel">
        <div class="panel-close" id="close-panel"><i class="fas fa-times"></i></div>
        <ul class="panel-links">
            <li><a href="<?= base_url('/') ?>">Home</a></li>
            <li><a href="<?= base_url('menu') ?>">Menu</a></li>
            <li><a href="<?= base_url('gallery') ?>">Gallery</a></li>
            <li><a href="<?= base_url('blog') ?>">Journal</a></li>
            <li><a href="<?= base_url('about') ?>">About</a></li>
            <li><a href="<?= base_url('contact') ?>">Contact</a></li>
        </ul>
        <div class="hand" style="margin-top: 60px; font-size: 24px; color: var(--gold-soft);">Coffee Time.</div>
    </aside>

    <!-- 3. STORY HERO -->
    <section class="story-hero">
        <div class="hero-bg" id="parallax-bg"></div>
        <div class="hero-inner">
            <p>THE ULTIMATE ESTATE ROASTERY</p>
            <h1 class="animate__animated animate__fadeInUp">Our Legacy</h1>
        </div>
    </section>

    <!-- 4. LEGACY SECTION -->
    <section class="section">
        <div class="legacy-grid">
            <div class="legacy-img-box reveal">
                <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&w=800&q=80" alt="The Roast">
            </div>
            <div class="legacy-content reveal">
                <div class="dec-num">01</div>
                <span class="hand" style="font-size: 32px; color: var(--gold);">Est. 2025</span>
                <h2 style="font-size: 4rem; margin-top: 20px; line-height: 1.1;">The Art of Pure Dedication.</h2>
                <p style="margin-top: 30px; font-size: 1.1rem;">Kami percaya bahwa kopi adalah jembatan antara alam dan manusia. Coffee Time didirikan untuk menghidupkan kembali tradisi sangrai manual yang dipadukan dengan standar kualitas modern tertinggi. Setiap biji yang kami pilih menceritakan kisah dari tanah tempatnya bermuara.</p>
            </div>
        </div>
    </section>

    <!-- 5. ATMOSPHERE INFINITE LOOP -->
    <section class="loop-section">
        <div class="loop-track">

            <?php if (!empty($atmospheres)): ?>
                <?php foreach ($atmospheres as $row): ?>
                    <?php
                        // Ambil gambar dari sumber yang sudah ada
                        $img = ($row['source_type'] === 'gallery')
                            ? $row['gallery_image']
                            : $row['product_image'];
                    ?>
                    <div class="loop-item">
                        <img 
                            src="<?= esc($img) ?>" 
                            alt="Atmosphere"
                            onerror="this.src='https://dummyimage.com/400x500/111/f5deb3&text=Coffee+Time'">
                    </div>
                <?php endforeach; ?>

                <!-- DUPLIKASI LOOP (PENTING UNTUK ANIMASI INFINITE) -->
                <?php foreach ($atmospheres as $row): ?>
                    <?php
                        $img = ($row['source_type'] === 'gallery')
                            ? $row['gallery_image']
                            : $row['product_image'];
                    ?>
                    <div class="loop-item">
                        <img 
                            src="<?= esc($img) ?>" 
                            alt="Atmosphere">
                    </div>
                <?php endforeach; ?>

            <?php endif; ?>

        </div>
    </section>

    <!-- 6. DIGITAL ARCHITECTS INFINITE LOOP -->
    <section class="architects-section">
        <div class="reveal">
            <span class="hand" style="font-size: 35px; color: var(--gold);">The Digital Roastery</span>
            <h2 style="font-size: 4rem; margin-top: 20px;">Meet The Architects</h2>
            <p style="opacity: 0.6; margin-top: 15px;">Para pengrajin di balik layar yang membangun ekosistem digital Coffee Time.</p>
        </div>

        <div class="architect-container">
            <div class="architect-track">
                <!-- 5 Architects -->
                <div class="contrib-card">
                    <img src="https://raw.githubusercontent.com/Ranggis/Api-Image/main/ranggis.jpg" alt="Dev 1">
                    <h3>Ranggis</h3>
                    <span>Lead Architect</span>
                    <div class="contrib-socials">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-github"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="contrib-card">
                    <img src="https://raw.githubusercontent.com/Ranggis/Api-Image/main/salwa.jpg" alt="Dev 2">
                    <h3>Salwa</h3>
                    <span>UX Curator</span>
                    <div class="contrib-socials">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-github"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="contrib-card">
                    <img src="https://raw.githubusercontent.com/Ranggis/Api-Image/main/faishal.jpg" alt="Dev 3">
                    <h3>Faishal</h3>
                    <span>Backend Master</span>
                    <div class="contrib-socials">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-github"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="contrib-card">
                    <img src="https://raw.githubusercontent.com/Ranggis/Api-Image/main/Coffee%20Time.png" alt="Dev 4">
                    <h3>Kayla</h3>
                    <span>Brand Visionary</span>
                    <div class="contrib-socials">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-github"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="contrib-card">
                    <img src="https://raw.githubusercontent.com/Ranggis/Api-Image/main/Coffee%20Time.png" alt="Dev 5">
                    <h3>Rizzi</h3>
                    <span>Motion Designer</span>
                    <div class="contrib-socials">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-github"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <!-- Duplicate for Loop -->
                <div class="contrib-card">
                    <img src="https://raw.githubusercontent.com/Ranggis/Api-Image/main/ranggis.jpg" alt="Dev 1">
                    <h3>Ranggis</h3>
                    <span>Lead Architect</span>
                    <div class="contrib-socials">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-github"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="contrib-card">
                    <img src="https://raw.githubusercontent.com/Ranggis/Api-Image/main/salwa.jpg" alt="Dev 2">
                    <h3>Salwa</h3>
                    <span>UX Curator</span>
                    <div class="contrib-socials">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-github"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="contrib-card">
                    <img src="https://raw.githubusercontent.com/Ranggis/Api-Image/main/faishal.jpg" alt="Dev 3">
                    <h3>Faishal</h3>
                    <span>Backend Master</span>
                    <div class="contrib-socials">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-github"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="contrib-card">
                    <img src="https://raw.githubusercontent.com/Ranggis/Api-Image/main/Coffee%20Time.png" alt="Dev 4">
                    <h3>Kayla</h3>
                    <span>Brand Visionary</span>
                    <div class="contrib-socials">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-github"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="contrib-card">
                    <img src="https://raw.githubusercontent.com/Ranggis/Api-Image/main/Coffee%20Time.png" alt="Dev 5">
                    <h3>Rizzi</h3>
                    <span>Motion Designer</span>
                    <div class="contrib-socials">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-github"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 7. FOOTER (CONSISTENT) -->
    <footer>
        <div class="footer-grid">
            <div class="f-brand">
                <h2>Coffee Time</h2>
                <p class="f-desc">Membawa standar baru dalam industri roastery lokal. Kami memadukan estetika, rasa, dan komunitas dalam satu wadah elegan.</p>
                <div class="f-socials">
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>

            <div class="f-links">
                <h4 class="f-title">Quick Links</h4>
                <ul>
                    <li><a href="<?= base_url('/') ?>">Home Estate</a></li>
                    <li><a href="<?= base_url('menu') ?>">Selection Menu</a></li>
                    <li><a href="<?= base_url('gallery') ?>">Gallery Art</a></li>
                    <li><a href="<?= base_url('blog') ?>">Roast Journal</a></li>
                </ul>
            </div>

            <div class="f-contact">
                <h4 class="f-title">Information</h4>
                <p><i class="fas fa-map-marker-alt"></i> Sudirman Tower, LV 25, Jakarta</p>
                <p><i class="fas fa-phone-alt"></i> +62 21 3456 7890</p>
                <p><i class="fas fa-envelope"></i> reserve@coffeetime.id</p>
                <p><i class="fas fa-clock"></i> Mon-Sun | 08:00 - 22:00</p>
            </div>

            <div class="f-newsletter">
                <h4 class="f-title">Newsletter</h4>
                <p>Dapatkan info perilisan Private Collection beans kami setiap bulan.</p>
                <input type="email" placeholder="Your Luxury Email">
                <div class="f-btn">Subscribe</div>
            </div>
        </div>
        
        <div class="footer-bottom">
            &copy; 2025 COFFEE TIME PRIVATE LIMITED. CRAFTED BY THE MASTER BREWERS.
        </div>
    </footer>

    <script>
        /** 1. PARALLAX & NAV SCROLL **/
        window.addEventListener('scroll', () => {
            const scroll = window.scrollY;
            document.getElementById('navbar').classList.toggle('scrolled', scroll > 50);
            const bg = document.getElementById('parallax-bg');
            if(bg) bg.style.transform = `scale(1.1) translateY(${scroll * 0.35}px)`;
            
            document.querySelectorAll('.reveal').forEach(el => {
                if(el.getBoundingClientRect().top < window.innerHeight - 80) el.classList.add('active');
            });
        });

        /** 2. MOBILE PANEL **/
        const open = document.getElementById('open-panel');
        const close = document.getElementById('close-panel');
        const panel = document.getElementById('panel');
        const overlay = document.getElementById('overlay');

        function togglePanel(status) {
            panel.classList.toggle('active', status);
            overlay.classList.toggle('active', status);
            document.body.style.overflow = status ? 'hidden' : 'auto';
        }

        open.onclick = () => togglePanel(true);
        close.onclick = () => togglePanel(false);
        overlay.onclick = () => togglePanel(false);
        
        document.querySelectorAll('.panel-links a').forEach(a => {
            a.addEventListener('click', () => togglePanel(false));
        });

        // Toggle User Dropdown
        const userTrigger = document.getElementById('userTrigger');
        const userDropdown = document.getElementById('userDropdown');

        if(userTrigger) {
            userTrigger.onclick = (e) => {
                e.stopPropagation(); // Biar klik dropdown nggak nutup dropdown itu sendiri
                userDropdown.classList.toggle('active');
            };
        }

        // Tutup dropdown kalau klik di luar
        window.addEventListener('click', () => {
            if(userDropdown && userDropdown.classList.contains('active')) {
                userDropdown.classList.remove('active');
            }
        });
    </script>
    <?= view('partials/flash') ?>
</body>
</html>
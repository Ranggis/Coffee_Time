<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact | Coffee Time</title>

    <!-- Google Fonts Ecosystem -->
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@600;700&family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400&family=Poppins:wght@200;300;400;500;600&display=swap" rel="stylesheet">
        
    <!-- Icons & Animation Libraries -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* 
        ========================================================================
        I. DESIGN SYSTEM (MASTER CLASS)
        ========================================================================
        */
        :root {
                --onyx: #070404;          
                --carbon: #120b0c;
                --gold: #f5deb3;         
                --gold-60: rgba(245, 222, 179, 0.6);
                --gold-low: rgba(245, 222, 179, 0.1);
                --pure: #ffffff;
                --header-h: 90px;
                --transit: cubic-bezier(0.23, 1, 0.32, 1);
                --transit-luxe: cubic-bezier(0.19, 1, 0.22, 1);
                --z-nav: 8000;
                --z-sidebar: 9000;
                --white: #ffffff; /* FIX footer hover */
        }

        /* MASTER RESET */
        * { margin: 0; padding: 0; box-sizing: border-box; -webkit-tap-highlight-color: transparent; outline: none; }
        html { scroll-behavior: smooth; overflow-x: hidden; }

        body {
                font-family: 'Poppins', sans-serif;
                background-color: var(--onyx);
                color: var(--gold);
                line-height: 1.8;
                overflow-x: hidden;
        }
        @keyframes fadeInBody { to { opacity: 1; } }

            /* LUXURY TEXTURE OVERLAY */
        body::after {
                content: ""; position: fixed; inset: 0;
                background-image: url("https://www.transparenttextures.com/patterns/black-paper.png");
                opacity: 0.08; pointer-events: none; z-index: 99999;
        }

        h1, h2, h3, h4 { font-family: 'Playfair Display', serif; color: var(--pure); font-weight: 700; }
        .hand { font-family: 'Dancing Script', cursive; }
        a { text-decoration: none; color: inherit; transition: 0.4s var(--transit-luxe); }
        ul { list-style: none; }

        .reveal { opacity: 0; transform: translateY(50px); transition: 1.2s var(--transit-luxe); }
        .reveal.active { opacity: 1; transform: translateY(0); }

        /* 
        ========================================================================
        II. STICKY NAVIGATION (SAME AS HOME)
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
        III. MOBILE SIDEBAR (RIGHT SLIDE)
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
        IV. CONTACT HERO (SAFE AREA VISIBILITY)
        ========================================================================
        */
        .contact-hero { height: 70vh; position: relative; display: flex; align-items: center; justify-content: center; text-align: center; overflow: hidden; }
        .hero-bg { position: absolute; inset: 0; z-index: 1; background: linear-gradient(rgba(7,4,4,0.45), var(--onyx)), url('https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&w=1920&q=80') center/cover; filter: brightness(0.4); transform: scale(1.1); transition: 1.5s var(--transit-luxe); }
            
        .hero-inner { 
                position: relative; z-index: 5; max-width: 1000px; padding: 0 30px; 
                margin-top: calc(var(--header-h) - 10px); /* KEBAWAHIN AGAR TIDAK BENTROK NAVBAR */
                animation: floatingUI 6s infinite ease-in-out; 
        }
        @keyframes floatingUI { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-15px); } }

        .hero-inner h1 { font-family: 'Dancing Script', cursive; font-size: clamp(3.5rem, 8vw, 6.5rem); color: var(--gold); text-shadow: 0 10px 40px rgba(0,0,0,0.5); margin-bottom: 10px; }
        .hero-inner p { font-size: 13px; letter-spacing: 10px; text-transform: uppercase; color: var(--gold-soft); font-weight: 600; margin-bottom: 25px; }

        /* 
        ========================================================================
        V. CONTACT INTERFACE (PUSHED DOWN & STYLED)
        ========================================================================
        */
        .contact-section { max-width: 1400px; margin: 40px auto 120px; padding: 0 50px; position: relative; z-index: 20; }
            
        .contact-box {
                display: grid; grid-template-columns: 1fr 1.3fr;
                background: rgba(18, 11, 13, 0.85); backdrop-filter: blur(25px);
                border-radius: 40px; overflow: hidden; border: 1px solid var(--gold-low);
                box-shadow: 0 40px 100px rgba(0,0,0,0.7);
        }

        /* Column Info */
        .info-col { padding: 80px; background: linear-gradient(135deg, rgba(255,255,255,0.02), transparent); border-right: 1px solid var(--gold-low); }
        .info-col h2 { font-size: 3rem; margin-bottom: 25px; line-height: 1.1; color: var(--pure); }
        .info-col p.subtext { font-size: 1rem; opacity: 0.5; margin-bottom: 60px; font-weight: 300; }

        .c-list { list-style: none; }
        .c-item { display: flex; align-items: flex-start; gap: 25px; margin-bottom: 45px; }
        .c-icon { width: 60px; height: 60px; background: var(--gold-low); border: 1px solid var(--gold-low); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 20px; color: var(--gold); transition: 0.5s; }
        .c-item:hover .c-icon { background: var(--gold); color: var(--onyx); transform: rotateY(180deg); }
        .c-text h4 { font-size: 13px; text-transform: uppercase; letter-spacing: 2px; color: var(--white); margin-bottom: 8px; opacity: 0.8; }
        .c-text p { font-size: 15px; opacity: 0.5; margin: 0; line-height: 1.6; }

        /* Column Form */
        .form-col { padding: 80px; background: rgba(10, 5, 6, 0.4); }
        .form-col h3 { font-family: 'Dancing Script', cursive; font-size: 3.5rem; color: var(--gold); margin-bottom: 50px; }

        .field-wrap { position: relative; margin-bottom: 45px; }
        .f-input { width: 100%; padding: 15px 0; background: transparent; border: none; border-bottom: 1px solid var(--gold-low); color: #fff; font-size: 16px; transition: 0.4s; font-family: inherit; }
        .f-label { position: absolute; top: 15px; left: 0; font-size: 14px; opacity: 0.4; transition: 0.4s; pointer-events: none; text-transform: uppercase; letter-spacing: 2px; }
        .f-input:read-only ~ .f-label {
                top: -15px;
                font-size: 11px;
                opacity: 1;
                color: var(--gold);
        }
        .f-input:focus ~ .f-label, .f-input:valid ~ .f-label { top: -15px; font-size: 11px; opacity: 1; color: var(--gold); }
        .f-input:focus { border-bottom-color: var(--gold); }

        .btn-luxury {
                padding: 20px 50px; background: transparent; border: 1px solid var(--gold); color: var(--gold); 
                font-size: 11px; font-weight: 700; border-radius: 100px; text-transform: uppercase; letter-spacing: 4px; 
                cursor: pointer; transition: 0.5s; display: inline-flex; align-items: center; gap: 15px;
        }
        .btn-luxury:hover { background: var(--gold); color: var(--onyx); transform: translateY(-8px); box-shadow: 0 10px 30px rgba(0,0,0,0.5); }

        /* 
        ========================================================================
        VI. DARK MAP SECTION
        ========================================================================
        */
        .map-wrapper { width: 100%; height: 500px; position: relative; border-top: 1px solid var(--gold-low); overflow: hidden; }
        .google-map { width: 100%; height: 100%; border: none; filter: grayscale(100%) invert(92%) contrast(85%); opacity: 0.6; transition: 1s; }
        .google-map:hover { opacity: 0.9; }
        .map-gradient { position: absolute; inset: 0; pointer-events: none; background: linear-gradient(to bottom, var(--onyx), transparent 15%, transparent 85%, var(--onyx)); }

        /* 
        ========================================================================
        VII. MULTI-COLUMN FOOTER (SYNC HOME)
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
        
        /* 
        ========================================================================
        VIII. PERFECT MOBILE RESPONSIVE
        ========================================================================
        */
        @media (max-width: 1200px) {
                nav { padding: 0 30px; grid-template-columns: 1fr auto; }
                .nav-menu { display: none; }
                .hamb-btn { display: flex; }
                .contact-box { grid-template-columns: 1fr; border-radius: 30px; }
                .info-col { border-right: none; border-bottom: 1px solid var(--gold-low); padding: 60px 40px; }
                .form-col { padding: 60px 40px; }
                .footer-grid { grid-template-columns: 1fr 1fr; gap: 60px; }
                .hero-inner { margin-top: 120px; }
        }

        @media (max-width: 768px) {
                .brand { font-size: 26px; }
                .contact-section { padding: 0 25px; margin-top: 20px; margin-bottom: 80px; }
                .hero-inner h1 { font-size: 3rem; }
                .info-col h2, .form-col h3 { font-size: 2.8rem; }
                .info-col, .form-col { padding: 50px 25px; }
                .footer-grid { grid-template-columns: 1fr; text-align: center; }
                .f-title::after { left: 50%; transform: translateX(-50%); }
                .f-socials { justify-content: center; }
                .mobile-panel { max-width: 100%; }
                .map-wrapper { height: 400px; }
        }
    </style>
</head>
<body>
    <!-- 1. STICKY LUXURY NAVIGATION -->
    <header id="navbar">
            <nav>
                <a href="<?= base_url('/') ?>" class="brand">
                    <i class="fas fa-mug-hot"></i><span>Coffee Time</span>
                </a>

                <!-- Desktop Navigation -->
                <ul class="nav-menu">
                    <li><a href="<?= base_url('/') ?>">Home</a></li>
                    <li><a href="<?= base_url('menu') ?>">Menu</a></li>
                    <li><a href="<?= base_url('gallery') ?>">Gallery</a></li>
                    <li><a href="<?= base_url('blog') ?>">Journal</a></li>
                    <li><a href="<?= base_url('about') ?>">Story</a></li>
                    <li><a href="<?= base_url('contact') ?>" class="active">Contact</a></li>
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

    <!-- 2. MOBILE RIGHT-SIDE SIDEBAR -->
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

    <!-- 3. EPIC CONTACT HERO -->
    <section class="contact-hero">
            <div class="hero-bg" id="hero-parallax"></div>
            <div class="hero-inner">
                <p>CONNECTED THROUGH ARTISAN COFFEE</p>
                <h1 class="animate__animated animate__fadeInUp">The Concierge</h1>
            </div>
    </section>

    <!-- 4. MAIN CONTACT SUITE -->
    <main class="contact-section">
            <div class="contact-box reveal">
                <!-- Left Info Block -->
                <div class="info-col">
                    <div>
                        <h2>Let's Brew <br>The Future.</h2>
                        <p class="subtext">Kami mengundang Anda untuk mendiskusikan kurasi kopi terbaik, kerjasama ritel, atau sekadar berbagi apresiasi terhadap seni menyeduh.</p>
                        
                        <ul class="c-list">
                            <li class="c-item">
                                <div class="c-icon"><i class="fas fa-map-marked-alt"></i></div>
                                <div class="c-text">
                                    <h4>Our Landmark</h4>
                                    <p>Sudirman Tower, Floor 25, <br>Business Elite A/04<br>Jakarta Selatan, Indonesia</p>
                                </div>
                            </li>
                            <li class="c-item">
                                <div class="c-icon"><i class="fas fa-paper-plane"></i></div>
                                <div class="c-text">
                                    <h4>Electronic Mail</h4>
                                    <p>concierge@coffeetime.id<br>collaborate@coffeetime.id</p>
                                </div>
                            </li>
                            <li class="c-item">
                                <div class="c-icon"><i class="fas fa-phone-volume"></i></div>
                                <div class="c-text">
                                    <h4>Voice Inquiry</h4>
                                    <p>+62 21 3456 7890<br>Direct Roaster Line (By Appt Only)</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="f-socials">
                        <a href="#" class="f-soc-btn"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="f-soc-btn"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="f-soc-btn"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="f-soc-btn"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>

                <!-- Right Message Block -->
                <div class="form-col">
                    <h3>Direct Message</h3>
                    <?php if (!session()->get('is_logged_in')): ?>

                    <button type="button" class="btn-luxury" onclick="forceLogin()">
                        Login to Contact <i class="fas fa-lock"></i>
                    </button>

                    <script>
                    function forceLogin() {
                        Swal.fire({
                            title: 'Akses Terbatas',
                            text: 'Silakan login terlebih dahulu untuk mengirim pesan.',
                            icon: 'warning',
                            background: '#0a0506',
                            color: '#f5deb3',
                            confirmButtonColor: '#f5deb3',
                            confirmButtonText: '<span style="color:#070404">Login Sekarang</span>'
                        }).then(r => {
                            if (r.isConfirmed) {
                                window.location.href = "<?= base_url('auth/login') ?>";
                            }
                        });
                    }
                    </script>

                    <?php else: ?>

                    <form method="post" action="<?= base_url('contact/send') ?>" onsubmit="sendEnquiry(event, this)">
                        <!-- CSRF Protection (Sangat disarankan di CI4) -->
                        <?= csrf_field() ?>

                        <div class="field-wrap">
                            <input type="text"
                                name="name" 
                                class="f-input"
                                value="<?= esc(session()->get('user_name')) ?>"
                                readonly>
                            <label class="f-label">Formal Name</label>
                        </div>

                        <div class="field-wrap">
                            <input type="email"
                                name="email" 
                                class="f-input"
                                value="<?= esc(session()->get('user_email')) ?>"
                                readonly>
                            <label class="f-label">Corporate/Personal Email</label>
                        </div>

                        <div class="field-wrap">
                            <input type="text" name="subject" class="f-input" required placeholder=" ">
                            <label class="f-label">Primary Interest</label>
                        </div>

                        <div class="field-wrap">
                            <textarea name="message" class="f-input" rows="4" required placeholder=" "></textarea>
                            <label class="f-label">Tell us more about your vision...</label>
                        </div>

                        <button type="submit" class="btn-luxury">
                            Submit Transmission <i class="fas fa-long-arrow-alt-right"></i>
                        </button>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
    </main>

    <!-- 5. CINEMATIC DARK MAP -->
    <section class="map-wrapper">
            <iframe class="google-map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.273847253573!2d106.82098657577573!3d-6.227572760989397!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3fb70098f99%3A0xe5a363079979313a!2sSCBD!5e0!3m2!1sid!2sid!4v1709230000000!5m2!1sid!2sid" loading="lazy"></iframe>
            <div class="map-gradient"></div>
    </section>

    <!-- 6. GRAND FOOTER SYSTEM (CONSISTENT) -->
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

    <!-- SCRIPT MASTER -->
    <script>
        /** 
         * 1. NAV, HERO PARALLAX & REVEAL ON SCROLL
         * Digabung jadi satu listener agar performa lebih cepat
         **/
        window.addEventListener('scroll', () => {
                const scroll = window.scrollY;
                const navbar = document.getElementById('navbar');
                const bg = document.getElementById('hero-parallax');
                
                // Sticky Navbar
                navbar.classList.toggle('scrolled', scroll > 50);

                // Hero Parallax
                if(bg) bg.style.transform = `scale(1.1) translateY(${scroll * 0.35}px)`;

                // Reveal Animation logic
                document.querySelectorAll('.reveal').forEach(el => {
                    if(el.getBoundingClientRect().top < window.innerHeight - 80) {
                        el.classList.add('active');
                    }
                });
        });

        /** 
         * 2. MOBILE PANEL CONTROLLER 
         **/
        const stTrigger = document.getElementById('open-panel');
        const stClose   = document.getElementById('close-panel');
        const stSidebar = document.getElementById('panel');
        const stOverlay = document.getElementById('overlay');

        function togglePanel(status) {
                stSidebar.classList.toggle('active', status);
                stOverlay.classList.toggle('active', status);
                document.body.style.overflow = status ? 'hidden' : 'auto';
        }

        if(stTrigger) stTrigger.onclick = () => togglePanel(true);
        if(stClose) stClose.onclick     = () => togglePanel(false);
        if(stOverlay) stOverlay.onclick = () => togglePanel(false);


        /** 
         * 3. ENQUIRY FORM LOGIC (Satu Fungsi Saja)
         **/
        function sendEnquiry(e, form) {
                e.preventDefault(); 

                Swal.fire({
                    title: 'Processing...',
                    text: 'Sedang mengenkripsi pesan Anda ke tim roastery...',
                    allowOutsideClick: false,
                    background: '#0a0506',
                    color: '#f5deb3',
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Delay mewah 1.2 detik agar user merasakan proses "pengiriman eksklusif"
                setTimeout(() => {
                    form.submit(); 
                }, 1200);
        }
        // Trigger reveal sekali saat halaman pertama kali dibuka
        window.dispatchEvent(new Event('scroll'));
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
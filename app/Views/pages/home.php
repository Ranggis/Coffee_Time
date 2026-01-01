<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Coffee Time</title>

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
        I. DESIGN SYSTEM
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
            --z-preloader: 12000; 
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
            opacity: 0.1; pointer-events: none; z-index: 99999;
        }

        h1, h2, h3, h4 { font-family: 'Playfair Display', serif; color: var(--white); font-weight: 700; }
        .hand { font-family: 'Dancing Script', cursive; }
        a { text-decoration: none; color: inherit; transition: 0.4s var(--transit); }
        ul { list-style: none; }

        .reveal { opacity: 0; transform: translateY(50px); transition: 1.2s var(--transit); }
        .reveal.active { opacity: 1; transform: translateY(0); }

        /* 
        ========================================================================
        II. CINEMATIC ARTISANAL PRELOADER
        ========================================================================
        */
        #preloader {
            position: fixed; inset: 0; background: var(--onyx);
            z-index: var(--z-preloader); display: flex; flex-direction: column;
            align-items: center; justify-content: center; text-align: center;
            overflow: hidden;
        }

        #preloader.exit { opacity: 0; visibility: hidden; transform: scale(1.1); transition: 1.2s var(--transit); }

        .loader-bg-glow {
            position: absolute;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(245, 222, 179, 0.05) 0%, rgba(7, 4, 4, 0) 70%);
            border-radius: 50%; z-index: -1; filter: blur(50px);
        }

        .load-content { position: relative; width: 100%; max-width: 600px; }
        
        #load-name {
            font-family: 'Dancing Script', cursive;
            font-size: clamp(3.5rem, 12vw, 6.5rem);
            min-height: 1.2em;
            margin-bottom: 5px;

            background: linear-gradient(90deg, #333 0%, var(--gold) 50%, #333 100%);
            background-size: 200% auto;

            background-clip: text;          /* STANDARD */
            -webkit-background-clip: text;  /* SAFARI / CHROME */

            color: transparent;             /* STANDARD */
            -webkit-text-fill-color: transparent;

            text-shadow: 0 0 40px rgba(245, 222, 179, 0.3);
            animation: textShimmer 3s infinite linear;
        }

        @keyframes textShimmer { to { background-position: 200% center; } }

        .load-line-container {
            width: 0; height: 1px; background: var(--gold);
            margin: 25px auto; opacity: 0;
            transition: width 1.5s var(--transit), opacity 0.8s;
            box-shadow: 0 0 15px var(--gold);
        }

        .load-status { 
            font-size: 11px; letter-spacing: 8px; text-transform: uppercase; 
            color: var(--gold-soft); opacity: 0; transform: translateY(20px);
            transition: 1.2s var(--transit); font-weight: 300;
        }

        /* 
        ========================================================================
        III. STICKY NAVIGATION
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
        IV. MOBILE PANEL
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
        V. CONTENT SECTIONS
        ========================================================================
        */
        /* 1. HERO (ADJUSTED SPACING) */
        .hero { height: 100vh; display: flex; align-items: center; justify-content: center; text-align: center; overflow: hidden; position: relative; }
        .hero-bg { position: absolute; inset: 0; background: linear-gradient(rgba(7,4,4,0.35), var(--onyx)), url('https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&w=1920&q=80') center/cover; z-index: 1; transform: scale(1.1); transition: 1.5s var(--transit); filter: brightness(0.4); }
        
        .hero-inner { 
            position: relative; z-index: 5; max-width: 1000px; padding: 0 30px; 
            margin-top: 50px; /* TURUNKAN TULISAN AGAR TIDAK BENTROK NAVBAR */
            animation: heroFloat 6s infinite ease-in-out; /* NEW FLOATING ANIMATION */
        }

        @keyframes heroFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }

        .hero h1 { font-size: clamp(3rem, 10vw, 7rem); line-height: 1.1; font-weight: 900; margin-bottom: 35px; }
        .hero h1 span { color: var(--gold); font-family: 'Dancing Script', cursive; }

        /* BUTTON GLOW ANIMATION */
        .btn-luxe {
            padding: 18px 45px; background: var(--gold); color: var(--onyx); 
            font-weight: 700; border-radius: 50px; font-size: 11px; letter-spacing: 3px; 
            text-transform: uppercase; display: inline-block;
            box-shadow: 0 0 0 0 rgba(245, 222, 179, 0.4);
            animation: pulseBtn 2s infinite;
            transition: 0.4s;
        }
        @keyframes pulseBtn {
            0% { box-shadow: 0 0 0 0 rgba(245, 222, 179, 0.7); }
            70% { box-shadow: 0 0 0 15px rgba(245, 222, 179, 0); }
            100% { box-shadow: 0 0 0 0 rgba(245, 222, 179, 0); }
        }
        .btn-luxe:hover { transform: translateY(-5px) scale(1.05); background: #fff; }

        /* 2. THE CRAFT */
        .section { padding: 160px 60px; max-width: 1600px; margin: auto; }
        .flex-box { display: flex; align-items: center; gap: 100px; }
        .f-1 { flex: 1; }
        .craft-img { position: relative; border-radius: 30px; overflow: hidden; box-shadow: 0 30px 60px rgba(0,0,0,0.5); }
        .craft-img img { transition: 1.5s var(--transit); width: 100%; display: block; }
        .craft-img:hover img { transform: scale(1.1) rotate(1deg); }

        .section h2 { font-size: 3.5rem; line-height: 1.2; margin-bottom: 30px; }

        /* 3. SIGNATURE HIGHLIGHT CARDS */
        .grid-3 { display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 40px; margin-top: 80px; }
        .lux-card { background: var(--dark-gray); border: 1px solid var(--gold-low); padding: 80px 50px; border-radius: 40px; text-align: center; transition: 0.6s var(--transit); position: relative; }
        .lux-card:hover { transform: translateY(-25px); border-color: var(--gold); box-shadow: 0 40px 80px rgba(0,0,0,0.7); }
        
        /* Floating Icon Animation */
        .lux-card i { 
            font-size: 55px; color: var(--gold); margin-bottom: 35px; transition: 0.5s; 
            display: inline-block; animation: floatIcon 4s infinite ease-in-out;
        }
        @keyframes floatIcon { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        .lux-card:hover i { transform: rotateY(180deg) scale(1.1); }

        /* 
        ========================================================================
        VI. RICH FOOTER SYSTEM
        ========================================================================
        */
        footer { background: #060404; border-top: 1px solid var(--gold-low); padding: 120px 60px 40px; position: relative; }
        .footer-grid { max-width: 1600px; margin: auto; display: grid; grid-template-columns: 1.5fr 1fr 1fr 1.5fr; gap: 80px; }

        .f-brand h2 { font-family: 'Dancing Script', cursive; font-size: 50px; color: var(--gold); margin-bottom: 25px; }
        .f-desc { opacity: 0.5; font-size: 14px; max-width: 350px; margin-bottom: 30px; }
        
        .f-socials { display: flex; gap: 20px; }
        .f-socials a { width: 45px; height: 45px; border: 1px solid var(--gold-low); border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: 0.4s; font-size: 18px; }
        .f-socials a:hover { background: var(--gold); color: var(--onyx); transform: translateY(-5px) rotate(360deg); border-color: var(--gold); }

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
        
        /* ============================
          AMBIENT COFFEE STEAM EFFECT
          ============================ */

        .steam-wrap {
            position: absolute;
            inset: 0;
            z-index: 3;
            pointer-events: none;
            overflow: hidden;
        }

        .steam {
            position: absolute;
            bottom: -120px;
            width: 10px;
            height: 160px;
            background: radial-gradient(circle, rgba(245,222,179,0.25) 0%, rgba(245,222,179,0.05) 40%, transparent 70%);
            filter: blur(12px);
            opacity: 0;
            animation: steamRise 7s infinite ease-in-out;
        }

        /* VARIASI POSISI & SPEED */
        .steam.s1 { left: 30%; animation-delay: 0s; }
        .steam.s2 { left: 45%; animation-delay: 2s; height: 200px; }
        .steam.s3 { left: 60%; animation-delay: 4s; }
        .steam.s4 { left: 75%; animation-delay: 1s; height: 180px; }

        @keyframes steamRise {
            0% {
                transform: translateY(0) translateX(0);
                opacity: 0;
            }
            20% {
                opacity: .35;
            }
            50% {
                opacity: .2;
            }
            100% {
                transform: translateY(-420px) translateX(-40px);
                opacity: 0;
            }
        }

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
    </style>
</head>
<body>

    <!-- 1. CINEMATIC ARTISANAL PRELOADER -->
    <div id="preloader">
        <div class="loader-bg-glow"></div>
        <div class="load-content">
            <h1 id="load-name"></h1> <!-- Typed by JavaScript -->
            <div class="load-line-container" id="load-line-box"></div>
            <p class="load-status" id="load-status">Mastering the Art of Roasting</p>
        </div>
    </div>

    <!-- 2. LUXURY NAVBAR -->
    <header id="navbar">
        <nav>
            <a href="<?= base_url('/') ?>" class="brand">
                <i class="fas fa-mug-hot"></i><span>Coffee Time</span>
            </a>

            <!-- Desktop Navigation -->
            <ul class="nav-menu">
                <li><a href="<?= base_url('/') ?>" class="active">Home</a></li>
                <li><a href="<?= base_url('menu') ?>">Menu</a></li>
                <li><a href="<?= base_url('gallery') ?>">Gallery</a></li>
                <li><a href="<?= base_url('blog') ?>">Journal</a></li>
                <li><a href="<?= base_url('about') ?>">Story</a></li>
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

    <!-- 3. MOBILE OVERLAY PANEL -->
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

    <!-- 4. EPIC HERO -->
    <section class="hero">
        <div class="hero-bg" id="parallax-bg"></div>
        <!-- Ambient Coffee Steam -->
        <div class="steam-wrap">
            <span class="steam s1"></span>
            <span class="steam s2"></span>
            <span class="steam s3"></span>
            <span class="steam s4"></span>
        </div>
        <div class="hero-inner">
            <span class="animate__animated animate__fadeInDown" style="letter-spacing: 8px; font-size: 11px; margin-bottom: 25px; display: block;">THE ULTIMATE ESTATE ROASTERY</span>
            <h1 class="reveal">Elevate Your <br><span>Coffee Legacy</span></h1>
            <p class="reveal animate__delay-1s">Kami menghadirkan simfoni rasa yang dipanen dari pegunungan terbaik dunia, disangrai dengan presisi oleh para master roastery, dan disajikan eksklusif untuk Anda.</p>
            <div class="reveal animate__delay-2s" style="margin-top: 50px;">
                <!-- EXPLORE MENU BUTTON KEMBALI & BERANIMASI -->
                <a href="<?= base_url('menu') ?>" class="btn-luxe">Explore Menu</a>
            </div>
        </div>
    </section>

    <!-- 5. THE CRAFT -->
    <section class="section">
        <div class="flex-box">
            <div class="f-1 craft-img reveal">
                <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&w=800&q=80" alt="Roasting" width="100%">
            </div>
            <div class="f-1 reveal">
                <span class="hand" style="font-size: 30px; color: var(--gold);">Our Philosophy</span>
                <h2>The Pure Art of <br>Extraction</h2>
                <p>Di Coffee Time, kopi bukan sekadar minuman berkafein. Ia adalah jembatan antara tanah tempatnya tumbuh dan cangkir yang Anda genggam. Setiap tetesan adalah hasil dari kesabaran dan dedikasi.</p>
                <a href="<?= base_url('about') ?>" style="border-bottom: 1.5px solid var(--gold); padding-bottom: 8px; font-weight: 600; font-size: 12px; letter-spacing: 3px; text-transform: uppercase; display: inline-block; margin-top: 30px;">Read Full Legacy</a>
            </div>
        </div>
    </section>

    <!-- 6. SIGNATURE FEATURES -->
    <section class="section" style="background: var(--dark-gray); border-radius: 80px 80px 0 0;">
        <div style="text-align: center;" class="reveal">
            <span class="hand" style="font-size: 35px; color: var(--gold);">Curated Excellence</span>
            <h2>Our Signature System</h2>
        </div>
        <div class="grid-3">
            <div class="lux-card reveal">
                <i class="fas fa-temperature-high"></i>
                <h3>Precision Roasting</h3>
                <p>Menggunakan pemantauan termal batch-by-batch untuk memastikan setiap profil aroma tereksplorasi hingga titik sempurna.</p>
            </div>
            <div class="lux-card reveal">
                <i class="fas fa-award"></i>
                <h3>Award Winning</h3>
                <p>Dikurasi oleh tim Barista bersertifikat internasional yang mendedikasikan presisi pada setiap cangkir Anda.</p>
            </div>
            <div class="lux-card reveal">
                <i class="fas fa-seedling"></i>
                <h3>Ethical Sourcing</h3>
                <p>Bekerja sama langsung dengan petani mikro lokal untuk menjamin keadilan harga dan kualitas organik terbaik.</p>
            </div>
        </div>
    </section>

    <!-- 7. RICH FOOTER SYSTEM -->
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

    <!-- JS SCRIPTS -->
    <script>
        /**
         * 1. CINEMATIC ARTISANAL TYPING LOADER SYSTEM
         */
        const textToType = "Coffee Time";
        const typingSpeed = 150;
        const loadNameElement = document.getElementById('load-name');
        const loadStatus = document.getElementById('load-status');
        const loadLineBox = document.getElementById('load-line-box');
        const loadBar = document.getElementById('load-bar');
        const preloader = document.getElementById('preloader');

        function typeWriter(text, i) {
            if (i < text.length) {
                const randomSpeed = Math.random() * (200 - 80) + 80;
                loadNameElement.textContent += text.charAt(i);
                setTimeout(() => typeWriter(text, i + 1), randomSpeed);
            } else {
                setTimeout(() => {
                    loadLineBox.style.opacity = '1';
                    loadLineBox.style.width = '180px';
                    setTimeout(() => {
                        loadStatus.style.opacity = '1';
                        loadStatus.style.transform = 'translateY(0)';
                        setTimeout(() => {
                            preloader.classList.add('exit');
                            initMainPage();
                        }, 2000);
                    }, 500);
                }, 400);
            }
        }

        window.addEventListener('load', () => {
            // cek apakah loader sudah pernah tampil
            if (sessionStorage.getItem('coffee_loader_shown')) {
                // langsung skip loader
                preloader.style.display = 'none';
                initMainPage();
            } else {
                // tampilkan loader
                sessionStorage.setItem('coffee_loader_shown', 'true');
                setTimeout(() => typeWriter(textToType, 0), 800);
            }
        });

        /**
         * 2. MAIN PAGE ENGINES
         */
        function initMainPage() {
            const observerOptions = { threshold: 0.15 };
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) entry.target.classList.add('active');
                });
            }, observerOptions);

            document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

            window.addEventListener('scroll', () => {
                const scroll = window.scrollY;
                const bg = document.getElementById('parallax-bg');
                if(bg) bg.style.transform = `scale(1.1) translateY(${scroll * 0.35}px)`;
                
                const navbar = document.getElementById('navbar');
                if(scroll > 50) navbar.classList.add('scrolled');
                else navbar.classList.remove('scrolled');
            });
        }

        /**
         * 3. MOBILE PANEL CONTROLLER
         */
        const open = document.getElementById('open-panel');
        const close = document.getElementById('close-panel');
        const panel = document.getElementById('panel');
        const overlay = document.getElementById('overlay');

        function togglePanel(status) {
            panel.classList.toggle('active', status);
            overlay.classList.toggle('active', status);
            document.body.style.overflow = status ? 'hidden' : 'auto';
        }

        open.addEventListener('click', () => togglePanel(true));
        close.addEventListener('click', () => togglePanel(false));
        overlay.addEventListener('click', () => togglePanel(false));
        
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
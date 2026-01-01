<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Journal | Coffee Time</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Fonts: Luxury Pairing -->
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@600;700&family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400&family=Poppins:wght@200;300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- External Libraries -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <!-- Library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* 
        ========================================================================
        I. DESIGN SYSTEM (SISTEM DESAIN - KONSISTEN)
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

        /* RESET & BASE */
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
        II. STICKY NAVIGATION (MATCHING PREVIOUS PAGES)
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
        III. MOBILE PANEL (FIXED CENTERED)
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
        IV. BLOG HERO
        ========================================================================
        */
        .blog-hero {
            height: 60vh; position: relative; display: flex; align-items: center; justify-content: center;
            text-align: center; overflow: hidden;
        }
        .hero-bg {
            position: absolute; inset: 0; z-index: 1;
            background: linear-gradient(rgba(7,4,4,0.35), var(--onyx)), url('https://images.unsplash.com/photo-1497935586351-b67a49e012bf?auto=format&fit=crop&w=1920&q=80') center/cover;
            filter: brightness(0.45); transform: scale(1.1); transition: 1.5s var(--transit);
        }
        .hero-inner { position: relative; z-index: 5; margin-top: 100px; }
        .hero-inner h1 { font-family: 'Dancing Script', cursive; font-size: clamp(3.5rem, 8vw, 5.5rem); color: var(--gold); }
        .hero-inner p { font-size: 12px; letter-spacing: 6px; text-transform: uppercase; color: var(--gold-soft); }

        /* 
        ========================================================================
        V. CATEGORY BAR
        ========================================================================
        */
        .category-container {
            position: sticky; top: 75px; z-index: 100; background: var(--onyx);
            padding: 20px 0; border-bottom: 1px solid var(--gold-low);
        }
        .category-scroll { display: flex; justify-content: center; gap: 15px; overflow-x: auto; scrollbar-width: none; padding: 0 20px; }
        .cat-btn {
            padding: 10px 28px; border-radius: 50px; border: 1px solid var(--gold-low);
            font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 2px;
            white-space: nowrap; transition: 0.4s; color: var(--gold-soft); background: none; cursor: pointer;
        }
        .cat-btn.active, .cat-btn:hover { background: var(--gold); color: var(--onyx); border-color: var(--gold); }

        /* 
        ========================================================================
        VI. BLOG CONTENT
        ========================================================================
        */
        .blog-section { padding: 100px 50px; max-width: 1500px; margin: auto; }

        /* FEATURED POST */
        .featured-article {
            display: grid; grid-template-columns: 1.2fr 1fr; gap: 0;
            background: var(--dark-gray); border: 1px solid var(--gold-low);
            border-radius: 40px; overflow: hidden; margin-bottom: 80px;
            transition: 0.6s var(--transit);
        }
        .featured-article:hover { border-color: var(--gold); transform: translateY(-10px); box-shadow: 0 30px 60px rgba(0,0,0,0.5); }
        
        .fa-img { height: 500px; overflow: hidden; }
        .fa-img img { width: 100%; height: 100%; object-fit: cover; transition: 1s var(--transit); }
        .featured-article:hover .fa-img img { transform: scale(1.1); }

        .fa-content { padding: 60px; display: flex; flex-direction: column; justify-content: center; }
        .fa-tag { font-size: 10px; letter-spacing: 3px; text-transform: uppercase; color: var(--gold); margin-bottom: 20px; font-weight: 700; }
        .fa-title { font-size: 3rem; line-height: 1.1; margin-bottom: 25px; }
        .fa-excerpt { font-size: 1.1rem; opacity: 0.6; margin-bottom: 40px; font-weight: 300; }
        
        .author-box { display: flex; align-items: center; gap: 15px; }
        .author-img { width: 45px; height: 45px; border-radius: 50%; border: 1px solid var(--gold); padding: 2px; }
        .author-info span { display: block; font-size: 13px; }

        /* BLOG GRID */
        .blog-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(380px, 1fr)); gap: 40px; }

        .blog-card {
            background: var(--dark-gray); border: 1px solid var(--gold-low);
            border-radius: 30px; overflow: hidden; transition: 0.6s var(--transit);
            display: flex; flex-direction: column;
        }
        .blog-card:hover { transform: translateY(-15px); border-color: var(--gold); }

        .card-banner { height: 260px; overflow: hidden; }
        .card-banner img { width: 100%; height: 100%; object-fit: cover; transition: 1s var(--transit); }
        .blog-card:hover .card-banner img {
            transform: scale(1.04) translateY(-4px);
            filter: brightness(1.05) contrast(1.05);
        }
        .card-info { padding: 35px; flex: 1; display: flex; flex-direction: column; }
        .card-date { font-size: 11px; text-transform: uppercase; letter-spacing: 2px; color: var(--gold-soft); margin-bottom: 15px; }
        .card-title { font-size: 1.6rem; line-height: 1.3; margin-bottom: 20px; transition: 0.3s; }
        .blog-card:hover .card-title { color: var(--gold); }
        
        .card-footer { margin-top: auto; padding-top: 25px; border-top: 1px solid var(--gold-low); display: flex; justify-content: space-between; align-items: center; }
        .read-link { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; border-bottom: 1px solid var(--gold); padding-bottom: 3px; }

        /* 
        ========================================================================
        VII. RICH FOOTER SYSTEM
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

        /* RESPONSIVE */
        @media (max-width: 1200px) {
            nav { padding: 0 30px; grid-template-columns: 1fr auto; }
            .nav-menu { display: none; }
            .hamb-btn { display: flex; }
            .footer-grid { grid-template-columns: 1fr 1fr; gap: 60px; }
            .featured-article { grid-template-columns: 1fr; }
            .fa-img { height: 350px; }
        }

        @media (max-width: 768px) {
            .blog-section { padding: 60px 25px; }
            .fa-title { font-size: 2.2rem; }
            .fa-content { padding: 40px 25px; }
            .footer-grid { grid-template-columns: 1fr; text-align: center; }
            .f-contact p { justify-content: center; }
            .mobile-panel { max-width: 100%; }
            .category-scroll { justify-content: flex-start; }
            .f-socials { justify-content: center; }
        }

        /* ================= MODAL SYSTEM ================= */
        #blogModal {
            position: fixed;
            inset: 0;
            z-index: 99999;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            transition: opacity 0.4s ease;
            opacity: 0;
        }

        #blogModal.active { opacity: 1; }

        .modal-backdrop {
            position: absolute;
            inset: 0;
            background: rgba(7, 4, 4, 0.85);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .modal-box {
            position: relative;
            width: 100%;
            max-width: 650px; /* Ukuran diperkecil dari 900px */
            max-height: 80vh;  /* Lebih pendek agar lebih proposional */
            background: #120b0c;
            border: 1px solid rgba(245, 222, 179, 0.15);
            border-radius: 30px;
            z-index: 2;
            box-shadow: 0 40px 80px rgba(0,0,0,0.7);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            transform: scale(0.9) translateY(20px);
            transition: transform 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        }

        #blogModal.active .modal-box { transform: scale(1) translateY(0); }

        .modal-close {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 35px;
            height: 35px;
            background: rgba(7, 4, 4, 0.8);
            border: 1px solid var(--gold-low);
            color: var(--gold);
            border-radius: 50%;
            font-size: 14px;
            cursor: pointer;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.3s;
        }
        .modal-close:hover { background: var(--gold); color: var(--onyx); }

        .modal-body {
            padding: 40px; /* Padding dikurangi agar lebih compact */
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: var(--gold-low) transparent;
        }

        /* Thumbnail diperkecil */
        #modal-thumb {
            width: 100%;
            height: 280px; /* Tinggi dikurangi dari 450px */
            object-fit: cover;
            border-radius: 20px;
            margin-bottom: 30px;
        }

        .modal-header-info {
            text-align: center;
            margin-bottom: 30px;
        }

        #modal-category {
            font-size: 9px;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: var(--gold);
            font-weight: 700;
            display: block;
            margin-bottom: 12px;
        }

        #modal-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem; /* Ukuran font lebih proporsional */
            line-height: 1.2;
            color: var(--white);
            margin-bottom: 12px;
        }

        #modal-meta {
            font-size: 11px;
            opacity: 0.5;
            letter-spacing: 1px;
        }

        #modal-content {
            font-size: 0.95rem; /* Font isi sedikit diperkecil */
            line-height: 1.7;
            color: rgba(255, 255, 255, 0.7);
            text-align: left;
        }

        #modal-content p { margin-bottom: 18px; }

        /* Scrollbar Halus */
        .modal-body::-webkit-scrollbar { width: 3px; }
        .modal-body::-webkit-scrollbar-thumb { background: var(--gold-low); border-radius: 10px; }

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
        
        /* Media Query Mobile tetap aman */
        @media (max-width: 768px) {
            .modal-box { max-width: 90%; max-height: 75vh; }
            .modal-body { padding: 30px 20px; }
            #modal-thumb { height: 180px; }
            #modal-title { font-size: 1.4rem; }
        }
    </style>
</head>
<body>

    <!-- 1. STICKY NAVBAR -->
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
                <li><a href="<?= base_url('blog') ?>" class="active">Journal</a></li>
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

    <!-- 2. MOBILE OVERLAY PANEL -->
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

    <!-- 3. HERO -->
    <section class="blog-hero">
        <div class="hero-bg" id="parallax-bg"></div>
        <div class="hero-inner">
            <p id="hero-subtitle">Insights & Inspirations</p>
            <h1 id="hero-title">The Daily Roast</h1>
        </div>
    </section>

    <!-- 4. CATEGORY BAR -->
    <div class="category-container">
        <div class="category-scroll">

            <!-- ALL -->
            <button
                class="cat-btn <?= !$activeCategory ? 'active' : '' ?>"
                onclick="location.href='<?= base_url('blog') ?>'">
                All Stories
            </button>

            <!-- FROM DATABASE -->
            <?php foreach ($categories as $cat): ?>
                <button
                    class="cat-btn <?= $activeCategory === $cat['slug'] ? 'active' : '' ?>"
                    onclick="location.href='<?= base_url('blog?category=' . $cat['slug']) ?>'">
                    <?= esc($cat['name']) ?>
                </button>
            <?php endforeach; ?>

        </div>
    </div>

    <!-- 5. MAIN CONTENT -->
    <main class="blog-section">
        
        <!-- Featured Article -->
        <?php if ($featured): ?>
        <article class="featured-article reveal">
            <div class="fa-img">
                <img 
                    src="<?= esc($featured['thumbnail']) ?>" 
                    alt="<?= esc($featured['title']) ?>"
                    onerror="this.src='https://dummyimage.com/1200x600/111/f5deb3&text=Coffee+Time'"
                >
            </div>
            <div class="fa-content">
                <span class="fa-tag"><?= esc($featured['category_name']) ?></span>

                <h2 class="fa-title"><?= esc($featured['title']) ?></h2>

                <p class="fa-excerpt">
                    <?= esc($featured['excerpt']) ?>
                </p>

                <div class="author-box">
                    <img 
                        src="https://raw.githubusercontent.com/Ranggis/Api-Image/main/albert.jpg" 
                        class="author-img"
                    >
                    <div class="author-info">
                        <span style="font-weight:600;color:#fff;">
                            By Admin
                        </span>
                        <span style="opacity:.5;">
                            <?= date('F d, Y', strtotime($featured['created_at'])) ?>
                            • <?= $featured['read_time'] ?> min read
                        </span>
                    </div>
                </div>
            </div>
        </article>
        <?php endif; ?>

        <!-- Grid Articles -->
        <div class="blog-grid">
        <?php foreach ($blogs as $blog): ?>
            <?php if (!$blog['is_featured']): ?>
            <article class="blog-card reveal">
                <div class="card-banner">
                    <img 
                        src="<?= esc($blog['thumbnail']) ?>" 
                        alt="<?= esc($blog['title']) ?>"
                        onerror="this.src='https://dummyimage.com/800x500/111/f5deb3&text=Coffee+Time'"
                    >
                </div>

                <div class="card-info">
                    <span class="card-date">
                        <?= date('M d, Y', strtotime($blog['created_at'])) ?>
                    </span>

                    <h3 class="card-title">
                        <?= esc($blog['title']) ?>
                    </h3>

                    <div class="card-footer">
                        <span style="font-size:12px;opacity:.5;">
                            <i class="far fa-clock"></i>
                            <?= $blog['read_time'] ?> min read
                        </span>

                        <a 
                            href="#"
                            class="read-link"
                            data-slug="<?= esc($blog['slug']) ?>"
                        >
                            Read Story
                        </a>
                    </div>
                </div>
            </article>
            <?php endif; ?>
        <?php endforeach; ?>
        </div>

    <!-- 6. FOOTER -->
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

    <!-- MODAL SYSTEM -->
    <div id="blogModal">
        <div class="modal-backdrop"></div>
        <div class="modal-box">
            <button class="modal-close"><i class="fas fa-times"></i></button>
            
            <div class="modal-body">
                <img id="modal-thumb" src="" alt="">
                
                <div class="modal-header-info">
                    <span id="modal-category"></span>
                    <h1 id="modal-title"></h1>
                    <p id="modal-meta"></p>
                </div>

                <div id="modal-content">
                    <!-- Konten dinamis masuk sini -->
                </div>
                
                <!-- Opsional: Footer Modal -->
                <div style="text-align: center; margin-top: 60px; opacity: 0.3; font-size: 12px; letter-spacing: 2px;">
                    COFFEE TIME JOURNAL &copy; 2025
                </div>
            </div>
        </div>
    </div>
    
    <!-- JS SCRIPTS -->
    <script>
        /**
         * 1. NAV & SCROLL REACTION
         */
        window.addEventListener('scroll', () => {
            const scroll = window.scrollY;
            document.getElementById('navbar').classList.toggle('scrolled', scroll > 50);
            
            const bg = document.getElementById('parallax-bg');
            if(bg) bg.style.transform = `scale(1.1) translateY(${scroll * 0.35}px)`;
            
            revealOnScroll();
        });

        function revealOnScroll() {
            document.querySelectorAll('.reveal').forEach(el => {
                if(el.getBoundingClientRect().top < window.innerHeight - 80) el.classList.add('active');
            });
        }

        /**
         * 2. MOBILE PANEL CONTROLLER
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

        document.addEventListener('DOMContentLoaded', () => {

            const subtitle = document.getElementById('hero-subtitle');
            const title    = document.getElementById('hero-title');
            if (!subtitle || !title) return;

            const currentPath = location.pathname;
            const lastPath    = sessionStorage.getItem('lastPagePath');

            /**
             * RULE FINAL:
             * - REFRESH halaman → animasi hidup
             * - PINDAH PAGE → animasi hidup
             * - FILTER KATEGORI (?category=) → animasi mati
             */

            const shouldAnimate = !lastPath || lastPath !== currentPath;

            if (shouldAnimate) {
                // reset class (antisipasi cache)
                subtitle.classList.remove('animate__animated', 'animate__fadeInDown');
                title.classList.remove('animate__animated', 'animate__fadeInUp');

                void subtitle.offsetHeight;
                void title.offsetHeight;

                subtitle.classList.add('animate__animated', 'animate__fadeInDown');
                title.classList.add('animate__animated', 'animate__fadeInUp');
            } else {
                subtitle.style.opacity = 1;
                title.style.opacity = 1;
            }

            // simpan path terakhir
            sessionStorage.setItem('lastPagePath', currentPath);
        });

        // Pemicu Modal
        document.querySelectorAll('.read-link').forEach(btn => {
            btn.addEventListener('click', async e => {
                e.preventDefault();
                const slug = btn.dataset.slug;
                const originalText = btn.innerHTML;
                
                // Feedback Loading
                btn.innerHTML = "<i class='fas fa-circle-notch fa-spin'></i> Opening..."; 

                try {
                    const res = await fetch(`<?= base_url('blog/read/') ?>${slug}`);
                    if (!res.ok) throw new Error('Fail');
                    const data = await res.json();

                    // Isi Data
                    document.getElementById('modal-thumb').src = data.thumbnail;
                    document.getElementById('modal-title').innerText = data.title;
                    document.getElementById('modal-category').innerText = data.category_name;
                    document.getElementById('modal-meta').innerText =
                        `${new Date(data.created_at).toLocaleDateString('en-US', { day: 'numeric', month: 'long', year: 'numeric' })} • ${data.read_time} min read`;
                    document.getElementById('modal-content').innerHTML = data.content;

                    // Munculkan Modal
                    const modal = document.getElementById('blogModal');
                    modal.style.display = 'flex'; 
                    
                    // Jeda sedikit agar browser sempat merender display:flex sebelum menambah class active
                    setTimeout(() => {
                        modal.classList.add('active');
                    }, 10);
                    
                    document.body.style.overflow = 'hidden';
                    btn.innerHTML = originalText;

                } catch (error) {
                    console.error(error);
                    alert('Could not load article.');
                    btn.innerHTML = originalText;
                }
            });
        });

        // Fungsi Menutup Modal dengan Animasi
        const closeModal = () => {
            const modal = document.getElementById('blogModal');
            modal.classList.remove('active');
            
            // Tunggu animasi CSS selesai (0.5s) baru ubah display ke none
            setTimeout(() => {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }, 500);
        };

        // Event Listeners
        document.querySelector('.modal-close').addEventListener('click', closeModal);
        document.querySelector('.modal-backdrop').addEventListener('click', closeModal);
        
        // Tutup dengan ESC
        window.addEventListener('keydown', (e) => {
            if (e.key === "Escape") closeModal();
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
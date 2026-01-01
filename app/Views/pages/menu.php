<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Menu | Coffee Time</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Fonts: Luxury Pairing (Same as Home) -->
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@600;700&family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400&family=Poppins:wght@200;300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- External Libraries -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <!-- Library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* 
        ========================================================================
        I. DESIGN SYSTEM (SISTEM DESAIN - KONSISTEN DENGAN HOME)
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
        II. STICKY NAVIGATION (MATCHING HOME)
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
        III. MOBILE PANEL (FIXED CENTERED - MATCHING HOME)
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
        IV. MENU HERO & CATEGORIES
        ========================================================================
        */
        .menu-hero {
            height: 60vh; position: relative; display: flex; align-items: center; justify-content: center;
            text-align: center; overflow: hidden;
        }
        .hero-bg {
            position: absolute; inset: 0; z-index: 1;
            background: linear-gradient(rgba(7,4,4,0.35), var(--onyx)), url('https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&w=1920&q=80') center/cover;
            filter: brightness(0.45); transform: scale(1.1); transition: 1.5s var(--transit);
        }

        .hero-title-box { position: relative; z-index: 5; margin-top: 100px; } /* Jaga jarak dari navbar */
        .hero-title-box h1 { font-family: 'Dancing Script', cursive; font-size: clamp(3.5rem, 8vw, 5.5rem); color: var(--gold); text-shadow: 0 0 30px rgba(0,0,0,0.5); }
        .hero-title-box p { font-size: 12px; letter-spacing: 6px; text-transform: uppercase; color: var(--gold-soft); margin-bottom: 10px; }

        .category-container {
            position: sticky; top: 75px; z-index: 100; background: var(--onyx);
            padding: 20px 0; border-bottom: 1px solid var(--gold-low);
        }
        .category-scroll {
            display: flex; justify-content: center; gap: 15px; overflow-x: auto;
            scrollbar-width: none; padding: 0 20px;
        }
        .cat-pill {
            padding: 10px 28px; border-radius: 50px; border: 1px solid var(--gold-low);
            font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 2px;
            white-space: nowrap; transition: 0.4s; color: var(--gold-soft); cursor: pointer;
        }
        .cat-pill.active, .cat-pill:hover { background: var(--gold); color: var(--onyx); border-color: var(--gold); }

        /* 
        ========================================================================
        V. PRODUCT GRID & CARDS
        ========================================================================
        */
        .menu-section { padding: 100px 50px; max-width: 1500px; margin: auto; }
        .menu-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 40px; }

        .menu-card {
            background: var(--dark-gray); border: 1px solid var(--gold-low);
            border-radius: 35px; overflow: hidden; transition: 0.6s var(--transit);
            display: flex; flex-direction: column; position: relative;
        }
        .menu-card.hide {
            opacity: 0;
            transform: translateY(20px) scale(0.98);
            pointer-events: none;
        }
        .menu-card:hover { transform: translateY(-15px); border-color: var(--gold); box-shadow: 0 30px 60px rgba(0,0,0,0.6); }

        .img-wrapper { height: 280px; position: relative; background: rgba(255,255,255,0.01); overflow: hidden; padding: 30px; display: flex; align-items: center; justify-content: center; }
        
        .img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 18px;
            transition: transform 0.8s cubic-bezier(0.23, 1, 0.32, 1),
                        filter 0.8s cubic-bezier(0.23, 1, 0.32, 1);
        }

        .img-wrapper::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(
                to top,
                rgba(0,0,0,0.35),
                rgba(0,0,0,0.05),
                transparent
            );
            pointer-events: none;
        }

        .menu-card:hover .img-wrapper img {
            transform: scale(1.04) translateY(-4px);
            filter: brightness(1.05) contrast(1.05);
        }

        .stock-badge {
            position: absolute; top: 25px; left: 25px; background: var(--gold); color: var(--onyx);
            font-size: 9px; font-weight: 800; padding: 5px 14px; border-radius: 6px; text-transform: uppercase; letter-spacing: 1px;
        }

        .card-body { padding: 35px; text-align: center; flex: 1; display: flex; flex-direction: column; }
        .card-body h3 { font-size: 1.7rem; margin-bottom: 12px; color: #fff; }
        .card-body p { font-size: 0.9rem; opacity: 0.45; margin-bottom: 25px; flex: 1; font-weight: 300; }

        .card-footer {
            display: flex; justify-content: space-between; align-items: center;
            padding-top: 25px; border-top: 1px solid var(--gold-low);
        }
        .price-tag { font-size: 1.5rem; font-weight: 800; color: var(--gold); }
        
        .btn-order {
            width: 50px; height: 50px; border-radius: 50%; border: none;
            background: var(--gold); color: var(--onyx); cursor: pointer;
            transition: 0.4s; font-size: 1.2rem; display: flex; align-items: center; justify-content: center;
        }
        .btn-order:hover { transform: rotate(90deg) scale(1.1); background: #fff; box-shadow: 0 0 20px var(--gold); }
        .btn-sold { background: var(--gold-low); color: var(--gold-soft); cursor: not-allowed; }

        /* 
        ========================================================================
        VI. RICH FOOTER SYSTEM (MATCHING HOME)
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

        /* 
        ========================================================================
        VII. CUSTOM ORDER MODAL (LUXURY & COMPACT)
        ========================================================================
        */
        #orderModal {
            position: fixed;
            inset: 0;
            z-index: 10000;
            display: none; 
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal-backdrop {
            position: absolute;
            inset: 0;
            background: rgba(4, 2, 2, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .order-modal-box {
            position: relative;
            width: 100%;
            max-width: 340px; /* Diperkecil dari 400px */
            background: linear-gradient(145deg, #140d0e, #0a0607);
            border: 1px solid rgba(245, 222, 179, 0.15);
            border-radius: 30px; /* Corner lebih halus untuk ukuran kecil */
            padding: 35px 25px; /* Padding lebih rapat */
            z-index: 2;
            text-align: center;
            box-shadow: 0 30px 60px rgba(0,0,0,0.8);
            animation: modalEntrance 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        }

        @keyframes modalEntrance {
            from { opacity: 0; transform: scale(0.9) translateY(15px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }

        /* Foto diperkecil agar lebih manis */
        #modal-order-img {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 20px;
            border: 2px solid var(--gold);
            padding: 4px;
            background: var(--dark-gray);
            box-shadow: 0 10px 20px rgba(0,0,0,0.4);
        }

        .order-modal-box h2 { 
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem; /* Font diperkecil */
            color: var(--white); 
            margin-bottom: 6px;
            letter-spacing: 1px;
        }

        .price-display { 
            font-family: 'Poppins', sans-serif;
            color: var(--gold); 
            font-weight: 500; 
            font-size: 0.9rem; /* Font diperkecil */
            margin-bottom: 25px; 
            display: block;
            opacity: 0.8;
            letter-spacing: 1.5px;
        }

        /* Quantity Control lebih ramping */
        .qty-control {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin-bottom: 30px;
            background: rgba(255,255,255,0.03);
            padding: 8px 15px;
            border-radius: 50px;
            width: fit-content;
            margin-inline: auto;
            border: 1px solid var(--gold-low);
        }

        .qty-btn-custom {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 1px solid var(--gold-low);
            background: var(--onyx);
            color: var(--gold);
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .qty-btn-custom:hover { 
            background: var(--gold); 
            color: var(--onyx);
        }

        #input-qty-custom {
            width: 40px;
            text-align: center;
            background: none;
            border: none;
            color: var(--white);
            font-size: 1.2rem;
            font-weight: 600;
        }

        /* Tombol Confirm Ringkas */
        .btn-confirm-order {
            width: 100%;
            padding: 14px;
            background: var(--gold);
            color: var(--onyx);
            border: none;
            border-radius: 50px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 10px;
            cursor: pointer;
            transition: 0.4s;
        }

        .btn-confirm-order:hover {
            background: var(--white);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.3);
        }

        /* Tombol Close */
        .close-order-modal {
            position: absolute;
            top: 18px;
            right: 18px;
            color: var(--gold-soft);
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s;
            opacity: 0.6;
        }

        .close-order-modal:hover {
            opacity: 1;
            transform: rotate(90deg);
        }

        /* 
        ========================================================================
        VIII. LUXURY CART MODAL
        ========================================================================
        */        
        #cartModal {
            position: fixed; inset: 0; z-index: 10001;
            display: none; align-items: center; justify-content: center; padding: 20px;
        }

        .cart-modal-box {
            position: relative; 
            width: 100%; 
            max-width: 360px; /* Diperkecil agar serasi dengan Order Modal */
            background: linear-gradient(145deg, #140d0e, #0a0607);
            border: 1px solid rgba(245, 222, 179, 0.15);
            border-radius: 30px; 
            padding: 30px 20px; /* Padding lebih ramping */
            z-index: 2;
            box-shadow: 0 30px 80px rgba(0,0,0,0.9);
            animation: modalEntrance 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        }

        .cart-header { 
            text-align: center; 
            margin-bottom: 20px; 
            border-bottom: 1px solid var(--gold-low); 
            padding-bottom: 10px; 
        }
        .cart-header h2 { 
            font-family: 'Playfair Display', serif; 
            font-size: 1.5rem; /* Font diperkecil */
            color: var(--white); 
        }

        .cart-items-list {
            max-height: 250px; /* Tinggi list dikurangi agar modal tidak terlalu panjang */
            overflow-y: auto; 
            margin-bottom: 20px;
            padding-right: 5px;
            scrollbar-width: thin; 
            scrollbar-color: var(--gold-low) transparent;
        }
        .cart-items-list::-webkit-scrollbar { width: 3px; }
        .cart-items-list::-webkit-scrollbar-thumb { background: var(--gold-low); border-radius: 10px; }

        .cart-item {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 0; border-bottom: 1px solid rgba(255,255,255,0.03);
        }
        /* Thumbnail diperkecil */
        .cart-item img { 
            width: 45px; height: 45px; 
            object-fit: cover; border-radius: 8px; 
            border: 1px solid var(--gold-low); 
        }
        
        .item-info { flex: 1; }
        .item-info h4 { font-size: 0.85rem; color: var(--white); margin-bottom: 2px; }
        .item-info p { font-size: 0.75rem; color: var(--gold); font-weight: 500; }

        /* Kontrol Qty lebih kecil */
        .item-controls { display: flex; align-items: center; gap: 8px; }
        .item-controls button {
            width: 22px; height: 22px; 
            border-radius: 50%; border: 1px solid var(--gold-low);
            background: rgba(255,255,255,0.02); color: var(--gold); 
            font-size: 14px; cursor: pointer; transition: 0.3s;
            display: flex; align-items: center; justify-content: center;
        }
        .item-controls button:hover { background: var(--gold); color: var(--onyx); }
        .item-controls span { font-size: 0.85rem; color: var(--white); min-width: 15px; text-align: center; }

        .cart-footer { 
            border-top: 1px solid var(--gold-low); 
            padding-top: 20px; 
        }
        .cart-total { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .cart-total span { font-size: 0.8rem; color: var(--gold-soft); text-transform: uppercase; letter-spacing: 1.5px; }
        .cart-total b { font-size: 1.1rem; color: var(--gold); }

        .cart-actions { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        
        .btn-clear-cart { 
            background: none; border: 1px solid rgba(255,255,255,0.05); 
            color: #777; border-radius: 50px; 
            font-size: 9px; text-transform: uppercase; 
            cursor: pointer; transition: 0.3s; padding: 10px;
        }
        .btn-clear-cart:hover { border-color: #f44336; color: #f44336; background: rgba(244, 67, 54, 0.05); }
        
        .btn-checkout { 
            background: var(--gold); color: var(--onyx); 
            border: none; padding: 10px; border-radius: 50px; 
            font-weight: 700; text-transform: uppercase; 
            letter-spacing: 1.5px; font-size: 9px; 
            cursor: pointer; transition: 0.3s; 
        }
        .btn-checkout:hover { background: var(--white); transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,0,0,0.3); }

        /* Empty Cart State */
        .empty-cart-msg { text-align: center; padding: 30px 0; opacity: 0.3; }
        .empty-cart-msg i { font-size: 2.5rem; margin-bottom: 10px; display: block; }
        .empty-cart-msg p { font-size: 0.9rem; letter-spacing: 1px; }

        /* 
        ========================================================================
        IX. LUXURY CART BADGE
        ========================================================================
        */      
        #cart-badge {
            position: absolute;
            top: -8px;
            right: -10px;
            background: var(--gold);
            color: var(--onyx);
            font-size: 10px;
            font-weight: 800;
            min-width: 18px;
            height: 18px;
            padding: 0 4px;
            border-radius: 50%;
            display: none; /* Dikontrol JS */
            align-items: center;
            justify-content: center;
            border: 1.5px solid var(--onyx); /* Garis tepi agar kontras dengan ikon */
            box-shadow: 0 0 12px rgba(245, 222, 179, 0.5); /* Efek kilau emas */
            z-index: 10;
            transition: 0.3s var(--transit);
        }

        /* Animasi berdenyut saat ada item baru masuk */
        .badge-pulse {
            animation: badgePop 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        /* 
        ========================================================================
        IX. LUXURY SEARCH MODAL
        ========================================================================
        */  
        #searchModal {
            position: fixed; inset: 0; z-index: 10002;
            display: none; align-items: center; justify-content: center; padding: 20px;
        }

        .search-box {
            position: relative; width: 100%; max-width: 500px;
            background: linear-gradient(145deg, #140d0e, #0a0607);
            border: 1px solid rgba(245, 222, 179, 0.15);
            border-radius: 35px; padding: 50px 40px; z-index: 2;
            box-shadow: 0 40px 100px rgba(0,0,0,0.9);
            animation: modalEntrance 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        }

        .search-label {
            font-size: 10px; text-transform: uppercase; letter-spacing: 3px;
            color: var(--gold-soft); margin-bottom: 20px; text-align: center;
        }

        .input-group {
            position: relative; display: flex; align-items: center;
            border-bottom: 1px solid var(--gold-low); padding-bottom: 10px;
        }

        .input-group i { color: var(--gold); font-size: 18px; margin-right: 15px; }

        .input-group input {
            background: none; border: none; width: 100%;
            color: var(--white); font-family: 'Playfair Display', serif;
            font-size: 1.5rem; outline: none;
        }

        .input-group input::placeholder { color: rgba(255,255,255,0.1); }

        /* Hasil Pencarian */
        .search-results {
            margin-top: 30px; max-height: 250px; overflow-y: auto;
            scrollbar-width: none;
        }
        .search-results::-webkit-scrollbar { display: none; }

        .search-res-item {
            display: flex; align-items: center; gap: 15px; padding: 12px;
            border-radius: 15px; cursor: pointer; transition: 0.3s;
            margin-bottom: 5px;
        }
        .search-res-item:hover { background: rgba(245, 222, 179, 0.05); }

        .search-res-item img { width: 40px; height: 40px; border-radius: 10px; object-fit: cover; }
        .search-res-item span { color: var(--white); font-size: 0.9rem; font-weight: 500; }
        .search-res-item small { color: var(--gold); margin-left: auto; font-size: 0.8rem; }

        .close-search {
            position: absolute; top: 25px; right: 25px;
            color: var(--gold-soft); cursor: pointer; font-size: 18px;
        }

        @keyframes badgePop {
            0% { transform: scale(1); }
            50% { transform: scale(1.4); }
            100% { transform: scale(1); }
        }

        /* RESPONSIVE */
        @media (max-width: 1200px) {
            nav { padding: 0 30px; grid-template-columns: 1fr auto; }
            .nav-menu { display: none; }
            .hamb-btn { display: flex; }
            .footer-grid { grid-template-columns: 1fr 1fr; gap: 60px; }
        }

        @media (max-width: 768px) {
            .menu-section { padding: 60px 25px; }
            .hero-title-box h1 { font-size: 4rem; }
            .footer-grid { grid-template-columns: 1fr; text-align: center; }
            .f-contact p { justify-content: center; }
            .mobile-panel { max-width: 100%; }
            .category-scroll { justify-content: flex-start; }
            .f-socials { justify-content: center; }
            .order-modal-box { 
                max-width: 330px; 
                padding: 40px 25px;
                border-radius: 35px;
            }
            #modal-order-img { width: 100px; height: 100px; }
            .order-modal-box h2 { font-size: 1.6rem; }
            .btn-confirm-order { padding: 15px; }
            .cart-modal-box { max-width: 320px; padding: 30px 20px; }
            .search-box { max-width: 320px; padding: 40px 20px; }
            .input-group input { font-size: 1.2rem; }
        }
    </style>
</head>
<body>

    <!-- 1. LUXURY NAVBAR (SAME AS HOME) -->
    <header id="navbar">
        <nav>
            <a href="<?= base_url('/') ?>" class="brand">
                <i class="fas fa-mug-hot"></i><span>Coffee Time</span>
            </a>

            <!-- Desktop Links (Center) -->
            <ul class="nav-menu">
                <li><a href="<?= base_url('/') ?>">Home</a></li>
                <li><a href="<?= base_url('menu') ?>" class="active">Menu</a></li>
                <li><a href="<?= base_url('gallery') ?>">Gallery</a></li>
                <li><a href="<?= base_url('blog') ?>" >Journal</a></li>
                <li><a href="<?= base_url('about') ?>">Story</a></li>
                <li><a href="<?= base_url('contact') ?>">Contact</a></li>
            </ul>

            <div class="nav-extra">
                <a href="javascript:void(0)" id="openSearch"><i class="fas fa-search"></i></a>
                <a href="#" id="cartBtn" style="position:relative">
                    <i class="fas fa-shopping-cart"></i>
                    <span id="cart-badge"></span>
                </a>
                <?php if(isset($is_logged_in) && $is_logged_in): ?>
                    <a href="<?= base_url('auth/logout') ?>" title="Logout"><i class="fas fa-sign-out-alt"></i></a>
                <?php else: ?>
                    <a href="<?= base_url('auth/login') ?>"><i class="fas fa-user-circle"></i></a>
                <?php endif; ?>

                <div class="hamb-btn" id="open-panel">
                    <span></span><span></span><span></span>
                </div>
            </div>
        </nav>
    </header>

    <!-- 2. MOBILE OVERLAY PANEL (CENTERED - SAME AS HOME) -->
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

    <!-- 3. MENU HERO -->
    <section class="menu-hero">
        <div class="hero-bg" id="parallax-bg"></div>
        <div class="hero-title-box">
            <p id="hero-subtitle">Artisan Selection</p>
            <h1 id="hero-title">The Menu</h1>
        </div>
    </section>

    <!-- 4. CATEGORIES -->
    <div class="category-container">
        <div class="category-scroll">

            <a href="<?= base_url('menu') ?>"
            class="cat-pill <?= !$activeCat ? 'active' : '' ?>"
            data-filter="all">
                All Selection
            </a>

            <?php foreach ($categories as $cat): ?>
                <a href="<?= base_url('menu?category=' . $cat['category_slug']) ?>"
                class="cat-pill <?= ($activeCat === $cat['category_slug']) ? 'active' : '' ?>"
                data-filter="<?= esc($cat['category_slug']) ?>">
                    <?= esc($cat['category_name']) ?>
                </a>
            <?php endforeach; ?>

        </div>
    </div>

    <!-- 5. MODAL ORDER CUSTOM -->
    <div id="orderModal">
        <div class="modal-backdrop"></div>
        <div class="order-modal-box">
            <i class="fas fa-times close-order-modal" id="closeOrderModal"></i>
            <img id="modal-order-img" src="" alt="">
            <h2 id="modal-order-title">Name</h2>
            <span class="price-display" id="modal-order-price">Rp 0</span>
            
            <div class="qty-control">
                <button class="qty-btn-custom" onclick="adjustQtyCustom(-1)">-</button>
                <input type="number" id="input-qty-custom" value="1" readonly>
                <button class="qty-btn-custom" onclick="adjustQtyCustom(1)">+</button>
            </div>

            <button class="btn-confirm-order" id="confirmAddBtn">Add to Order</button>
        </div>
    </div>

    <!--6. LUXURY CART MODAL -->
    <div id="cartModal">
        <div class="modal-backdrop"></div>
        <div class="cart-modal-box">
            <i class="fas fa-times close-order-modal" onclick="closeCartModal()"></i>
            
            <div class="cart-header">
                <h2>Your Selection</h2>
            </div>

            <div class="cart-items-list" id="cartItemsList">
                <!-- Items akan diisi oleh JS -->
            </div>

            <div id="cartFooterArea">
                <div class="cart-footer">
                    <div class="cart-total">
                        <span>Grand Total</span>
                        <b id="cartGrandTotal">Rp 0</b>
                    </div>
                    <div class="cart-actions">
                        <button class="btn-clear-cart" onclick="clearCart()">Clear All</button>
                        <button class="btn-checkout" onclick="proceedToCheckout()">Checkout</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 7. MENU GRID -->
    <main class="menu-section">
        <div class="menu-grid">
            <?php if (!empty($products) && is_array($products)): ?>
                <?php foreach ($products as $row): ?>
                    <?php 
                        $stok = $row['stock'];
                        $is_sold_out = ($stok <= 0);
                        $name = esc($row['name']);
                        $price = $row['price'];
                        $img = $row['image'];
                    ?>
                    <article class="menu-card reveal" data-category="<?= esc($row['category_id']) ?>">
                        <div class="img-wrapper">
                            <img src="<?= esc($img) ?>"
                                alt="<?= esc($name) ?>"
                                onerror="this.src='https://dummyimage.com/400x400/1a1a1a/f5deb3&text=Coffee+Time'">
                            <?php if($is_sold_out): ?>
                                <span class="stock-badge" style="background:#c0392b; color:#fff;">Sold Out</span>
                            <?php elseif($stok < 10): ?>
                                <span class="stock-badge">Limited: <?= $stok ?>!</span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="card-body">
                            <h3><?= $name ?></h3>
                            <p><?= esc($row['description']) ?></p>
                            
                            <div class="card-footer">
                                <span class="price-tag">Rp <?= number_format($price, 0, ',', '.') ?></span>
                                <button class="btn-order <?= $is_sold_out ? 'btn-sold' : '' ?>" 
                                        <?= $is_sold_out ? 'disabled' : "onclick=\"handleOrder({$row['id']}, '$name', $price, '$img')\"" ?>>
                                    <i class="fas <?= $is_sold_out ? 'fa-ban' : 'fa-plus' ?>"></i>
                                </button>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="grid-column: 1/-1; text-align: center; padding: 100px 0;">
                    <i class="fas fa-mug-hot" style="font-size: 3rem; opacity: 0.1;"></i>
                    <p style="margin-top: 20px; opacity: 0.5;">Our curated menu is currently being updated.</p>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <!-- 8. LUXURY SEARCH MODAL -->
    <div id="searchModal">
        <div class="modal-backdrop"></div>
        <div class="search-box">
            <i class="fas fa-times close-search" id="closeSearch"></i>
            <div class="search-inner">
                <p class="search-label">What are you looking for?</p>
                <div class="input-group">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Type to search menu..." autocomplete="off">
                </div>
                <div id="searchResults" class="search-results">
                    <!-- Hasil pencarian akan muncul di sini -->
                </div>
            </div>
        </div>
    </div>

    <!-- 9. RICH FOOTER (SAME AS HOME) -->
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
         * 0. CONFIGURATION & USER SESSION
         */
        // Mengambil status login dan ID user dari session PHP
        const isLoggedIn = <?= (isset($is_logged_in) && $is_logged_in) ? 'true' : 'false' ?>;
        const currentUserId = "<?= session()->get('user_id') ?: '' ?>"; 

        /**
         * FUNGSI UTAMA: Mendapatkan key unik keranjang berdasarkan User ID
         * Jika tidak login, fungsi mengembalikan null agar tidak bisa akses keranjang
         */
        const getCartKey = () => {
            return (isLoggedIn && currentUserId) ? `coffee_cart_user_${currentUserId}` : null;
        };

        /**
         * 1. INITIALIZATION
         */
        document.addEventListener('DOMContentLoaded', () => {
            updateCartBadge();
            initEngines();
            handleHeroAnimation();
        });

        function initEngines() {
            // Scroll Reveal Animation
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) entry.target.classList.add('active');
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

            // Scroll & Parallax Events
            window.addEventListener('scroll', () => {
                const scroll = window.scrollY;
                const navbar = document.getElementById('navbar');
                const bg = document.getElementById('parallax-bg');
                
                if(navbar) navbar.classList.toggle('scrolled', scroll > 50);
                if(bg) bg.style.transform = `scale(1.1) translateY(${scroll * 0.35}px)`;
            });
        }

        function handleHeroAnimation() {
            const subtitle = document.getElementById('hero-subtitle');
            const title = document.getElementById('hero-title');
            if (!subtitle || !title) return;

            const skipAnim = sessionStorage.getItem('skipHeroAnim');

            if (skipAnim) {
                // KATEGORI → NO ANIMATION
                subtitle.style.opacity = 1;
                title.style.opacity = 1;
                sessionStorage.removeItem('skipHeroAnim'); // reset
                return;
            }

            // PAGE LOAD / REFRESH → ANIMATION
            subtitle.classList.remove('animate__animated', 'animate__fadeInDown');
            title.classList.remove('animate__animated', 'animate__fadeInUp');

            void subtitle.offsetHeight;
            void title.offsetHeight;

            subtitle.classList.add('animate__animated', 'animate__fadeInDown');
            title.classList.add('animate__animated', 'animate__fadeInUp');

            subtitle.style.opacity = 1;
            title.style.opacity = 1;
        }

        /**
         * 2. MOBILE PANEL (SIDEBAR)
         */
        const openPanel = document.getElementById('open-panel');
        const closePanel = document.getElementById('close-panel');
        const panel = document.getElementById('panel');
        const overlay = document.getElementById('overlay');

        function togglePanel(status) {
            if(panel) panel.classList.toggle('active', status);
            if(overlay) overlay.classList.toggle('active', status);
            document.body.style.overflow = status ? 'hidden' : 'auto';
        }

        if(openPanel) openPanel.addEventListener('click', () => togglePanel(true));
        if(closePanel) closePanel.addEventListener('click', () => togglePanel(false));
        if(overlay) overlay.addEventListener('click', () => togglePanel(false));

        /**
         * 3. ORDER MODAL & ADD TO CART LOGIC
         */
        const orderModal = document.getElementById('orderModal');
        let currentOrderData = {};

        function handleOrder(id, name, price, img) { 
            if (!isLoggedIn) {
                Swal.fire({
                    title: 'Akses Terbatas', 
                    text: 'Silakan masuk ke akun Anda untuk memesan.', 
                    icon: 'warning',
                    background: '#0a0506', color: '#f5deb3', confirmButtonColor: '#f5deb3',
                    confirmButtonText: '<span style="color:#070404">Login Sekarang</span>'
                }).then(r => { if(r.isConfirmed) window.location.href = "<?= base_url('auth/login') ?>"; });
                return;
            }

            // Simpan data ke variabel sementara, pastikan ID dan Price adalah angka murni
            currentOrderData = { 
                id: Number(id), 
                name: name, 
                price: Number(price), 
                img: img 
            }; 

            document.getElementById('modal-order-img').src = img;
            document.getElementById('modal-order-title').innerText = name;
            document.getElementById('modal-order-price').innerText = `Rp ${new Intl.NumberFormat('id-ID').format(price)}`;
            document.getElementById('input-qty-custom').value = 1;

            if(orderModal) {
                orderModal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        }

        window.adjustQtyCustom = (change) => {
            const input = document.getElementById('input-qty-custom');
            let val = parseInt(input.value) + change;
            if (val < 1) val = 1;
            input.value = val;
        };

        function closeOrderModalFunc() {
            if(orderModal) orderModal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        if(document.getElementById('closeOrderModal')) {
            document.getElementById('closeOrderModal').onclick = closeOrderModalFunc;
        }

        document.getElementById('confirmAddBtn').onclick = () => {
            const qty = parseInt(document.getElementById('input-qty-custom').value);
            
            // PENTING: Mencegah NaN dengan casting Number()
            addToCart(
                currentOrderData.id, 
                currentOrderData.name, 
                currentOrderData.price, 
                qty, 
                currentOrderData.img
            );
            
            closeOrderModalFunc();

            Swal.fire({ 
                icon: 'success', title: 'Luxury Choice Added', 
                text: `${qty}x ${currentOrderData.name} telah masuk daftar pesanan.`, 
                timer: 1500, showConfirmButton: false, background: '#0a0506', color: '#f5deb3' 
            });
        };

        function addToCart(id, name, price, qty, img) {
            const cartKey = getCartKey();
            if(!cartKey) return;

            let cart = JSON.parse(localStorage.getItem(cartKey)) || [];
            
            // Pastikan tipe data konsisten agar tidak NaN
            id = Number(id);
            price = Number(price);
            qty = Number(qty);

            let item = cart.find(i => Number(i.id) === id);
            
            if (item) {
                item.qty = Number(item.qty) + qty;
            } else {
                cart.push({ id, name, price, qty, img });
            }
            
            localStorage.setItem(cartKey, JSON.stringify(cart));
            updateCartBadge();
        }

        function updateCartBadge() {
            const cartKey = getCartKey();
            const badge = document.getElementById('cart-badge');
            if (!badge) return;

            if (!isLoggedIn || !cartKey) {
                badge.style.display = 'none';
                return;
            }

            let cart = JSON.parse(localStorage.getItem(cartKey)) || [];
            let totalQty = cart.reduce((sum, item) => sum + Number(item.qty), 0);

            if (totalQty > 0) {
                badge.style.display = 'flex';
                badge.innerText = totalQty;
                badge.classList.remove('badge-pulse');
                void badge.offsetWidth; 
                badge.classList.add('badge-pulse');
            } else {
                badge.style.display = 'none';
            }
        }

        /**
         * 4. RENDER CART MODAL (FIX NaN ISSUE)
         */
        const cartModal = document.getElementById('cartModal');
        const cartItemsList = document.getElementById('cartItemsList');

        document.getElementById('cartBtn').onclick = (e) => {
            e.preventDefault();
            renderCart();
            if(cartModal) {
                cartModal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        };

        function closeCartModal() {
            if(cartModal) cartModal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        if(document.querySelector('#cartModal .modal-backdrop')) {
            document.querySelector('#cartModal .modal-backdrop').onclick = closeCartModal;
        }

        function renderCart() {
            const cartKey = getCartKey();
            if(!cartItemsList) return;
            
            cartItemsList.innerHTML = '';
            
            if (!isLoggedIn || !cartKey) {
                cartItemsList.innerHTML = `<div class="empty-cart-msg"><i class="fas fa-lock"></i><p>Silakan login untuk memuat keranjang Anda.</p></div>`;
                document.getElementById('cartFooterArea').style.display = 'none';
                return;
            }

            let cart = JSON.parse(localStorage.getItem(cartKey)) || [];
            let grandTotal = 0;

            if (cart.length === 0) {
                cartItemsList.innerHTML = `<div class="empty-cart-msg"><i class="fas fa-mug-hot"></i><p>Keranjang Anda masih kosong.</p></div>`;
                document.getElementById('cartFooterArea').style.display = 'none';
                return;
            }

            document.getElementById('cartFooterArea').style.display = 'block';

            cart.forEach((item, index) => {
                // Memastikan perhitungan matematika tidak NaN
                let p = Number(item.price);
                let q = Number(item.qty);
                let subtotal = p * q;
                grandTotal += subtotal;

                cartItemsList.innerHTML += `
                    <div class="cart-item">
                        <img src="${item.img}" onerror="this.src='https://dummyimage.com/100/1a1a1a/f5deb3'">
                        <div class="item-info">
                            <h4>${item.name}</h4>
                            <p>Rp ${new Intl.NumberFormat('id-ID').format(p)}</p>
                        </div>
                        <div class="item-controls">
                            <button onclick="updateCartQty(${index}, -1)">-</button>
                            <span>${q}</span>
                            <button onclick="updateCartQty(${index}, 1)">+</button>
                        </div>
                    </div>
                `;
            });

            document.getElementById('cartGrandTotal').innerText = `Rp ${new Intl.NumberFormat('id-ID').format(grandTotal)}`;
        }

        window.updateCartQty = (index, change) => {
            const cartKey = getCartKey();
            if(!cartKey) return;

            let cart = JSON.parse(localStorage.getItem(cartKey)) || [];
            if(!cart[index]) return;

            cart[index].qty = Number(cart[index].qty) + change;
            
            if (cart[index].qty <= 0) cart.splice(index, 1);
            
            localStorage.setItem(cartKey, JSON.stringify(cart));
            renderCart();
            updateCartBadge();
        };

        window.clearCart = () => {
            const cartKey = getCartKey();
            if(cartKey) {
                localStorage.removeItem(cartKey);
                renderCart();
                updateCartBadge();
            }
        };

        /**
         * 5. SEARCH & FILTER LOGIC
         */
        const searchModal = document.getElementById('searchModal');
        const searchInput = document.getElementById('searchInput');
        const searchResults = document.getElementById('searchResults');
        
        if(document.getElementById('openSearch')) {
            document.getElementById('openSearch').onclick = (e) => {
                e.preventDefault();
                searchModal.style.display = 'flex';
                searchInput.focus();
                document.body.style.overflow = 'hidden';
            };
        }

        const closeSearchFunc = () => {
            if(searchModal) searchModal.style.display = 'none';
            searchInput.value = '';
            searchResults.innerHTML = '';
            document.body.style.overflow = 'auto';
        };

        if(document.getElementById('closeSearch')) document.getElementById('closeSearch').onclick = closeSearchFunc;

        if(searchInput) {
            searchInput.oninput = () => {
                const query = searchInput.value.toLowerCase().trim();
                searchResults.innerHTML = '';
                if (query.length < 1) return;

                const cards = Array.from(document.querySelectorAll('.menu-card'));
                const filtered = cards.filter(c => c.querySelector('h3').innerText.toLowerCase().includes(query));

                if (filtered.length === 0) {
                    searchResults.innerHTML = '<p style="text-align:center; opacity:0.3; font-size:12px; padding:20px;">Menu tidak ditemukan...</p>';
                    return;
                }

                filtered.forEach(card => {
                    const name = card.querySelector('h3').innerText;
                    const price = card.querySelector('.price-tag').innerText;
                    const img = card.querySelector('img').src;
                    
                    const item = document.createElement('div');
                    item.className = 'search-res-item';
                    item.innerHTML = `<img src="${img}"><span>${name}</span><small>${price}</small>`;
                    item.onclick = () => {
                        closeSearchFunc();
                        card.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        card.style.borderColor = 'var(--gold)';
                        setTimeout(() => { card.style.borderColor = 'var(--gold-low)'; }, 2000);
                    };
                    searchResults.appendChild(item);
                });
            };
        }

        // Filter Kategori (Client-Side)
        document.querySelectorAll('.cat-pill').forEach(pill => {
            pill.addEventListener('click', e => {
                sessionStorage.setItem('skipHeroAnim', '1');
                const filter = pill.dataset.filter;
                if (!filter) return;

                document.querySelectorAll('.menu-card').forEach(card => {
                    const cat = card.dataset.category;
                    if (filter === 'all' || cat === filter) card.classList.remove('hide');
                    else card.classList.add('hide');
                });
            });
        });

        window.proceedToCheckout = () => {
            window.location.href = "<?= base_url('checkout') ?>";
        };
    </script>
    <?= view('partials/flash') ?>
</body>
</html>
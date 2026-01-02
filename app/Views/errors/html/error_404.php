<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>404 - Aroma Lost | Coffee Time</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@600&family=Playfair+Display:ital,wght@0,700;1,900&family=Poppins:wght@200;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <style>
        :root {
            --onyx: #050505;
            --espresso-dark: #120b0a;
            --gold: #f5deb3;         
            --gold-bright: #ffedcc;
            --white-soft: rgba(255, 255, 255, 0.6);
            --transit: cubic-bezier(0.23, 1, 0.32, 1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        html, body { height: 100%; width: 100%; overflow: hidden; background-color: var(--onyx); }

        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            /* Gradasi Animasi yang "Bernapas" */
            background: radial-gradient(circle at center, #1a0f0e 0%, #050505 100%);
            background-size: 150% 150%;
            animation: bgBreathe 10s ease-in-out infinite;
        }

        @keyframes bgBreathe {
            0%, 100% { background-position: 50% 50%; background-size: 100% 100%; }
            50% { background-position: 50% 60%; background-size: 130% 130%; }
        }

        /* Overlay Tekstur Halus */
        body::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image: url("https://www.transparenttextures.com/patterns/black-linen.png");
            opacity: 0.15;
            pointer-events: none;
            z-index: 1;
        }

        /* ULTRA COMPACT WRAPPER */
        .error-wrapper {
            width: 90%;
            max-width: 320px; /* Diperkecil untuk tampilan Windows & Mobile */
            z-index: 10;
        }

        /* JEWEL CARD DESIGN (Tanpa Animasi Muncul) */
        .luxury-card {
            background: rgba(15, 12, 12, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(245, 222, 179, 0.12);
            padding: 40px 25px;
            border-radius: 30px;
            text-align: center;
            box-shadow: 0 50px 100px rgba(0,0,0,0.8), 
                        inset 0 0 20px rgba(245, 222, 179, 0.02);
            position: relative;
            overflow: hidden;
        }

        /* Efek Garis Pemindai (Scanline) Halus */
        .luxury-card::after {
            content: "";
            position: absolute;
            top: -100%;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, transparent, rgba(245, 222, 179, 0.03), transparent);
            animation: scan 4s linear infinite;
        }

        @keyframes scan {
            0% { top: -100%; }
            100% { top: 100%; }
        }

        .brand-logo {
            font-family: 'Dancing Script', cursive;
            font-size: 1.5rem;
            margin-bottom: 25px;
            display: block;
            color: var(--gold);
            text-decoration: none;
            letter-spacing: 1px;
            opacity: 0.8;
        }

        /* 404 DENGAN GRADASI EMAS ANIMASI */
        .error-code {
            font-family: 'Playfair Display', serif;
            font-size: 5.5rem;
            font-weight: 900;
            line-height: 0.8;
            margin-bottom: 15px;
            display: block;

            background: linear-gradient(to right, #8a6d3b, #f5deb3, #8a6d3b);
            background-size: 200% auto;

            background-clip: text;              /* ✅ versi standar */
            -webkit-background-clip: text;      /* ✅ fallback WebKit */
            color: transparent;                 /* ✅ standar pengganti -webkit-text-fill-color */

            animation: goldFlow 4s linear infinite;
            filter: drop-shadow(0 0 15px rgba(245, 222, 179, 0.2));
        }

        @keyframes goldFlow {
            to { background-position: 200% center; }
        }

        h1 {
            font-family: 'Playfair Display', serif;
            font-size: 0.85rem;
            letter-spacing: 6px;
            text-transform: uppercase;
            margin-bottom: 25px;
            color: var(--white-soft);
            font-weight: 400;
        }

        .divider {
            width: 40px;
            height: 1px;
            background: linear-gradient(to right, transparent, var(--gold), transparent);
            margin: 0 auto 25px;
        }

        p {
            font-size: 0.8rem;
            line-height: 1.8;
            color: var(--white-soft);
            margin-bottom: 35px;
            font-weight: 200;
            padding: 0 10px;
        }

        .nav-actions {
            display: flex;
            flex-direction: column;
            gap: 12px;
            align-items: center;
        }

        .btn-lux {
            text-decoration: none;
            width: 100%;
            max-width: 180px;
            padding: 14px 0;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 3px;
            transition: 0.4s var(--transit);
            border-radius: 50px; /* Dibuat bulat agar lebih modern */
        }

        .btn-gold {
            background: var(--gold);
            color: var(--onyx);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.4);
        }

        .btn-gold:hover {
            background: var(--white-soft);
            color: var(--onyx);
            transform: translateY(-2px);
        }

        .btn-outline {
            border: 1px solid rgba(245, 222, 179, 0.2);
            color: var(--gold);
        }

        .btn-outline:hover {
            background: rgba(245, 222, 179, 0.05);
            border-color: var(--gold);
        }

        .footer-tag {
            margin-top: 40px;
            font-size: 7px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--gold);
            opacity: 0.4;
        }

        /* RESPONSIVE FIX */
        @media (max-width: 768px) {
            .error-wrapper { max-width: 280px; } /* Lebih kecil di mobile */
            .error-code { font-size: 4.5rem; }
            h1 { font-size: 0.7rem; letter-spacing: 4px; }
            .luxury-card { padding: 30px 15px; }
        }
    </style>
</head>
<body>

    <div class="error-wrapper">
        <div class="luxury-card">
            <!-- Brand -->
            <a href="<?= base_url('/') ?>" class="brand-logo">Coffee Time</a>

            <!-- Content Area -->
            <span class="error-code">404</span>
            <h1>Aroma Lost</h1>
            
            <div class="divider"></div>

            <p>
                <?php if (ENVIRONMENT !== 'production') : ?>
                    <code style="font-family: monospace; color: var(--gold); font-size: 0.7rem;"><?= esc($message) ?></code>
                <?php else : ?>
                    Maaf, sesi Anda terputus dari sistem pusat. Mari kembali ke beranda utama.
                <?php endif; ?>
            </p>

            <!-- Navigation Buttons -->
            <div class="nav-actions">
                <a href="<?= base_url('/') ?>" class="btn-lux btn-gold">Refresh Session</a>
                <a href="javascript:history.back()" class="btn-lux btn-outline">Go Back</a>
            </div>

            <!-- Registry Tag -->
            <div class="footer-tag">
                Terminal Access &bull; CT-2026
            </div>
        </div>
    </div>

</body>
</html>
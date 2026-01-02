<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?= lang('Errors.whoops') ?> | Coffee Time</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@600&family=Playfair+Display:ital,wght@0,700;1,900&family=Poppins:wght@200;400;600&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --onyx: #050505;
            --espresso-dark: #120b0a;
            --gold: #f5deb3;         
            --gold-muted: rgba(245, 222, 179, 0.4);
            --white-soft: rgba(255, 255, 255, 0.6);
            --transit: cubic-bezier(0.23, 1, 0.32, 1);
        }

        /* 1. ANIMATED FLOWING BACKGROUND */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--onyx);
            /* Gradasi yang mengalir perlahan */
            background: linear-gradient(-45deg, #050505, #1a0f0e, #120b0a, #050505);
            background-size: 400% 400%;
            animation: gradientFlow 15s ease infinite;
            font-family: 'Poppins', sans-serif;
            overflow: hidden;
        }

        @keyframes gradientFlow {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Tekstur Linen Overlay */
        body::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image: url("https://www.transparenttextures.com/patterns/black-linen.png");
            opacity: 0.1;
            pointer-events: none;
            z-index: 1;
        }

        /* 2. ULTRA COMPACT CARD */
        .error-wrapper {
            position: relative;
            z-index: 10;
            width: 90%;
            max-width: 320px; /* Diperkecil untuk tampilan Windows & Mobile */
        }

        .error-card {
            background: rgba(15, 12, 12, 0.85);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(245, 222, 179, 0.12);
            padding: 40px 25px;
            border-radius: 30px;
            text-align: center;
            box-shadow: 0 40px 80px rgba(0,0,0,0.9), 
                        inset 0 0 20px rgba(245, 222, 179, 0.02);
            position: relative;
            overflow: hidden;
        }

        /* Efek Shimmer (Kilatan) */
        .error-card::after {
            content: "";
            position: absolute;
            top: -150%; left: -150%;
            width: 300%; height: 300%;
            background: linear-gradient(45deg, transparent, rgba(245, 222, 179, 0.03), transparent);
            transform: rotate(45deg);
            animation: shimmer 8s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%) rotate(45deg); }
            100% { transform: translateX(100%) rotate(45deg); }
        }

        /* 3. ELEMENTS STYLING */
        .brand-logo {
            font-family: 'Dancing Script', cursive;
            font-size: 1.5rem;
            color: var(--gold);
            display: block;
            margin-bottom: 25px;
            opacity: 0.8;
            letter-spacing: 1px;
        }

        .icon-box {
            font-size: 2.5rem;
            margin-bottom: 15px;
            color: var(--gold);
            filter: drop-shadow(0 0 10px rgba(245, 222, 179, 0.2));
        }

        h1 {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 900;
            font-style: italic;
            color: #fff;
            margin-bottom: 12px;
            letter-spacing: 1px;
        }

        p {
            font-size: 0.8rem;
            line-height: 1.7;
            color: var(--gold-muted);
            margin-bottom: 30px;
            font-weight: 200;
        }

        .btn-home {
            display: inline-block;
            text-decoration: none;
            background: var(--gold);
            color: var(--onyx);
            padding: 12px 30px;
            border-radius: 50px;
            font-size: 9px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 3px;
            transition: 0.4s var(--transit);
        }

        .btn-home:hover {
            background: #fff;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.5);
        }

        .footer-tag {
            margin-top: 30px;
            font-size: 7px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--gold-muted);
            opacity: 0.4;
        }

        /* MOBILE OPTIMIZATION */
        @media (max-width: 768px) {
            .error-wrapper { max-width: 280px; }
            h1 { font-size: 1.5rem; }
            .error-card { padding: 35px 20px; }
        }
    </style>
</head>
<body>

    <div class="error-wrapper">
        
        <div class="error-card">
            <span class="brand-logo">Coffee Time</span>

            <div class="icon-box">
                <i class="fas fa-wind"></i>
            </div>

            <h1><?= lang('Errors.whoops') ?></h1>
            
            <p>
                <?= lang('Errors.weHitASnag') ?><br>
                Kami sedang menyeimbangkan racikan sistem. Mohon kunjungi kembali beberapa saat lagi.
            </p>

            <a href="/" class="btn-home">
                Return to Home
            </a>
        </div>

        <div class="footer-tag">
            Sovereign Private Console &bull; CT-2026
        </div>

    </div>

</body>
</html>
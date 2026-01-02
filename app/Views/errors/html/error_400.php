<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>400 - Request Interrupted | Coffee Time</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@600&family=Playfair+Display:wght@700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-deep: #050303;          
            --bg-accent: #1a1213;
            --card-bg: #120d0e;
            --gold: #f5deb3;         
            --gold-glow: rgba(245, 222, 179, 0.4);
            --white: #ffffff;
            --transit: cubic-bezier(0.23, 1, 0.32, 1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        html, body { height: 100%; width: 100%; overflow: hidden; }

        body {
            /* Background Gradasi Hidup */
            background: radial-gradient(circle at center, var(--bg-accent) 0%, var(--bg-deep) 100%);
            background-size: 200% 200%;
            animation: gradientMove 10s ease infinite;
            color: var(--gold);
            font-family: 'Poppins', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Animasi Background Berdenyut */
        @keyframes gradientMove {
            0% { background-position: 50% 50%; }
            50% { background-position: 55% 45%; }
            100% { background-position: 50% 50%; }
        }

        /* ULTRA COMPACT WRAPPER */
        .error-wrapper {
            width: 85%;
            max-width: 340px; /* Sangat kecil & padat */
            perspective: 1000px;
        }

        /* JEWEL CARD DESIGN */
        .luxury-card {
            background: linear-gradient(145deg, #161011, #0d090a);
            border: 1px solid rgba(245, 222, 179, 0.15);
            padding: 35px 25px;
            border-radius: 4px;
            text-align: center;
            box-shadow: 0 25px 50px rgba(0,0,0,0.9);
            position: relative;
            overflow: hidden;
            animation: cardEntrance 1.2s var(--transit);
        }

        /* Efek Kilau (Shimmer) pada Kartu */
        .luxury-card::after {
            content: "";
            position: absolute;
            top: -150%; left: -150%;
            width: 300%; height: 300%;
            background: linear-gradient(45deg, transparent, rgba(245, 222, 179, 0.03), transparent);
            transform: rotate(45deg);
            animation: shimmer 6s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%) rotate(45deg); }
            100% { transform: translateX(100%) rotate(45deg); }
        }

        @keyframes cardEntrance {
            from { opacity: 0; transform: scale(0.9) translateY(20px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }

        .brand-logo {
            font-family: 'Dancing Script', cursive;
            font-size: 1.5rem;
            margin-bottom: 20px;
            display: block;
            letter-spacing: 1px;
            animation: fadeIn 2s ease;
        }

        .error-code {
            font-family: 'Playfair Display', serif;
            font-size: 4rem;
            font-weight: 700;
            line-height: 1;
            margin-bottom: 5px;
            display: block;
            color: var(--gold);
            text-shadow: 0 0 20px rgba(245, 222, 179, 0.2);
            animation: pulseText 3s ease-in-out infinite;
        }

        @keyframes pulseText {
            0%, 100% { opacity: 0.8; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.02); }
        }

        h1 {
            font-family: 'Playfair Display', serif;
            font-size: 1rem;
            letter-spacing: 4px;
            text-transform: uppercase;
            margin-bottom: 20px;
            color: var(--white);
            opacity: 0.9;
        }

        .divider {
            width: 30px;
            height: 1px;
            background: var(--gold);
            margin: 0 auto 20px;
            opacity: 0.3;
        }

        p {
            font-size: 0.8rem;
            line-height: 1.6;
            color: var(--white);
            opacity: 0.5;
            margin-bottom: 30px;
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
            padding: 12px 0;
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 3px;
            transition: 0.4s var(--transit);
            border-radius: 2px;
            position: relative;
            z-index: 5;
        }

        .btn-gold {
            background: var(--gold);
            color: #0d090a;
            border: 1px solid var(--gold);
        }

        .btn-gold:hover {
            background: transparent;
            color: var(--gold);
            box-shadow: 0 0 15px var(--gold-glow);
            transform: translateY(-2px);
        }

        .btn-outline {
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--white);
            opacity: 0.4;
        }

        .btn-outline:hover {
            opacity: 1;
            border-color: var(--gold);
            color: var(--gold);
        }

        .footer-tag {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid rgba(245, 222, 179, 0.05);
            font-size: 7px;
            letter-spacing: 2px;
            text-transform: uppercase;
            opacity: 0.2;
        }

        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

        /* MOBILE FIX */
        @media (max-width: 480px) {
            .error-wrapper { width: 85%; }
            .luxury-card { padding: 30px 20px; }
        }
    </style>
</head>
<body>

    <div class="error-wrapper">
        <div class="luxury-card">
            <!-- Brand -->
            <span class="brand-name brand-logo">Coffee Time</span>

            <!-- Content -->
            <span class="error-code">400</span>
            <h1>Bad Request</h1>
            
            <div class="divider"></div>

            <p>Maaf, permintaan tidak dapat diproses. Mari kembali ke beranda.</p>

            <!-- Actions -->
            <div class="nav-actions">
                <a href="<?= base_url('/') ?>" class="btn-lux btn-gold">Return Home</a>
                <a href="javascript:history.back()" class="btn-lux btn-outline">Go Back</a>
            </div>

            <!-- Metadata -->
            <div class="footer-tag">
                Sovereign Private &bull; 2026
            </div>
        </div>
    </div>

</body>
</html>
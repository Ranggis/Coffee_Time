<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Link Expired | Coffee Time Private</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    
    <!-- Icons & Fonts -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=Poppins:wght@200;300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --onyx: #070404;
            --gold: #f5deb3;
            --gold-muted: rgba(245, 222, 179, 0.4);
            --gold-low: rgba(245, 222, 179, 0.1);
            --white: #ffffff;
            --transit: cubic-bezier(0.23, 1, 0.32, 1);
        }

        /* ================= BASE STYLES ================= */
        * { margin: 0; padding: 0; box-sizing: border-box; -webkit-tap-highlight-color: transparent; }
        
        body {
            background: var(--onyx);
            color: var(--gold);
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            min-height: 100svh; 
            background-image: linear-gradient(rgba(7,4,4,0.94), rgba(7,4,4,0.94)), 
                              url('https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            padding: 20px;
            overflow: hidden;
        }

        /* Linen Texture Overlay */
        body::after {
            content: ""; position: fixed; inset: 0;
            background-image: url("https://www.transparenttextures.com/patterns/black-linen.png");
            opacity: 0.1; pointer-events: none; z-index: 1;
        }

        /* ================= CARD DESIGN (REFINED) ================= */
        .error-container {
            position: relative;
            z-index: 10;
            width: 100%;
            /* Dikecilkan untuk Windows/Desktop agar lebih proporsional */
            max-width: 380px; 
            animation: containerEntrance 1s var(--transit);
        }

        @keyframes containerEntrance {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .error-card {
            background: rgba(15, 10, 11, 0.8);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            padding: 45px 35px;
            border-radius: 32px;
            border: 1px solid rgba(245, 222, 179, 0.12);
            text-align: center;
            box-shadow: 0 25px 50px rgba(0,0,0,0.5);
        }

        /* Branding Header */
        .brand-mark {
            font-family: 'Playfair Display', serif;
            font-size: 9px;
            letter-spacing: 5px;
            text-transform: uppercase;
            margin-bottom: 30px;
            opacity: 0.5;
            color: var(--gold);
        }

        /* Icon Circle */
        .icon-wrap {
            width: 70px;
            height: 70px;
            margin: 0 auto 25px;
            border: 1px solid var(--gold-low);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(245, 222, 179, 0.03);
            position: relative;
        }

        .icon-wrap i {
            font-size: 32px;
            color: var(--gold);
            opacity: 0.8;
            animation: softPulse 3s infinite ease-in-out;
        }

        @keyframes softPulse {
            0%, 100% { transform: scale(1); opacity: 0.6; }
            50% { transform: scale(1.05); opacity: 0.9; }
        }

        /* Typography */
        h1 {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem; /* Ukuran lebih pas untuk desktop & mobile */
            color: var(--white);
            margin-bottom: 12px;
            font-weight: 700;
            font-style: italic;
            line-height: 1.2;
        }

        p {
            font-size: 12.5px;
            line-height: 1.6;
            color: var(--gold-muted);
            margin-bottom: 35px;
            font-weight: 300;
            padding: 0 5px;
        }

        /* Luxury Button */
        .btn-request {
            display: block;
            width: 100%;
            padding: 16px;
            background: var(--gold);
            color: var(--onyx);
            text-decoration: none;
            border-radius: 14px;
            font-size: 10.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: all 0.3s var(--transit);
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        }

        .btn-request:hover {
            background: var(--white);
            transform: translateY(-3px);
            box-shadow: 0 12px 20px rgba(0,0,0,0.3);
        }

        .btn-request:active {
            transform: translateY(-1px) scale(0.98);
        }

        /* Footer inside Card */
        .footer-branding {
            margin-top: 35px;
            font-size: 8px;
            letter-spacing: 3px;
            text-transform: uppercase;
            opacity: 0.3;
            border-top: 1px solid rgba(245, 222, 179, 0.08);
            padding-top: 20px;
        }

        /* External Footer */
        .external-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 8px;
            opacity: 0.2;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        /* ================= MOBILE ADAPTATION ================= */
        @media (max-width: 480px) {
            .error-container {
                max-width: 100%;
            }
            .error-card {
                padding: 40px 25px;
                border-radius: 28px;
            }
            h1 { font-size: 1.6rem; }
            p { font-size: 12px; }
        }
    </style>
</head>
<body>

    <div class="error-container">
        <div class="error-card">
            <div class="brand-mark">The Roastery</div>
            
            <div class="icon-wrap">
                <i class='bx bx-time-five'></i>
            </div>

            <h1>Access Expired.</h1>
            
            <p>Otorisasi ini telah kedaluwarsa demi menjaga keamanan akses Anda. Silakan minta tautan baru untuk melanjutkan.</p>
            
            <a href="<?= base_url('auth/login') ?>" class="btn-request">
                Get New Access
            </a>
            
            <div class="footer-branding">
                Private selection &bull; 2025
            </div>
        </div>

        <div class="external-footer">
            Secure Authentication Protocol
        </div>
    </div>

</body>
</html>
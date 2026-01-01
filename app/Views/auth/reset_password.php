<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Authorize New Access | Coffee Time</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    
    <!-- Fonts & Icons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --onyx: #070404;
            --gold: #f5deb3;
            --gold-muted: rgba(245, 222, 179, 0.5);
            --gold-low: rgba(245, 222, 179, 0.1);
            --white: #ffffff;
            --transit: cubic-bezier(0.23, 1, 0.32, 1);
        }

        /* ================= BASE STYLES ================= */
        * { margin: 0; padding: 0; box-sizing: border-box; -webkit-tap-highlight-color: transparent; }
        
        html, body {
            height: 100%;
            width: 100%;
        }

        body {
            background: var(--onyx);
            color: var(--gold);
            font-family: 'Poppins', sans-serif;
            
            /* CENTERING CORE */
            display: flex;
            flex-direction: column;
            justify-content: center; /* Pusatkan Vertikal */
            align-items: center;     /* Pusatkan Horizontal */
            
            /* Fix untuk Mobile Browser Address Bar */
            min-height: 100vh; 
            min-height: 100svh; 
            
            background-image: linear-gradient(rgba(7,4,4,0.88), rgba(7,4,4,0.88)), 
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
            opacity: 0.15; pointer-events: none; z-index: 1;
        }

        .auth-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 400px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            animation: fadeIn 1s var(--transit);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .auth-card {
            background: rgba(18, 11, 12, 0.75);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            padding: 40px 30px;
            border-radius: 35px;
            border: 1px solid rgba(245, 222, 179, 0.12);
            text-align: center;
            box-shadow: 0 30px 60px rgba(0,0,0,0.6);
            width: 100%;
        }

        .logo-box {
            font-family: 'Playfair Display', serif;
            font-size: 10px;
            letter-spacing: 6px;
            text-transform: uppercase;
            margin-bottom: 20px;
            color: var(--gold);
            opacity: 0.7;
            text-align: center;
        }

        h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: var(--white);
            margin-bottom: 12px;
            font-weight: 900;
            font-style: italic;
        }

        .subtitle {
            font-size: 13px;
            color: var(--gold-muted);
            line-height: 1.5;
            margin-bottom: 30px;
            font-weight: 300;
        }

        /* ================= INPUT STYLING ================= */
        .input-group {
            position: relative;
            margin-bottom: 15px;
            text-align: left;
        }

        .input-group label {
            display: block;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 8px;
            margin-left: 4px;
            color: var(--gold-muted);
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper input {
            width: 100%;
            padding: 16px 45px 16px 48px;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(245, 222, 179, 0.1);
            border-radius: 16px;
            color: var(--white);
            font-size: 16px; /* 16px cegah auto-zoom di iPhone */
            outline: none;
            transition: 0.3s;
        }

        .input-wrapper .main-icon {
            position: absolute;
            left: 18px;
            color: var(--gold);
            opacity: 0.4;
            font-size: 18px;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            padding: 10px;
            cursor: pointer;
            color: var(--gold-muted);
            font-size: 18px;
        }

        .input-wrapper input:focus {
            border-color: var(--gold);
            background: rgba(245, 222, 179, 0.05);
        }

        /* ================= BUTTON STYLING ================= */
        .btn-update {
            width: 100%;
            padding: 18px;
            margin-top: 10px;
            background: var(--gold);
            color: var(--onyx);
            border: none;
            border-radius: 16px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-update:active {
            transform: scale(0.96);
            background: var(--white);
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 25px;
            font-size: 11px;
            text-decoration: none;
            color: var(--gold-muted);
            transition: 0.3s;
        }

        /* ================= FOOTER ================= */
        .footer-text {
            text-align: center;
            margin-top: 25px;
            font-size: 9px;
            opacity: 0.4;
            letter-spacing: 3px;
        }

        /* ================= MOBILE ADAPTATION ================= */
        @media (max-width: 480px) {
            .auth-card {
                padding: 35px 25px;
            }
            h1 { font-size: 1.8rem; }
        }
    </style>
</head>
<body>

    <div class="auth-container">
        <div class="logo-box">The Roastery</div>
        
        <div class="auth-card">
            <h1>New Access.</h1>
            <p class="subtitle">Tentukan identitas keamanan baru untuk akses kurasi kopi Anda.</p>
            
            <form action="<?= base_url('auth/process_reset') ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="token" value="<?= $token ?>">
                
                <div class="input-group">
                    <label>New Password</label>
                    <div class="input-wrapper">
                        <i class='bx bxs-lock-alt main-icon'></i>
                        <input type="password" name="password" id="pass" placeholder="••••••••" required>
                        <i class='bx bx-hide toggle-password' onclick="togglePass('pass', this)"></i>
                    </div>
                </div>

                <div class="input-group">
                    <label>Confirm Access</label>
                    <div class="input-wrapper">
                        <i class='bx bxs-shield-alt-2 main-icon'></i>
                        <input type="password" name="confirm_password" id="confirm" placeholder="••••••••" required>
                        <i class='bx bx-hide toggle-password' onclick="togglePass('confirm', this)"></i>
                    </div>
                </div>

                <button type="submit" class="btn-update">
                    Update Credentials
                </button>
            </form>

            <a href="<?= base_url('auth/login') ?>" class="back-link">
                <i class='bx bx-left-arrow-alt'></i> Back to Sign In
            </a>
        </div>

        <div class="footer-text">
            EST. 2025 PRIVATE SELECTION
        </div>
    </div>

    <script>
        function togglePass(inputId, icon) {
            const input = document.getElementById(inputId);
            if (input.type === "password") {
                input.type = "text";
                icon.classList.replace('bx-hide', 'bx-show');
            } else {
                input.type = "password";
                icon.classList.replace('bx-show', 'bx-hide');
            }
        }
    </script>
</body>
</html>
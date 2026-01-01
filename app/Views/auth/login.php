<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Private Access | Coffee Time</title>

    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Poppins:wght@300;400;500;600;700&display=swap');

        :root {
            --onyx: #070404;
            --dark-gray: #120b0c;
            --gold: #f5deb3;
            --gold-low: rgba(245, 222, 179, 0.1);
            --white: #ffffff;
            --transit: cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: var(--onyx);
            /* Tekstur Linen Premium */
            background-image: linear-gradient(rgba(7, 4, 4, 0.7), rgba(7, 4, 4, 0.7)), 
                              url('https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            overflow: hidden;
        }

        /* Overlay Tekstur */
        body::after {
            content: ""; position: fixed; inset: 0;
            background-image: url("https://www.transparenttextures.com/patterns/black-linen.png");
            opacity: 0.2; pointer-events: none;
        }

        .container {
            position: relative;
            width: 850px;
            height: 550px;
            background: var(--dark-gray);
            border-radius: 40px;
            box-shadow: 0 40px 100px rgba(0, 0, 0, 0.8);
            overflow: hidden;
            border: 1px solid var(--gold-low);
            z-index: 10;
        }

        /* ================= FORM ================= */
        .form-box {
            position: absolute;
            right: 0;
            width: 50%;
            height: 100%;
            background: var(--dark-gray);
            display: flex;
            align-items: center;
            color: var(--white);
            text-align: center;
            padding: 40px;
            z-index: 1;
            transition: right .6s var(--transit), bottom .6s var(--transit);
        }

        .container.active .form-box {
            right: 50%;
        }

        .form-box.register {
            opacity: 0;
            pointer-events: none;
        }

        .container.active .form-box.register {
            opacity: 1;
            pointer-events: auto;
        }

        .container.active .form-box.login {
            opacity: 0;
            pointer-events: none;
        }

        form {
            width: 100%;
        }

        .container h1 {
            font-family: 'Playfair Display', serif;
            font-size: 42px;
            margin-bottom: 10px;
            color: var(--white);
            font-weight: 900;
        }

        .container p.subtitle {
            font-size: 13px;
            color: var(--gold);
            opacity: 0.6;
            margin-bottom: 20px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* ================= INPUT ================= */
        .input-box {
            position: relative;
            margin: 20px 0;
        }

        .input-box input {
            width: 100%;
            padding: 15px 50px 15px 20px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 12px;
            border: 1px solid var(--gold-low);
            outline: none;
            font-size: 15px;
            color: var(--white);
            transition: 0.3s;
        }

        .input-box input:focus {
            border-color: var(--gold);
            background: rgba(255, 255, 255, 0.07);
        }

        .input-box input::placeholder {
            color: rgba(255, 255, 255, 0.2);
        }

        .input-box i {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 20px;
            color: var(--gold);
            opacity: 0.5;
        }

        .forgot-link {
            text-align: right;
            margin: -10px 0 20px;
        }

        .forgot-link a {
            font-size: 13px;
            color: var(--gold);
            text-decoration: none;
            opacity: 0.7;
            transition: 0.3s;
        }

        .forgot-link a:hover {
            opacity: 1;
        }

        /* ================= BUTTON ================= */
        .btn {
            width: 100%;
            height: 55px;
            background: var(--gold);
            border-radius: 12px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            color: var(--onyx);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: 0.4s;
            box-shadow: 0 10px 20px rgba(0,0,0,0.3);
        }

        .btn:hover {
            background: var(--white);
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.4);
        }

        /* ================= TOGGLE ================= */
        .toggle-box {
            position: absolute;
            width: 100%;
            height: 100%;
        }

        .toggle-box::before {
            content: '';
            position: absolute;
            left: -250%;
            width: 300%;
            height: 100%;
            background: linear-gradient(135deg, #1b1113, var(--onyx));
            border-radius: 150px;
            z-index: 2;
            transition: 1.8s var(--transit);
            border-left: 1px solid var(--gold-low);
        }

        .container.active .toggle-box::before {
            left: 50%;
        }

        /* ================= TOGGLE PANEL ================= */
        .toggle-panel {
            position: absolute;
            width: 50%;
            height: 100%;
            color: var(--gold);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 3;
            text-align: center;
            padding: 0 50px;
            transition: opacity .6s var(--transit);
        }

        .container.active .toggle-panel.toggle-left {
            opacity: 0;
            pointer-events: none;
        }

        .container:not(.active) .toggle-panel.toggle-right {
            opacity: 0;
            pointer-events: none;
        }

        .toggle-panel.toggle-left { left: 0; }
        .toggle-panel.toggle-right { right: 0; }

        .toggle-panel h1 {
            font-family: 'Playfair Display', serif;
            font-size: 48px;
            color: var(--gold);
        }

        .toggle-panel p {
            margin: 15px 0 25px;
            opacity: 0.7;
            font-weight: 300;
            line-height: 1.6;
        }

        .toggle-panel .btn {
            width: 180px;
            height: 50px;
            background: transparent;
            border: 2px solid var(--gold);
            box-shadow: none;
            color: var(--gold);
        }

        .toggle-panel .btn:hover {
            background: var(--gold);
            color: var(--onyx);
        }

        /* Custom Style untuk SweetAlert Input */
        .custom-swal-input {
            border: 1px solid rgba(245, 222, 179, 0.2) !important;
            border-radius: 12px !important;
            background: rgba(255, 255, 255, 0.03) !important;
            color: #ffffff !important;
            font-family: 'Poppins', sans-serif !important;
        }

        .custom-swal-input:focus {
            border-color: #f5deb3 !important;
            box-shadow: 0 0 10px rgba(245, 222, 179, 0.1) !important;
        }

        .playfair-font {
            font-family: 'Playfair Display', serif !important;
            font-weight: 700 !important;
        }

        .back-home {
            position: fixed;
            top: 30px;
            left: 30px;
            color: var(--gold);
            text-decoration: none;
            font-size: 12px;
            letter-spacing: 2px;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 100;
            opacity: 0.6;
            transition: 0.3;
        }
        .back-home:hover { opacity: 1; transform: translateX(-5px); }

        /* ================= MOBILE VIEW ================= */
        @media screen and (max-width: 650px) {
            .container {
                width: 95%;
                height: 650px; /* Sedikit lebih tinggi untuk menampung form */
                display: flex;
                flex-direction: column;
            }

            .form-box {
                position: absolute;
                bottom: 0;
                right: 0;
                width: 100%;
                height: 75%; /* Area form lebih besar */
                padding: 30px;
                transition: transform 0.6s var(--transit);
            }

            /* Logika pergerakan form di mobile (Vertikal) */
            .container.active .form-box {
                right: 0;
                transform: translateY(-33.3%); /* Geser ke atas saat active */
            }

            .container h1 {
                font-size: 28px;
            }

            /* Overlay Emas (Background bergerak) di Mobile */
            .toggle-box::before {
                left: 0;
                top: -270%; /* Mulai dari atas jauh */
                width: 100%;
                height: 300%;
                border-radius: 20vw;
                transition: 1.2s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .container.active .toggle-box::before {
                left: 0;
                top: 75%; /* Geser ke bawah saat active */
            }

            /* Panel Teks (Hello/Welcome) di Mobile */
            .toggle-panel {
                width: 100%;
                height: 25%;
                padding: 15px;
            }

            .toggle-panel.toggle-left {
                top: 0;
            }

            .container.active .toggle-panel.toggle-left {
                transform: translateY(-100%);
                opacity: 0;
            }

            .toggle-panel.toggle-right {
                right: 0;
                bottom: -25%; /* Sembunyikan di bawah dulu */
            }

            .container.active .toggle-panel.toggle-right {
                bottom: 0;
                opacity: 1;
                transform: translateY(0);
            }

            .toggle-panel h1 {
                font-size: 24px;
                margin-bottom: 5px;
            }

            .toggle-panel p {
                display: block; /* Tampilkan p tapi singkat saja */
                font-size: 12px;
                margin: 5px 0 15px;
                padding: 0 20px;
            }

            .toggle-panel .btn {
                width: 140px;
                height: 40px;
                font-size: 12px;
            }
            
            /* Sembunyikan subtitle di mobile agar tidak sesak */
            .container p.subtitle {
                font-size: 11px;
                margin-bottom: 10px;
            }
            
            .input-box {
                margin: 15px 0;
            }
        }
    </style>
</head>

<body>
    <a href="<?= base_url('/') ?>" class="back-home">
        <i class='bx bx-left-arrow-alt'></i> Back to Estate
    </a>
    <div class="container">
        
        <!-- Form Login -->
        <div class="form-box login">
            <form action="<?= base_url('auth/process_login') ?>" method="post"> 
                <?= csrf_field() ?>
                <p class="subtitle">Welcome Back</p>
                <h1>Sign In</h1>

                <div class="input-box">
                    <input type="text" name="username" placeholder="Username" required>
                    <i class='bx bxs-user-circle'></i>
                </div>

                <div class="input-box">
                    <input type="password" name="password" placeholder="Password" required>
                    <i class='bx bxs-key'></i>
                </div>

                <div class="forgot-link">
                    <!-- Menggunakan javascript:void(0) agar tidak reload halaman -->
                    <a href="javascript:void(0)" onclick="handleForgotPassword()">Recover Access?</a>
                </div>

                <button type="submit" class="btn">Authorize</button>
            </form>
        </div>

        <!-- Form Register -->
        <div class="form-box register">
            <form action="<?= base_url('auth/process_register') ?>" method="post">
                <?= csrf_field() ?>
                <p class="subtitle">Join The Circle</p>
                <h1>Register</h1>

                <div class="input-box">
                    <input type="text" name="username" placeholder="Username" required>
                    <i class='bx bxs-user'></i>
                </div>

                <div class="input-box">
                    <input type="email" name="email" placeholder="Email Address" required>
                    <i class='bx bxs-envelope'></i>
                </div>

                <div class="input-box">
                    <input type="password" name="password" placeholder="Password" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>

                <!-- TAMBAHKAN BOX INI -->
                <div class="input-box">
                    <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                    <i class='bx bxs-check-shield'></i>
                </div>

                <button type="submit" class="btn">Create Account</button>
            </form>
        </div>

        <!-- Toggle Panel (Samping) -->
        <div class="toggle-box">
            <div class="toggle-panel toggle-left">
                <h1>Hello!</h1>
                <p>Belum memiliki akun? Mari bergabung dengan komunitas pecinta kopi kami dan nikmati penawaran eksklusif.</p>
                <button class="btn register-btn">Join Us</button>
            </div>

            <div class="toggle-panel toggle-right">
                <h1>Welcome!</h1>
                <p>Sudah memiliki akun? Silakan masuk kembali untuk melanjutkan perjalanan rasa Anda.</p>
                <button class="btn login-btn">Sign In</button>
            </div>
        </div>
    </div>

    <script>
        const container = document.querySelector('.container');
        const registerBtn = document.querySelector('.register-btn');
        const loginBtn = document.querySelector('.login-btn');

        registerBtn.addEventListener('click', () => {
            container.classList.add('active');
        });

        loginBtn.addEventListener('click', () => {
            container.classList.remove('active');
        });

        // SweetAlert Luxury Theme
        const swalConfig = {
            background: '#120b0c',
            color: '#f5deb3',
            confirmButtonColor: '#f5deb3',
        };

        <?php if(session()->getFlashdata('error')): ?>
            Swal.fire({
                ...swalConfig,
                icon: 'error',
                title: 'Access Denied',
                text: '<?= session()->getFlashdata('error') ?>',
            });
        <?php endif; ?>

        <?php if(session()->getFlashdata('success')): ?>
            Swal.fire({
                ...swalConfig,
                icon: 'success',
                title: 'Success',
                text: '<?= session()->getFlashdata('success') ?>',
            });
        <?php endif; ?>

        async function handleForgotPassword() {
            const { value: email } = await Swal.fire({
                title: 'Account Recovery',
                text: 'Masukkan alamat email terdaftar Anda untuk menerima instruksi pemulihan akses.',
                input: 'email',
                inputPlaceholder: 'nama@email.com',
                background: '#120b0c',
                color: '#f5deb3',
                confirmButtonColor: '#f5deb3',
                confirmButtonText: '<span style="color:#070404; font-weight:700">Send Reset Link</span>',
                showCancelButton: true,
                cancelButtonColor: 'transparent',
                customClass: {
                    input: 'custom-swal-input',
                    title: 'playfair-font'
                }
            });

            if (email) {
                Swal.fire({
                    title: 'Encrypting...',
                    text: 'Permintaan sedang dikirim ke pusat data.',
                    allowOutsideClick: false,
                    background: '#120b0c',
                    color: '#f5deb3',
                    didOpen: () => { Swal.showLoading(); }
                });

                try {
                    // --- BAGIAN YANG DIGANTI / DITAMBAHKAN DISINI ---
                    const response = await fetch('<?= base_url("auth/forgot_password") ?>', {
                        method: 'POST',
                        headers: { 
                            'Content-Type': 'application/x-www-form-urlencoded',
                            'X-Requested-With': 'XMLHttpRequest', // Memberitahu CI4 ini adalah AJAX
                            'X-CSRF-TOKEN': '<?= csrf_hash() ?>'   // TOKEN KEAMANAN CI4
                        },
                        body: `email=${encodeURIComponent(email)}`
                    });
                    // --- END OF REPLACEMENT ---

                    const result = await response.json();

                    if (result.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Link Dispatched',
                            text: result.message,
                            background: '#120b0c',
                            color: '#f5deb3',
                            confirmButtonColor: '#f5deb3',
                            confirmButtonText: '<span style="color:#070404">Understood</span>'
                        });
                    } else {
                        throw new Error(result.message);
                    }
                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Recovery Failed',
                        text: error.message || 'Terjadi kesalahan koneksi.',
                        background: '#120b0c',
                        color: '#f5deb3',
                        confirmButtonColor: '#f5deb3'
                    });
                }
            }
        }
    </script>
</body>
</html>
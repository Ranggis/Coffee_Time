<!-- Sovereign Apex Toast Engine (Elite Dynamic Edition) -->
<style>
    :root {
        --toast-gold: #f5deb3;
        --toast-red: #ff4757;
        --toast-bg: rgba(10, 7, 8, 0.98);
    }

    /* 1. Base Desktop Styling */
    .sovereign-apex-toast {
        background: var(--toast-bg) !important;
        backdrop-filter: blur(25px) saturate(160%) !important;
        -webkit-backdrop-filter: blur(25px) saturate(160%) !important;
        border-radius: 20px !important;
        padding: 12px 25px !important;
        box-shadow: 0 30px 60px rgba(0,0,0,0.8), 
                    inset 0 0 0 1px rgba(245, 222, 179, 0.1) !important;
        width: 380px !important;
        border: none !important;
    }

    /* 2. ULTRA-ELITE MOBILE REFINEMENT (Dynamic Pill Style) */
    @media (max-width: 600px) {
        .sovereign-apex-toast {
            width: fit-content !important;
            min-width: 180px !important;
            max-width: 90vw !important;
            height: 42px !important; /* Tinggi tetap agar ramping */
            padding: 0 18px !important;
            margin: 0 auto !important;
            border-radius: 100px !important; /* Kapsul Sempurna */
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            top: 80px !important; /* Jarak pas dari atas layar */
            box-shadow: 0 15px 30px rgba(0,0,0,0.6) !important;
        }

        /* Merapikan Icon di Mobile */
        .swal2-icon {
            transform: scale(0.35) !important;
            margin: 0 0 0 -12px !important; /* Tarik ke kiri agar compact */
            border: none !important;
        }

        /* Merapikan Container Teks agar Sejajar */
        .swal2-html-container {
            margin: 0 !important;
            padding: 0 !important;
            display: flex !important;
            align-items: center !important;
        }

        .sovereign-toast-title {
            font-size: 11px !important;
            font-weight: 800 !important;
            letter-spacing: 0.5px !important;
            white-space: nowrap !important;
            margin-right: 8px !important;
        }

        .sovereign-toast-desc {
            font-size: 9px !important;
            font-weight: 400 !important;
            letter-spacing: 0.3px !important;
            opacity: 0.6 !important;
            display: inline-block !important;
            border-left: 1px solid rgba(255,255,255,0.1);
            padding-left: 8px !important;
        }

        /* Hilangkan Progress Bar di mobile untuk tampilan minimalis */
        .swal2-timer-progress-bar {
            display: none !important;
        }
    }

    /* 3. Luxury Accent Glow */
    .sovereign-apex-toast::after {
        content: "";
        position: absolute;
        left: 15%; right: 15%; bottom: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, var(--accent-color, var(--toast-gold)), transparent);
        opacity: 0.5;
    }

    .toast-error-style { --accent-color: var(--toast-red); }
    .toast-success-style { --accent-color: var(--toast-gold); }

    /* 4. Typography Elite */
    .sovereign-toast-title {
        font-family: 'Playfair Display', serif !important;
        font-style: italic !important;
        color: #fff !important;
        font-size: 14px !important;
    }

    .sovereign-toast-desc {
        font-family: 'Poppins', sans-serif !important;
        color: rgba(255, 255, 255, 0.5) !important;
        text-transform: uppercase !important;
    }
</style>

<script>
    const SovereignApex = Swal.mixin({
        toast: true,
        position: window.innerWidth > 600 ? 'top-end' : 'top',
        showConfirmButton: false,
        timer: 3000,
        background: 'transparent',
    });

    <?php if (session()->getFlashdata('success')) : ?>
    SovereignApex.fire({
        icon: 'success',
        iconColor: '#f5deb3',
        title: 'PROTOCOL OK',
        html: '<span class="sovereign-toast-desc"><?= esc(session()->getFlashdata('success')) ?></span>',
        customClass: {
            popup: 'sovereign-apex-toast toast-success-style',
            title: 'sovereign-toast-title'
        },
        showClass: { 
            popup: 'animate__animated animate__fadeInDown animate__faster' 
        },
        hideClass: { 
            popup: 'animate__animated animate__fadeOutUp animate__faster' 
        }
    });
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
    SovereignApex.fire({
        icon: 'error',
        iconColor: '#ff4757',
        title: 'SYSTEM FAIL',
        html: '<span class="sovereign-toast-desc"><?= esc(session()->getFlashdata('error')) ?></span>',
        customClass: {
            popup: 'sovereign-apex-toast toast-error-style',
            title: 'sovereign-toast-title'
        },
        showClass: { 
            popup: 'animate__animated animate__shakeX animate__faster' 
        },
        hideClass: { 
            popup: 'animate__animated animate__fadeOutUp animate__faster' 
        }
    });
    <?php endif; ?>
</script>
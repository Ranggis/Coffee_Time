<?= $this->extend('layout/user_layout') ?>

<?= $this->section('content') ?>
<style>
    :root { 
        --gold: #f5deb3; 
        --gold-dim: rgba(245, 222, 179, 0.4);
        --onyx: #050505; 
        --carbon: #0d0d0d; 
        --border: rgba(255, 255, 255, 0.05);
        --amethyst: #6c5ce7;
    }
    
    /* FIX UTAMA: Jarak masif dari Navbar agar tidak ketutup */
    .history-container { 
        max-width: 1200px; 
        margin: 0 auto; 
        padding: 50px 25px 100px; /* Ditambah ke 180px agar benar-benar di bawah navbar */
    }
    
    /* HEADER SECTION - CENTERED & ELITE */
    .page-header { 
        margin-bottom: 80px; 
        text-align: center; 
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
    }

    /* Badge Kecil di Atas Judul */
    .protocol-label {
        font-size: 9px;
        text-transform: uppercase;
        letter-spacing: 6px;
        color: var(--gold);
        border: 1px solid var(--gold-dim);
        padding: 6px 20px;
        border-radius: 50px;
        margin-bottom: 25px;
        background: rgba(245, 222, 179, 0.03);
        font-weight: 700;
        margin-right: -6px; /* Offset letter spacing */
    }

    .page-title { 
        font-family: 'Playfair Display', serif; 
        font-style: italic; 
        font-size: clamp(2.5rem, 7vw, 4.5rem); 
        color: #fff; 
        line-height: 1; 
        margin: 0;
        text-shadow: 0 10px 30px rgba(0,0,0,0.5);
    }

    .page-title span {
        display: block;
        font-size: 11px;
        font-family: 'Poppins', sans-serif;
        text-transform: uppercase;
        letter-spacing: 12px;
        color: var(--gold);
        opacity: 0.5;
        margin-top: 15px;
        font-style: normal;
        margin-right: -12px;
    }

    /* GRID ARCHITECTURE */
    .odyssey-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 30px;
    }

    /* PREMIUM CARD STYLE */
    .order-card { 
        background: linear-gradient(145deg, #0e0e0e, #070707);
        border: 1px solid var(--border); 
        border-radius: 24px; 
        padding: 35px; 
        display: flex;
        flex-direction: column;
        transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1); 
        box-shadow: 0 20px 40px rgba(0,0,0,0.4);
    }
    
    .order-card:hover { 
        transform: translateY(-12px); 
        border-color: var(--gold-dim); 
        box-shadow: 0 40px 80px rgba(0,0,0,0.7); 
    }

    .card-top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 25px; }
    .id-tag { font-family: monospace; color: var(--gold); font-size: 11px; letter-spacing: 1px; opacity: 0.7; }
    .date-tag { font-size: 10px; color: #555; text-transform: uppercase; letter-spacing: 1px; margin-top: 5px; display: block; }

    /* STATUS PILLS */
    .status-pill { 
        padding: 6px 14px; border-radius: 50px; font-size: 8px; font-weight: 900; 
        text-transform: uppercase; letter-spacing: 1.5px; border: 1px solid transparent;
    }
    .st-pending { color: #f39c12; background: rgba(243, 156, 18, 0.1); }
    .st-processing { color: #3498db; background: rgba(52, 152, 219, 0.1); }
    .st-out-for-delivery { 
        color: #fff; background: var(--amethyst); 
        box-shadow: 0 0 20px rgba(108, 92, 231, 0.4);
        animation: mini-glow 2s infinite;
    }
    .st-completed { color: #2ecc71; background: rgba(46, 204, 113, 0.1); }
    .st-cancelled { color: #e74c3c; background: rgba(231, 76, 60, 0.1); }

    @keyframes mini-glow { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.02); opacity: 0.9; } }

    /* DATA SPEC */
    .data-summary { margin-bottom: 25px; flex-grow: 1; }
    .data-row { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid rgba(255,255,255,0.03); font-size: 12px; }
    .data-row span { color: #555; text-transform: uppercase; font-size: 9px; letter-spacing: 1px; font-weight: 700; }
    .data-row b { color: #ccc; font-weight: 500; font-size: 13px; }

    /* PRICING BLOCK */
    .price-wrap { margin-top: auto; border-top: 1px solid var(--border); padding-top: 25px; display: flex; justify-content: space-between; align-items: center; }
    .val-amount { font-family: 'Playfair Display', serif; font-size: 1.8rem; color: #fff; font-weight: 700; }
    .val-amount small { font-size: 11px; color: var(--gold); margin-right: 6px; font-family: 'Poppins'; opacity: 0.6; font-weight: 400; }

    /* BUTTONS */
    .btn-grid-action {
        width: 100%; background: var(--gold); color: #000; border: none; padding: 16px; 
        border-radius: 16px; font-weight: 900; text-transform: uppercase; 
        letter-spacing: 2px; font-size: 10px; margin-top: 20px; cursor: pointer;
        transition: 0.3s; box-shadow: 0 10px 20px rgba(245, 222, 179, 0.2);
    }
    .btn-grid-action:hover { background: #fff; transform: translateY(-3px); }
    
    .btn-cancel-order {
        width: 100%; background: transparent; color: #e74c3c; border: 1px solid rgba(231, 76, 60, 0.2); 
        padding: 14px; border-radius: 16px; font-weight: 800; text-transform: uppercase; 
        letter-spacing: 2px; font-size: 10px; margin-top: 20px; cursor: pointer; transition: 0.3s;
    }
    .btn-cancel-order:hover { background: rgba(231, 76, 60, 0.05); border-color: #e74c3c; }

    /* MOBILE ADAPTATION */
    @media (max-width: 768px) {
        .history-container { padding: 50px 20px 80px; }
        .odyssey-grid { grid-template-columns: 1fr; gap: 20px; }
        .page-title { font-size: 2.5rem; }
    }
</style>

<div class="history-container">
    <!-- PAGE HEADER - CENTERED & REFINED -->
    <header class="page-header" id="odysseyHeader">
        <span style="font-size: 10px; text-transform: uppercase; letter-spacing: 6px; color: var(--gold); opacity: 0.5;">Coffee Time</span>
        <h1 style="font-family: 'Playfair Display', serif; font-style: italic; color: #fff; font-size: clamp(2.5rem, 5vw, 3.5rem); line-height: 1.2;">My Coffee Odyssey</h1>
    </header>

    <?php if(!empty($orders)): ?>
        <div class="odyssey-grid">
            <?php $delay = 0; foreach($orders as $o): ?>
                <article class="order-card odyssey-card">               
                    <div class="card-top">
                        <div>
                            <span class="id-tag">TRANS-ID #<?= $o['order_code'] ?></span>
                            <span class="date-tag"><?= date('d M Y • H:i', strtotime($o['created_at'])) ?></span>
                        </div>
                        <span class="status-pill st-<?= $o['status'] ?>">
                            <?= str_replace('-', ' ', $o['status']) ?>
                        </span>
                    </div>

                    <div class="data-summary">
                        <div class="data-row">
                            <span>Service Protocol</span>
                            <b><?= ucfirst($o['service_type']) ?></b>
                        </div>
                        <div class="data-row">
                            <span>Point Location</span>
                            <b style="max-width: 150px; text-align: right; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="<?= esc($o['location']) ?>"><?= esc($o['location']) ?></b>
                        </div>
                        <div class="data-row" style="border:none">
                            <span>Settlement Method</span>
                            <b><?= strtoupper($o['payment_method']) ?></b>
                        </div>
                    </div>

                    <div class="price-wrap">
                        <div class="val-amount">
                            <small>IDR</small><?= number_format($o['total_amount'], 0, ',', '.') ?>
                        </div>
                        <i class="fas <?= $o['service_type'] == 'delivery' ? 'fa-truck-fast' : 'fa-chair' ?>" style="opacity: 0.15; font-size: 1.5rem; color: var(--gold);"></i>
                    </div>

                    <?php if($o['status'] === 'out-for-delivery'): ?>
                        <button class="btn-grid-action" onclick="confirmDispatch('<?= $o['id'] ?>', '<?= $o['order_code'] ?>')">
                            <i class="fas fa-check-circle" style="margin-right: 8px;"></i> Acknowledge Arrival
                        </button>
                    <?php elseif($o['status'] === 'pending'): ?>
                        <button class="btn-cancel-order" onclick="cancelOrder('<?= $o['id'] ?>', '<?= $o['order_code'] ?>')">
                            <i class="fas fa-times-circle" style="margin-right: 8px;"></i> Cancel Transmission
                        </button>
                    <?php endif; ?>

                </article>
            <?php $delay += 0.08; endforeach; ?>
        </div>
    <?php else: ?>
        <div style="text-align:center; padding: 120px 0; opacity: 0.2;" class="animate__animated animate__fadeIn">
            <i class="fas fa-compass-slash" style="font-size: 5rem; margin-bottom: 25px; color: var(--gold);"></i>
            <p style="letter-spacing: 4px; text-transform: uppercase; font-size: 13px; font-weight: 700;">No Odyssey Logged Yet</p>
            <a href="<?= base_url('menu') ?>" style="display:inline-block; margin-top: 30px; color: var(--gold); border-bottom: 1px solid var(--gold); padding-bottom: 5px; font-size: 11px; text-transform: uppercase; letter-spacing: 2px;">Begin Your Journey</a>
        </div>
    <?php endif; ?>
</div>

<script>
    function confirmDispatch(id, code) {
        Swal.fire({
            title: `<span style="font-family:'Playfair Display'; font-style:italic; font-weight:700;">Acknowledge Receipt?</span>`,
            html: `<p style="font-family:'Poppins'; font-size:13px; color:#999; line-height:1.6;">Confirm the arrival of transmission <b style="color:var(--gold);">#${code}</b> at your identified location?</p>`,
            icon: 'question',
            background: '#0a0a0a',
            color: '#fff',
            showCancelButton: true,
            confirmButtonColor: '#f5deb3',
            cancelButtonColor: '#1a1a1a',
            confirmButtonText: '<span style="color:#000; font-weight:900; font-size:10px; letter-spacing:1px;">CONFIRM ARRIVAL</span>',
            cancelButtonText: 'ABORT',
            backdrop: `rgba(0,0,0,0.9)`
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?= base_url('user/confirm_received/') ?>/" + id;
            }
        })
    }

    function cancelOrder(id, code) {
        Swal.fire({
            title: `<span style="font-family:'Playfair Display'; font-style:italic; font-weight:700;">Abort Order?</span>`,
            html: `<p style="font-family:'Poppins'; font-size:13px; color:#999; line-height:1.6;">Are you sure you want to terminate transmission <b style="color:#e74c3c;">#${code}</b>? This action cannot be undone.</p>`,
            icon: 'warning',
            background: '#0a0a0a',
            color: '#fff',
            showCancelButton: true,
            confirmButtonColor: '#e74c3c',
            cancelButtonColor: '#1a1a1a',
            confirmButtonText: '<span style="color:#fff; font-weight:900; font-size:10px; letter-spacing:1px;">YES, ABORT</span>',
            cancelButtonText: 'KEEP ORDER',
            backdrop: `rgba(0,0,0,0.9)`
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?= base_url('user/cancel_order/') ?>/" + id;
            }
        })
    }
    document.addEventListener('DOMContentLoaded', () => {

        const PAGE_KEY = 'odysseyPageAnimated';

        const header = document.getElementById('odysseyHeader');
        const cards  = document.querySelectorAll('.odyssey-card');

        const hasAnimated = sessionStorage.getItem(PAGE_KEY);

        if (!hasAnimated) {
            // Header animation
            if (header) {
                header.classList.add(
                    'animate__animated',
                    'animate__fadeInDown'
                );
            }

            // Card stagger animation
            cards.forEach((card, index) => {
                card.classList.add(
                    'animate__animated',
                    'animate__fadeInUp'
                );
                card.style.animationDelay = `${index * 0.08}s`;
            });

            // Simpan state (page sudah animasi)
            sessionStorage.setItem(PAGE_KEY, 'true');

        } else {
            // Matikan animasi, tapi pastikan tampil
            if (header) header.style.opacity = 1;
            cards.forEach(card => {
                card.style.opacity = 1;
                card.style.transform = 'none';
            });
        }
    });
</script>
<?= $this->endSection() ?>
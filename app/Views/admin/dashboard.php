<?= $this->extend('layout/admin_layout') ?>

<?= $this->section('content') ?>
    <!-- TOP BAR HEADER -->
    <header class="dv-header animate__animated animate__fadeIn">
        <div class="header-text">
            <span class="sub-label">Intelligence System</span>
            <h1 style="font-family: 'Playfair Display', serif; font-style: italic;">
                Welcome, <span style="font-family: 'Dancing Script', cursive; color: var(--gold);"><?= session()->get('user_name') ?>.</span>
            </h1>
        </div>
        
        <div style="display: flex; align-items: center; gap: 20px;">
            <a href="<?= base_url('/') ?>" target="_blank" style="font-size: 10px; opacity: 0.3; text-transform: uppercase; letter-spacing: 3px; text-decoration:none; color:#fff; font-weight:700;">
                Estate View <i class="fas fa-arrow-up-right-from-square" style="margin-left:5px"></i>
            </a>
        </div>
    </header>

    <!-- METRICS GRID -->
    <div class="metrics-grid">
        <!-- Metric 1: Revenue -->
        <div class="metric-card animate__animated animate__fadeInUp">
            <i class="fas fa-vault mc-icon"></i>
            <p class="mc-label">Net Revenue</p>
            <h3 class="mc-value success">Rp <?= number_format($net_revenue, 0, ',', '.') ?></h3>
        </div>
        
        <!-- Metric 2: Pending Orders -->
        <div class="metric-card animate__animated animate__fadeInUp" style="animation-delay: 0.1s">
            <i class="fas fa-shopping-bag mc-icon"></i>
            <p class="mc-label">Pending Orders</p>
            <h3 class="mc-value"><?= $new_orders ?></h3>
        </div>
        
        <!-- Metric 3: Inquiries -->
        <div class="metric-card animate__animated animate__fadeInUp" style="animation-delay: 0.2s">
            <i class="fas fa-comment-dots mc-icon"></i>
            <p class="mc-label">New Inquiries</p>
            <h3 class="mc-value"><?= $new_messages ?></h3>
        </div>
        
        <!-- Metric 4: Low Stock -->
        <div class="metric-card animate__animated animate__fadeInUp" style="animation-delay: 0.3s">
            <i class="fas fa-boxes-stacked mc-icon"></i>
            <p class="mc-label">Critical Stock</p>
            <h3 class="mc-value danger"><?= $low_stock ?></h3>
        </div>
    </div>

    <!-- RECENT TRANSMISSIONS TABLE -->
    <section class="data-vault animate__animated animate__fadeInUp" style="animation-delay: 0.4s">
        <div class="dv-header" style="margin-bottom: 30px; padding: 10px 15px 0;">
            <div>
                <h2 style="font-family: 'Playfair Display', serif; font-style: italic; color: #fff; font-size: 1.8rem;">Recent Transmissions</h2>
                <p style="font-size: 9px; color:var(--gold-dim); letter-spacing: 4px; margin-top: 5px; font-weight:700; text-transform:uppercase">Live Ledger Registry</p>
            </div>
            <button class="btn-prime" onclick="window.location.href='<?= base_url('admin/orders') ?>'">View All Vault</button>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Identificator</th>
                    <th>Hash Code</th>
                    <th>Valuation</th>
                    <th>Service</th>
                    <th style="text-align: right;">State</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($recent_reservations)): ?>
                    <?php foreach($recent_reservations as $row): ?>
                    <tr>
                        <td data-label="Identificator">
                            <strong style="color: #fff; font-size: 15px;"><?= esc($row['customer_name']) ?></strong>
                            <div style="font-size: 10px; opacity:0.3; margin-top:5px">
                                <?= date('d M Y • H:i', strtotime($row['created_at'])) ?>
                            </div>
                        </td>
                        
                        <td data-label="Hash Code">
                            <code style="letter-spacing: 1px; color: var(--gold-dim);">#<?= esc($row['order_code']) ?></code>
                        </td>
                        
                        <td data-label="Valuation">
                            <b style="color:var(--gold)">Rp <?= number_format($row['total_amount'], 0, ',', '.') ?></b>
                        </td>
                        
                        <td data-label="Service">
                            <span style="font-size: 11px; text-transform:uppercase; letter-spacing:1px; opacity:0.6">
                                <?= esc($row['service_type']) ?>
                            </span>
                        </td>
                        
                        <td data-label="State" style="text-align: right;">
                            <?php 
                                $isPending = ($row['status'] === 'pending');
                                $statusStyle = $isPending ? 'border-color: #f39c12; color: #f39c12; background: rgba(243, 156, 18, 0.05);' : 'border-color: #2ecc71; color: #2ecc71; background: rgba(46, 204, 113, 0.05);';
                            ?>
                            <span class="badge" style="<?= $statusStyle ?>">
                                <?= strtoupper(esc((string)$row['status'])) ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align:center; padding: 80px; opacity:0.3; font-style:italic">No active transmissions found in registry.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>

    <!-- STYLES KHUSUS DASHBOARD (Agar tetap rapi di layout global) -->
    <style>
        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 40px;
        }

        .metric-card {
            background: var(--carbon-light);
            padding: 30px;
            border-radius: 25px;
            border: 1px solid var(--border);
            position: relative;
            overflow: hidden;
            transition: 0.4s;
        }

        .metric-card:hover { transform: translateY(-10px); border-color: var(--gold-dim); box-shadow: 0 20px 40px rgba(0,0,0,0.4); }

        .mc-label { font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; color: var(--gold-dim); margin-bottom: 10px; }
        .mc-value { font-size: 1.8rem; font-weight: 800; color: #fff; font-family: 'Playfair Display', serif; }
        .mc-icon { position: absolute; right: 20px; bottom: 20px; font-size: 40px; color: var(--gold); opacity: 0.03; transition: 0.4s; }
        .metric-card:hover .mc-icon { opacity: 0.1; transform: scale(1.1); }
        
        .mc-value.success { color: var(--success); }
        .mc-value.danger { color: var(--danger); }

        @media (max-width: 1100px) {
            .metrics-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 600px) {
            .metrics-grid { grid-template-columns: 1fr; }
        }
    </style>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <script>
        // Dashboard specific scripts (if any)
        console.log("Console Elite Active");
    </script>
<?= $this->endSection() ?>
<?= $this->extend('layout/admin_layout') ?>

<?= $this->section('content') ?>
    <div class="dv-header animate__animated animate__fadeIn">
        <div>
            <span class="sub-label">Customer Communications</span>
            <h1 class="serif italic" style="font-size: 3rem; color: #fff; margin-top:5px;">Concierge Inbox</h1>
        </div>
        <div style="text-align: right">
             <p style="font-size: 11px; opacity: 0.4;">Unread Transmissions: <b style="color:var(--gold)"><?= $new_messages ?></b></p>
        </div>
    </div>

    <section class="data-vault animate__animated animate__fadeInUp" style="animation-delay: 0.2s">
        <table>
            <thead>
                <tr>
                    <th>Sender</th>
                    <th>Subject</th>
                    <th>Transmission Preview</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($messages)): ?>
                    <?php foreach($messages as $m): ?>
                    <tr id="msg-row-<?= $m['id'] ?>" class="inbox-row <?= $m['status'] == 'unread' ? 'unread' : '' ?>">
                        <td data-label="Sender">
                            <div class="sender-info">
                                <b><?= esc($m['name']) ?></b>
                                <span><?= esc($m['email']) ?></span>
                            </div>
                        </td>
                        <td data-label="Subject">
                            <span class="subject-text"><?= esc($m['subject']) ?></span>
                        </td>
                        <td data-label="Preview">
                            <div class="msg-preview">
                                <?= esc($m['message']) ?>
                            </div>
                        </td>
                        <td data-label="Action" style="text-align: right;">
                            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                <button class="btn-icon" title="Read Transmission" onclick='readMessage(<?= htmlspecialchars(json_encode($m), ENT_QUOTES, 'UTF-8') ?>)'>
                                    <i class="fas fa-envelope-open"></i>
                                </button>
                                <button class="btn-icon btn-del" title="Purge Message" onclick="confirmDelete(<?= $m['id'] ?>)">
                                    <i class="fas fa-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 100px; opacity: 0.3;">THE INBOX IS CURRENTLY SILENT.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>

    <style>
        .serif { font-family: 'Playfair Display', serif; }
        .italic { font-style: italic; }

        /* Inbox Row Logic */
        .inbox-row.unread td { 
            background: rgba(245, 222, 179, 0.03); 
            color: #fff; 
        }
        .inbox-row.unread td:first-child { 
            border-left: 3px solid var(--gold) !important; 
        }

        .sender-info b { display: block; color: #fff; font-size: 15px; margin-bottom: 2px; }
        .sender-info span { font-size: 11px; opacity: 0.4; letter-spacing: 0.5px; }

        .subject-text { color: var(--gold); font-weight: 600; font-size: 13px; letter-spacing: 0.5px; }

        .msg-preview { 
            opacity: 0.5; 
            max-width: 250px; 
            white-space: nowrap; 
            overflow: hidden; 
            text-overflow: ellipsis; 
            font-size: 12px;
        }

        /* SweetAlert Custom UI untuk Inbox */
        .swal2-inbox-popup {
            border-radius: 25px !important;
            border: 1px solid var(--border) !important;
        }
        .swal2-inbox-title {
            font-family: 'Playfair Display', serif !important;
            font-style: italic !important;
            color: var(--gold) !important;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            padding-bottom: 20px !important;
        }

        @media (max-width: 768px) {
            .msg-preview { max-width: 100%; }
            .inbox-row.unread td:first-child { border-left: 1px solid var(--border) !important; }
            .inbox-row.unread { border-left: 4px solid var(--gold); }
        }
    </style>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <script>
        function readMessage(data) {
            Swal.fire({
                title: data.subject,
                html: `
                    <div style="text-align: left; font-family: 'Poppins'; font-size: 13px; line-height: 1.6; color: #d1d1d1;">
                        <div style="background: rgba(255,255,255,0.02); padding: 15px; border-radius: 12px; margin-bottom: 20px; border: 1px solid rgba(255,255,255,0.05);">
                            <p style="margin-bottom: 5px;"><small style="color:var(--gold); font-size:9px; text-transform:uppercase; letter-spacing:1px; font-weight:700;">Identified Sender</small></p>
                            <b style="color:#fff; font-size:15px;">${data.name}</b><br>
                            <span style="opacity:0.5;">${data.email}</span>
                        </div>
                        <p style="white-space: pre-wrap; padding: 0 5px;">${data.message}</p>
                    </div>
                `,
                background: '#0d0d0d',
                color: '#f5deb3',
                confirmButtonColor: '#f5deb3',
                confirmButtonText: '<span style="color:#000; font-weight:800; font-size:10px; letter-spacing:1px;">MARK AS READ</span>',
                showCloseButton: true,
                customClass: {
                    popup: 'swal2-inbox-popup',
                    title: 'swal2-inbox-title'
                }
            }).then((result) => {
                // Jika pesan masih unread dan admin klik tombol konfirmasi
                if (result.isConfirmed && data.status === 'unread') {
                    fetch('<?= base_url('admin/mark_message_read') ?>/' + data.id, { 
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                        }
                    })
                    .then(res => res.json())
                    .then(res => {
                        if(res.success) {
                            const row = document.getElementById('msg-row-' + data.id);
                            if(row) row.classList.remove('unread');
                            
                            // Opsional: Refresh badge di sidebar jika perlu
                            // location.reload(); 
                        }
                    });
                }
            });
        }

        function confirmDelete(id) {
            Swal.fire({
                title: 'Purge Transmission?',
                text: "This record will be permanently erased from the console.",
                icon: 'warning',
                background: '#0d0d0d', color: '#f5deb3',
                showCancelButton: true,
                confirmButtonColor: '#e74c3c', 
                confirmButtonText: 'PURGE',
                cancelButtonText: 'ABORT'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?= base_url('admin/delete_message/') ?>/" + id;
                }
            })
        }

        <?php if(session()->getFlashdata('success')): ?>
            Swal.fire({ 
                icon: 'success', title: 'Ledger Updated', 
                text: '<?= session()->getFlashdata('success') ?>', 
                background: '#0d0d0d', color: '#f5deb3', confirmButtonColor: '#f5deb3' 
            });
        <?php endif; ?>
    </script>
<?= $this->endSection() ?>
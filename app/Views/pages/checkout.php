<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Secure Checkout | Coffee Time Private</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Fonts: Luxury Trio -->
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=Poppins:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons & SweetAlert -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --onyx: #070404;
            --dark-gray: #0e090a;
            --gold: #f5deb3;
            --gold-muted: rgba(245, 222, 179, 0.5);
            --gold-low: rgba(245, 222, 179, 0.08);
            --white: #ffffff;
            --transit: cubic-bezier(0.23, 1, 0.32, 1);
            --shadow: 0 30px 60px rgba(0,0,0,0.7);
        }

        /* 1. RESET & BASE */
        * { margin: 0; padding: 0; box-sizing: border-box; -webkit-tap-highlight-color: transparent; }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--onyx);
            color: var(--gold);
            line-height: 1.6;
            background-image: url("https://www.transparenttextures.com/patterns/black-linen.png");
            overflow-x: hidden;
        }

        /* 2. LAYOUT STRUCTURE */
        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Navigation Style Header */
        header {
            padding: 40px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .brand { font-family: 'Dancing Script', cursive; font-size: 30px; text-decoration: none; color: var(--gold); }
        .secure-tag { font-size: 10px; text-transform: uppercase; letter-spacing: 2px; opacity: 0.5; display: flex; align-items: center; gap: 8px; }

        .checkout-grid {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 60px;
            margin-bottom: 100px;
            align-items: start;
        }

        /* 3. FORM COMPONENTS */
        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            color: var(--white);
            margin-bottom: 35px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .section-title span { font-size: 12px; font-family: 'Poppins'; color: var(--gold); opacity: 0.5; border: 1px solid var(--gold-low); padding: 4px 12px; border-radius: 50px; }

        .form-card {
            background: var(--dark-gray);
            border: 1px solid var(--gold-low);
            padding: 45px;
            border-radius: 35px;
            box-shadow: var(--shadow);
        }

        .input-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px; }
        .input-group { margin-bottom: 25px; }
        .input-group label {
            display: block; font-size: 10px; text-transform: uppercase; letter-spacing: 2px;
            color: var(--gold-muted); margin-bottom: 10px; font-weight: 600;
        }
        .input-group input, .input-group select, .input-group textarea {
            width: 100%; background: rgba(255,255,255,0.02); border: 1px solid var(--gold-low);
            padding: 16px 20px; border-radius: 15px; color: #fff; font-family: inherit;
            outline: none; transition: 0.4s var(--transit);
        }
        .input-group input:focus, .input-group select:focus { border-color: var(--gold); background: rgba(255,255,255,0.05); }

        /* 4. SUMMARY / RECEIPT STYLE */
        .order-summary {
            position: sticky; top: 40px;
            background: var(--dark-gray);
            border: 1px solid var(--gold-low);
            border-radius: 35px;
            padding: 40px;
            box-shadow: var(--shadow);
        }
        .summary-header { border-bottom: 1px solid var(--gold-low); padding-bottom: 20px; margin-bottom: 25px; }
        
        .item-list { max-height: 280px; overflow-y: auto; padding-right: 5px; }
        .item-list::-webkit-scrollbar { width: 3px; }
        .item-list::-webkit-scrollbar-thumb { background: var(--gold-low); border-radius: 10px; }

        .item { display: flex; align-items: center; gap: 15px; margin-bottom: 20px; }
        .item img { width: 55px; height: 55px; object-fit: cover; border-radius: 12px; border: 1px solid var(--gold-low); }
        .item-info { flex: 1; }
        .item-info h4 { font-size: 0.9rem; color: #fff; margin-bottom: 2px; }
        .item-info p { font-size: 0.75rem; color: var(--gold-muted); }
        .item-price { font-size: 0.9rem; font-weight: 600; color: var(--gold); }

        .calculation { border-top: 1px dotted var(--gold-low); padding-top: 25px; margin-top: 10px; }
        .calc-row { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 13px; opacity: 0.7; }
        .calc-row.grand-total { border-top: 1px solid var(--gold-low); padding-top: 20px; margin-top: 10px; opacity: 1; color: var(--gold); font-size: 1.4rem; font-weight: 700; }

        /* 5. BUTTONS */
        .btn-main {
            width: 100%; background: var(--gold); color: var(--onyx); border: none;
            padding: 22px; border-radius: 50px; font-weight: 800; text-transform: uppercase;
            letter-spacing: 3px; font-size: 11px; cursor: pointer; transition: 0.4s var(--transit);
            margin-top: 30px;
        }
        .btn-main:hover { background: var(--white); transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.4); }

        .btn-back { display: inline-flex; align-items: center; gap: 10px; color: var(--gold-muted); text-decoration: none; font-size: 11px; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 30px; transition: 0.3s; }
        .btn-back:hover { color: var(--white); transform: translateX(-5px); }

        /* Luxury Service Selector */
        .service-type-selector {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 5px;
        }
        .service-option {
            background: rgba(255,255,255,0.02);
            border: 1px solid var(--gold-low);
            padding: 15px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            cursor: pointer;
            transition: 0.4s var(--transit);
            filter: grayscale(1);
            opacity: 0.5;
        }
        .service-option.active {
            background: var(--gold-low);
            border-color: var(--gold);
            filter: grayscale(0);
            opacity: 1;
        }
        .service-option i { font-size: 18px; }
        .service-option span { font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; }

        #locationContainer {
            animation: fadeIn 0.5s var(--transit);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ================= LUXURY DROPDOWN STYLE ================= */
        .luxury-select-wrapper {
            position: relative;
            width: 100%;
        }

        .luxury-select-wrapper select {
            width: 100%;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--gold-low);
            padding: 18px 50px 18px 20px; /* Ruang ekstra di kanan untuk ikon */
            border-radius: 15px;
            color: var(--white);
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            font-weight: 500;
            appearance: none; /* Hilangkan panah asli browser */
            -webkit-appearance: none;
            -moz-appearance: none;
            cursor: pointer;
            transition: 0.4s var(--transit);
            outline: none;
        }

        /* Ikon Panah Emas */
        .luxury-select-wrapper i {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gold);
            font-size: 12px;
            pointer-events: none; /* Biar tetap bisa klik select-nya */
            transition: 0.3s;
        }

        /* Hover & Focus State */
        .luxury-select-wrapper select:hover {
            background: rgba(255, 255, 255, 0.06);
            border-color: var(--gold-soft);
        }

        .luxury-select-wrapper select:focus {
            border-color: var(--gold);
            box-shadow: 0 0 20px rgba(245, 222, 179, 0.1);
        }

        /* Menghias Kotak Pilihan (Hanya berfungsi di Chrome/Modern Browser) */
        .luxury-select-wrapper select option {
            background-color: var(--dark-gray); /* Background dropdown jadi gelap */
            color: var(--white);
            padding: 15px;
            font-size: 14px;
        }

        /* Efek saat select terbuka (Opsional) */
        .luxury-select-wrapper select:focus + i {
            transform: translateY(-50%) rotate(180deg);
            color: var(--white);
        }

        /* Mobile Optimization */
        @media (max-width: 768px) {
            .luxury-select-wrapper select {
                padding: 15px 45px 15px 15px;
                font-size: 13px;
            }
        }

        /* 6. MOBILE RESPONSIVE REFINEMENT */
        @media (max-width: 992px) {
            .checkout-grid { grid-template-columns: 1fr; gap: 40px; }
            .order-summary { position: static; order: -1; } /* Summary first on mobile */
            header { padding: 30px 0; }
            .form-card { padding: 30px 20px; }
            .input-row { grid-template-columns: 1fr; }
        }

        @media (max-width: 480px) {
            .section-title { font-size: 1.5rem; }
            .calc-row.grand-total { font-size: 1.2rem; }
            .btn-main { padding: 18px; font-size: 10px; }
        }
    </style>
</head>
<body>

    <div class="container">
        <header>
            <a href="<?= base_url('/') ?>" class="brand">Coffee Time.</a>
            <div class="secure-tag"><i class="fas fa-lock"></i> SSL Secured</div>
        </header>

        <a href="<?= base_url('menu') ?>" class="btn-back">
            <i class="fas fa-chevron-left"></i> Edit Selection
        </a>

        <main class="checkout-grid">
            
            <!-- LEFT: RESERVATION FORM -->
            <section>
                <div class="section-title">
                    <span>Step 01</span> Private Details
                </div>

                <div class="form-card">
                    <form id="finalOrderForm">
                        <!-- NAMA PELANGGAN -->
                        <div class="input-group">
                            <label>Reserve For (Full Name)</label>
                            <input type="text" id="custName" placeholder="e.g. Alexander Pierce" required>
                        </div>

                        <!-- PILIHAN LAYANAN (Dine-In / Delivery) -->
                        <div class="input-group">
                            <label>Service Experience</label>
                            <div class="service-type-selector">
                                <div class="service-option active" data-value="dinein">
                                    <i class="fas fa-chair"></i>
                                    <span>Dine-In</span>
                                </div>
                                <div class="service-option" data-value="delivery">
                                    <i class="fas fa-truck"></i>
                                    <span>Delivery</span>
                                </div>
                            </div>
                            <input type="hidden" id="serviceType" value="dinein">
                        </div>

                        <!-- DYNAMIC LOCATION INPUT -->
                        <div class="input-group" id="locationContainer">
                            <label id="locationLabel">Table Selection</label>

                            <!-- DROPDOWN (DINE-IN) -->
                            <div class="luxury-select-wrapper" id="dineInSelect">
                                <select id="dineInLocation">
                                    <option value="" disabled selected>Select table...</option>
                                    <option>Table 01</option>
                                    <option>Table 02</option>
                                    <option>Table 03</option>
                                    <option>Table 05</option>
                                    <option>Table 06</option>
                                    <option>Table 07</option>
                                    <option>Table 08</option>
                                    <option>Table 09</option>
                                    <option>Table 10</option>
                                    <option>Window Seat</option>
                                </select>
                                <i class="fas fa-chevron-down"></i>
                            </div>

                            <!-- INPUT (DELIVERY) -->
                            <div style="position:relative; display:none;" id="deliveryInput">
                                <i id="locationIcon" class="fas fa-map-marker-alt"
                                style="position:absolute; left:20px; top:50%; transform:translateY(-50%); opacity:0.5;"></i>
                                <input type="text"
                                    id="custLocation"
                                    placeholder="e.g. Sudirman Tower, 15th Floor, Jakarta"
                                    style="padding-left:50px;">
                            </div>
                        </div>

                        <!-- METODE PEMBAYARAN -->
                        <div class="input-group">
                            <label>Settlement Method</label>
                            <div class="luxury-select-wrapper">
                                <select id="payMethod">
                                    <option value="" disabled>Choose your payment...</option>
                                    <option value="qris">Instant QRIS Payment</option>
                                    <option value="transfer">Luxury Bank Transfer</option>
                                    <option value="cash">Personal Concierge (Cash)</option>
                                </select>
                                <!-- Ikon panah kustom -->
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>

                        <!-- CATATAN -->
                        <div class="input-group">
                            <label>Special Requests / Notes</label>
                            <textarea id="custNotes" rows="3" placeholder="Dietary restrictions or special brewing notes..."></textarea>
                        </div>

                        <button type="submit" class="btn-main">Authorize Reservation</button>
                    </form>
                </div>
            </section>

            <!-- RIGHT: ORDER SUMMARY -->
            <aside>
                <div class="section-title">
                    <span>Step 02</span> Summary
                </div>

                <div class="order-summary">
                    <div class="summary-header">
                        <p style="font-size: 10px; letter-spacing: 2px; opacity: 0.5; text-transform: uppercase;">Review Items</p>
                    </div>

                    <div class="item-list" id="checkoutItemsList">
                        <!-- Filled by JavaScript -->
                    </div>

                    <div class="calculation">
                        <div class="calc-row">
                            <span>Artisan Subtotal</span>
                            <span id="subtotalVal">Rp 0</span>
                        </div>
                        <div class="calc-row">
                            <span>Service & Heritage Tax (10%)</span>
                            <span id="taxVal">Rp 0</span>
                        </div>
                        <div class="calc-row grand-total">
                            <span style="font-size: 11px; text-transform: uppercase; letter-spacing: 2px; opacity: 0.7;">Grand Total</span>
                            <b id="grandTotalVal">Rp 0</b>
                        </div>
                    </div>
                </div>
            </aside>

        </main>
    </div>

    <!-- JAVASCRIPT LOGIC -->
    <script>
        // Ambil User ID dari PHP untuk mencocokkan Key Keranjang
        const currentUserId = "<?= session()->get('user_id') ?>";
        const cartKey = `coffee_cart_user_${currentUserId}`;

        document.addEventListener('DOMContentLoaded', () => {
            // AMBIL DATA DARI KEY YANG BENAR (Per User)
            const cart = JSON.parse(localStorage.getItem(cartKey)) || [];
            const itemList = document.getElementById('checkoutItemsList');

            if (cart.length === 0) {
                Swal.fire({
                    title: 'Empty Carriage',
                    text: 'Please select your artisanal brew before checking out.',
                    icon: 'info',
                    background: '#0e090a', color: '#f5deb3', confirmButtonColor: '#f5deb3'
                }).then(() => { window.location.href = "<?= base_url('menu') ?>"; });
                return;
            }

            let subtotal = 0;
            cart.forEach(item => {
                const rowTotal = Number(item.price) * Number(item.qty);
                subtotal += rowTotal;

                itemList.innerHTML += `
                    <div class="item">
                        <img src="${item.img}" onerror="this.src='https://dummyimage.com/100/1a1a1a/f5deb3&text=Coffee'">
                        <div class="item-info">
                            <h4>${item.name}</h4>
                            <p>${item.qty} unit${item.qty > 1 ? 's' : ''} x Rp ${new Intl.NumberFormat('id-ID').format(item.price)}</p>
                        </div>
                        <div class="item-price">
                            Rp ${new Intl.NumberFormat('id-ID').format(rowTotal)}
                        </div>
                    </div>`;
            });

            const tax = subtotal * 0.10;
            const grandTotal = subtotal + tax;

            document.getElementById('subtotalVal').innerText = `Rp ${new Intl.NumberFormat('id-ID').format(subtotal)}`;
            document.getElementById('taxVal').innerText = `Rp ${new Intl.NumberFormat('id-ID').format(tax)}`;
            document.getElementById('grandTotalVal').innerText = `Rp ${new Intl.NumberFormat('id-ID').format(grandTotal)}`;
        });

        document.getElementById('finalOrderForm').onsubmit = async (e) => {
            e.preventDefault();

            const cart = JSON.parse(localStorage.getItem(cartKey)) || [];
            
            // Hitung total kembali untuk dikirim
            let subtotal = 0;
            cart.forEach(item => subtotal += (Number(item.price) * Number(item.qty)));
            const tax = subtotal * 0.10;
            const grandTotal = subtotal + tax;

            const formData = {
                customer_name: document.getElementById('custName').value,
                service_type: document.getElementById('serviceType').value,
                location:
                    document.getElementById('serviceType').value === 'dinein'
                        ? document.getElementById('dineInLocation').value
                        : document.getElementById('custLocation').value,
                payment_method: document.getElementById('payMethod').value,
                notes: document.getElementById('custNotes').value,
                total_amount: grandTotal,
                tax_amount: tax,
                items: cart
            };

            // Validasi Payment Method
            if (!formData.payment_method) {
                Swal.fire({ icon: 'warning', title: 'Payment Required', text: 'Please select your settlement method.', background: '#0e090a', color: '#f5deb3' });
                return;
            }

            Swal.fire({
                title: 'Processing Order...',
                text: 'Securing your private reservation.',
                background: '#0e090a', color: '#f5deb3',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });

            try {
                const response = await fetch('<?= base_url("checkout/process") ?>', {
                    method: 'POST',
                    headers: { 
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '<?= csrf_hash() ?>' // TAMBAHKAN INI AGAR TIDAK ERROR 403
                    },
                    body: JSON.stringify(formData)
                });

                const result = await response.json();

                if (result.success) {
                    localStorage.removeItem(cartKey); // Hapus keranjang milik user ini
                    Swal.fire({
                        icon: 'success',
                        title: 'Order Secured',
                        text: 'Your reservation code: ' + result.order_code,
                        background: '#0e090a', color: '#f5deb3',
                        confirmButtonColor: '#f5deb3'
                    }).then(() => {
                        window.location.href = "<?= base_url('/') ?>";
                    });
                } else {
                    Swal.fire({ icon: 'error', title: 'Authorization Failed', text: result.message, background: '#0e090a', color: '#f5deb3' });
                }
            } catch (error) {
                Swal.fire({ icon: 'error', title: 'System Error', text: 'Koneksi ke server terputus.', background: '#0e090a', color: '#f5deb3' });
            }
        };

        // Logika Switch Service Type (Dine-in / Delivery)
        const serviceOptions = document.querySelectorAll('.service-option');

        serviceOptions.forEach(option => {
            option.addEventListener('click', () => {
                serviceOptions.forEach(opt => opt.classList.remove('active'));
                option.classList.add('active');

                const value = option.dataset.value;
                document.getElementById('serviceType').value = value;

                const label = document.getElementById('locationLabel');
                const dineIn = document.getElementById('dineInSelect');
                const delivery = document.getElementById('deliveryInput');
                const input = document.getElementById('custLocation');
                const select = document.getElementById('dineInLocation');

                if (value === 'dinein') {
                    label.innerText = "Table Selection";
                    dineIn.style.display = "block";
                    delivery.style.display = "none";
                    input.removeAttribute('required');
                    select.setAttribute('required', 'required');
                } else {
                    label.innerText = "Destination Address";
                    dineIn.style.display = "none";
                    delivery.style.display = "block";
                    select.removeAttribute('required');
                    input.setAttribute('required', 'required');
                }
            });
        });
    </script>
</body>
</html>
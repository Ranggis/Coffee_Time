<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\ProductModel; // Tambahkan ini jika butuh validasi produk

class Checkout extends BaseController
{
    public function index()
    {
        // Pastikan login
        if (!session()->get('is_logged_in')) {
            return redirect()->to('/auth/login');
        }

        $userModel = new UserModel();
        $user = $userModel->find(session()->get('user_id'));

        // Load view checkout
        return view('pages/checkout', ['user' => $user]);
    }

    public function process()
    {
        // 1. Cek Login & ambil data JSON dari Fetch JS
        if (!session()->get('is_logged_in')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Session expired.']);
        }

        $json = $this->request->getJSON(); // Ambil data JSON

        if (!$json || empty($json->items)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Cart is empty.']);
        }

        $db = \Config\Database::connect();
        $orderModel     = new OrderModel();
        $orderItemModel = new OrderItemModel();

        // 🔐 Generate order code kustom
        $orderCode = 'CT-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(2)));

        // 🚀 MULAI TRANSAKSI DATABASE (Agar data aman jika ada error tengah jalan)
        $db->transStart();

        try {
            // 2. SIMPAN KE TABEL ORDERS
            $orderId = $orderModel->insert([
                'user_id'        => session()->get('user_id'),
                'order_code'     => $orderCode,
                'customer_name'  => $json->customer_name,  // Data baru dari form
                'service_type'   => $json->service_type,   // dinein / delivery
                'location'       => $json->location,       // No meja / Alamat
                'total_amount'   => $json->total_amount,
                'tax_amount'     => $json->tax_amount,     // Simpan pajak juga
                'payment_method' => $json->payment_method,
                'notes'          => $json->notes,          // Catatan khusus
                'status'         => 'pending'
            ]);

            // 3. SIMPAN KE TABEL ORDER ITEMS (Looping)
            foreach ($json->items as $item) {
                // Catatan: Pastikan di LocalStorage 'items' mengandung 'product_id'
                $orderItemModel->insert([
                    'order_id'   => $orderId,
                    'product_id' => $item->id, // Sesuaikan dengan key di JS (item.id)
                    'price'      => $item->price,
                    'quantity'   => $item->qty,
                    'subtotal'   => $item->price * $item->qty
                ]);
            }

            $db->transComplete(); // Selesaikan transaksi

            if ($db->transStatus() === FALSE) {
                return $this->response->setJSON(['success' => false, 'message' => 'Database error.']);
            }

            // 4. BERIKAN RESPON SUKSES
            return $this->response->setJSON([
                'success' => true,
                'order_code' => $orderCode,
                'message' => 'Reservation secured successfully'
            ]);

        } catch (\Exception $e) {
            $db->transRollback(); // Batalkan semua jika error
            return $this->response->setJSON(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
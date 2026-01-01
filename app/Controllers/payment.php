<?php

namespace App\Controllers;

use App\Models\OrderModel;

class Payment extends BaseController
{
    // ===============================
    // HALAMAN PAYMENT
    // ===============================
    public function index($orderCode)
    {
        if (!session()->get('is_logged_in')) {
            return redirect()->to('/auth/login');
        }

        $orderModel = new OrderModel();
        $order = $orderModel
            ->where('order_code', $orderCode)
            ->first();

        if (!$order) {
            return redirect()->to('/menu')
                ->with('error', 'Order tidak ditemukan');
        }

        return view('pages/payment', [
            'order' => $order
        ]);
    }

    // ===============================
    // CONFIRM PAYMENT (FINAL)
    // ===============================
    public function confirm($orderCode)
    {
        if (!session()->get('is_logged_in')) {
            return redirect()->to('/auth/login');
        }

        $orderModel = new OrderModel();

        $order = $orderModel
            ->where('order_code', $orderCode)
            ->first();

        if (!$order) {
            return redirect()->to('/menu')
                ->with('error', 'Order tidak ditemukan');
        }

        // 🔄 UPDATE STATUS ORDER
        $orderModel
            ->where('order_code', $orderCode)
            ->set([
                'status' => 'processing'
            ])
            ->update();

        // 🔥 FLAG PAYMENT SUKSES (UNTUK CLEAR CART)
        session()->setFlashdata('payment_success', true);

        // 👉 LANJUT KE TRACKING
        return redirect()->to('/tracking/' . $orderCode);
    }
}

<?php

namespace App\Controllers;

use App\Models\OrderModel;

class Tracking extends BaseController
{
    // ===============================
    // HALAMAN TRACKING
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
            return redirect()->to('/menu');
        }

        return view('pages/tracking', [
            'order' => $order
        ]);
    }

    // ===============================
    // PESANAN DITERIMA
    // ===============================
    public function complete($orderCode)
    {
        if (!session()->get('is_logged_in')) {
            return redirect()->to('/auth/login');
        }

        $orderModel = new OrderModel();

        $order = $orderModel
            ->where('order_code', $orderCode)
            ->first();

        if (!$order) {
            return redirect()->to('/menu');
        }

        // ✅ UPDATE STATUS ORDER
        $orderModel
            ->where('order_code', $orderCode)
            ->set(['status' => 'completed'])
            ->update();

        // 🔔 FLASH MESSAGE (UNTUK MENU)
        session()->setFlashdata('order_done', true);

        // 👉 BALIK KE MENU
        return redirect()->to('/menu');
    }
}

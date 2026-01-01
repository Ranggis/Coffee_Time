<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\UserModel;
use App\Models\ProductModel;

class User extends BaseController
{
    protected $orderModel;
    protected $orderItemModel;
    protected $userModel;
    protected $productModel;

    public function __construct()
    {
        $this->orderModel     = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->userModel      = new UserModel();
        $this->productModel   = new ProductModel();
    }

    /**
     * ===============================
     * ORDER HISTORY (ODYSSEY LOGS)
     * ===============================
     */
    public function history()
    {
        $userId = session()->get('user_id');
        if (!$userId) return redirect()->to('/auth/login');

        $data = [
            'title'  => 'My Coffee Odyssey | Coffee Time',
            'orders' => $this->orderModel
                ->where('user_id', $userId)
                ->orderBy('id', 'DESC')
                ->findAll(),
        ];

        return view('user/history', $data);
    }

    /**
     * ===============================
     * CONFIRM RECEIVE (DELIVERY)
     * ===============================
     */
    public function confirm_received($id)
    {
        $userId = session()->get('user_id');
        $order  = $this->orderModel->where(['id' => $id, 'user_id' => $userId])->first();

        // Protokol: Hanya bisa konfirmasi jika status sedang dikirim
        if ($order && $order['status'] === 'out-for-delivery') {
            
            // 1. Update status menjadi completed
            $this->orderModel->update($id, ['status' => 'completed']);

            // 2. Logika pengurangan stok produk
            $items = $this->orderItemModel->where('order_id', $id)->findAll();
            
            foreach ($items as $item) {
                $this->productModel
                    ->set('stock', 'stock - ' . (int)$item['quantity'], false)
                    ->where('id', $item['product_id'])
                    ->update();
            }

            return redirect()->back()->with('success', 'Transmission Received. Enjoy your artisanal brew.');
        }

        return redirect()->back()->with('error', 'Unauthorized identity protocol.');
    }

    /**
     * ===============================
     * CANCEL ORDER (PENDING ONLY)
     * ===============================
     */
    public function cancel_order($id)
    {
        $userId = session()->get('user_id');
        
        // Protokol: Hanya bisa batal jika status masih pending
        $order = $this->orderModel->where([
            'id'      => $id, 
            'user_id' => $userId, 
            'status'  => 'pending'
        ])->first();

        if ($order) {
            $this->orderModel->update($id, ['status' => 'cancelled']);
            return redirect()->back()->with('success', 'Transmission #' . $order['order_code'] . ' has been aborted.');
        }

        return redirect()->back()->with('error', 'Unable to abort. Order already in process.');
    }

    /**
     * ===============================
     * SOVEREIGN IDENTITY (PROFILE)
     * ===============================
     */
    public function profile()
    {
        $userId = session()->get('user_id');
        if (!$userId) return redirect()->to('/auth/login');

        $data = [
            'title' => 'Sovereign Identity | Coffee Time',
            'user'  => $this->userModel->find($userId),
        ];

        return view('user/profile', $data);
    }

    /**
     * ===============================
     * UPDATE IDENTITY (SAVE CHANGES)
     * ===============================
     */
    public function update_profile()
    {
        $userId = session()->get('user_id');
        if (!$userId) return redirect()->to('/auth/login');

        $user = $this->userModel->find($userId);

        $data = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'phone'    => $this->request->getPost('phone'),
            'address'  => $this->request->getPost('address'),
        ];

        // 1. Handle Encryption Key (Password)
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        // 2. Handle Visual Identity (Avatar Upload)
        $file = $this->request->getFile('avatar');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            
            // Definisikan path folder upload
            $uploadPath = FCPATH . 'uploads/users';

            // Cek & Buat folder jika belum ada
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Generate nama random untuk keamanan
            $newName = $file->getRandomName();
            $file->move($uploadPath, $newName);

            // Hapus berkas avatar lama dari server jika ada (Efisiensi Storage)
            if (!empty($user['avatar']) && file_exists($uploadPath . '/' . $user['avatar'])) {
                unlink($uploadPath . '/' . $user['avatar']);
            }

            $data['avatar'] = $newName; 
        }

        // 3. Sinkronisasi Database
        $this->userModel->update($userId, $data);

        // 4. Sinkronisasi Session (Agar nama di Navbar langsung berubah)
        if (isset($data['avatar'])) {
            session()->set('user_avatar', $data['avatar']);
        }
        
        return redirect()->to('/user/profile')->with('success', 'Identity synchronized successfully.');
    }
}
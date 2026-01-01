<?php

namespace App\Controllers;

use App\Models\ContactModel;

class Contact extends BaseController
{
    public function index()
    {
        return view('contact_view'); // Sesuaikan dengan nama file view Anda
    }

    public function send()
    {
        // 1. Cek apakah user sudah login (Keamanan tambahan)
        if (!session()->get('is_logged_in')) {
            return redirect()->to('auth/login');
        }

        // 2. Load Model
        $model = new ContactModel();

        // 3. Ambil data dari Session (untuk Nama & Email) dan POST (untuk Subject & Message)
        $data = [
            'name'    => session()->get('user_name'),
            'email'   => session()->get('user_email'),
            'subject' => $this->request->getPost('subject'),
            'message' => $this->request->getPost('message'),
        ];

        // 4. Simpan ke Database
        if ($model->insert($data)) {
            // Kirim pesan sukses ke session untuk SweetAlert
            return redirect()->to('contact')->with('success', 'Message sent successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to send message');
        }
    }
}
<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminAuth implements FilterInterface
{
    /**
     * Mengecek session sebelum mengakses rute admin
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // 1. Cek apakah user sudah login
        // 2. Cek apakah role-nya adalah 'admin'
        if (!session()->get('is_logged_in') || session()->get('user_role') !== 'admin') {
            
            // Jika bukan admin, tendang ke halaman login dengan pesan error
            return redirect()->to('/auth/login')->with('error', 'Otoritas ditolak. Area khusus Sovereign Admin.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Biasanya dibiarkan kosong
    }
}
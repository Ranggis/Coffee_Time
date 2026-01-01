<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function process_login()
    {
        $userModel = new UserModel();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Cari berdasarkan username atau email
        $user = $userModel
            ->where('username', $username)
            ->orWhere('email', $username)
            ->first();

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan dalam catatan kami.');
        }

        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Password yang Anda masukkan salah.');
        }

        // 🔐 SET SESSION
        session()->set([
            'is_logged_in' => true,
            'user_id'      => $user['id'],
            'user_name'    => $user['username'],
            'user_email'   => $user['email'],
            'user_role'    => $user['role'],
        ]);
        // --- UBAH BAGIAN REDIRECT INI ---
        $lastPage = session()->get('last_page');

        if ($user['role'] === 'admin') {
            return redirect()->to('/admin')
                ->with('success', 'Sovereign Access Granted. Welcome, Admin.');
        }

        if ($lastPage) {
            return redirect()->to($lastPage)
                ->with('success', 'Selamat datang kembali di Coffee Time.');
        }

        return redirect()->to('/')
            ->with('success', 'Selamat datang kembali di Coffee Time.');
    }

    public function process_register()
    {
        $userModel = new UserModel();

        $username = $this->request->getPost('username');
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        if ($userModel->where('username', $username)->first()) {
            return redirect()->back()->with('error', 'Username sudah digunakan.');
        }

        if ($userModel->where('email', $email)->first()) {
            return redirect()->back()->with('error', 'Email ini sudah terdaftar.');
        }

        $userModel->insert([
            'username' => $username,
            'email'    => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role'     => 'customer'
        ]);

        return redirect()->to('auth/login')->with('success', 'Registrasi berhasil, silakan masuk.');
    }

    public function logout()
    {
        $lastPage = session()->get('last_page');

        session()->destroy();

        if ($lastPage) {
            return redirect()->to($lastPage)
                ->with('success', 'Anda telah keluar dari sistem.');
        }

        return redirect()->to('/')
            ->with('success', 'Anda telah keluar dari sistem.');
    }

    // ==========================================
    // FORGOT PASSWORD (PROSES KIRIM EMAIL)
    // ==========================================
    public function forgot_password()
    {
        $emailAddress = $this->request->getPost('email');
        
        if (!$emailAddress) {
            return $this->response->setJSON(['success' => false, 'message' => 'Alamat email wajib diisi.']);
        }

        $userModel = new UserModel();
        $user = $userModel->where('email', $emailAddress)->first();

        if ($user) {
            // 1. Buat token unik & waktu kadaluarsa (1 jam)
            $token = bin2hex(random_bytes(32));
            $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

            // 2. Update database user dengan token
            $userModel->update($user['id'], [
                'reset_token' => $token,
                'reset_expires_at' => $expiry
            ]);

            $resetLink = base_url("auth/reset_password/$token");

            // 3. Konfigurasi Email
            $email = \Config\Services::email();
            
            // Ambil email dari config agar sinkron dengan .env
            $senderEmail = config('Email')->SMTPUser; 
            
            $email->setTo($emailAddress);
            $email->setFrom($senderEmail, 'Coffee Time Concierge');
            $email->setSubject('Account Access Recovery');

            // 4. Template Email Luxury HTML
            $logoUrl = "https://raw.githubusercontent.com/Ranggis/Api-Image/main/favicon.ico";

            $message = "
            <div style='background-color: #070404; padding: 60px 20px; font-family: \"Playfair Display\", Georgia, serif; color: #f5deb3; text-align: center;'>
                <!-- Main Wrapper -->
                <div style='max-width: 600px; margin: 0 auto; background-color: #0e090a; border: 1px solid rgba(245, 222, 179, 0.15); border-radius: 4px; overflow: hidden; box-shadow: 0 30px 60px rgba(0,0,0,0.6);'>
                    
                    <!-- Header / Logo Area -->
                    <div style='padding: 50px 40px 30px;'>
                        <!-- Elegant Circular Logo -->
                        <img src='$logoUrl' width='70' height='70' style='display: block; margin: 0 auto 25px; border-radius: 50%; border: 1px solid #f5deb3; padding: 8px; background-color: #070404;' alt='Coffee Time Logo'>
                        
                        <h1 style='margin: 0; font-size: 26px; font-weight: normal; letter-spacing: 8px; text-transform: uppercase; color: #f5deb3;'>Coffee Time</h1>
                        <div style='width: 40px; height: 1px; background-color: #f5deb3; margin: 25px auto; opacity: 0.3;'></div>
                    </div>

                    <!-- Content Area -->
                    <div style='padding: 0 50px 50px; line-height: 2; font-family: \"Poppins\", Helvetica, Arial, sans-serif;'>
                        <h2 style='font-family: serif; color: #ffffff; font-size: 22px; margin-bottom: 20px; font-weight: normal; font-style: italic; letter-spacing: 1px;'>Security Verification</h2>
                        
                        <p style='font-size: 14px; color: rgba(245, 222, 179, 0.7); margin-bottom: 45px;'>
                            Kami mendeteksi permintaan akses untuk memperbarui kredensial akun roastery Anda. <br>
                            Demi keamanan koleksi pribadi Anda, silakan otorisasi melalui tautan di bawah ini.
                        </p>

                        <!-- Call to Action -->
                        <div style='margin-bottom: 45px;'>
                            <a href='$resetLink' style='background-color: #f5deb3; color: #070404; padding: 20px 50px; text-decoration: none; border-radius: 0; font-weight: 600; font-size: 11px; letter-spacing: 3px; display: inline-block; text-transform: uppercase; box-shadow: 0 10px 20px rgba(245, 222, 179, 0.2);'>
                                Authorize New Access
                            </a>
                        </div>

                        <!-- Notice -->
                        <p style='font-size: 11px; color: rgba(245, 222, 179, 0.4); margin: 0;'>
                            Abaikan email ini jika Anda tidak merasa melakukan permintaan. <br>
                            Tautan ini bersifat rahasia dan akan kedaluwarsa dalam 60 menit.
                        </p>
                    </div>

                    <!-- Footer Area -->
                    <div style='padding: 40px; background-color: #070404; border-top: 1px solid rgba(245, 222, 179, 0.05);'>
                        <p style='font-size: 9px; letter-spacing: 3px; color: rgba(245, 222, 179, 0.3); text-transform: uppercase; margin: 0;'>
                            The Roastery Private Selection | Est. 2025
                        </p>
                    </div>
                </div>
                
                <!-- Outer Footer -->
                <div style='margin-top: 40px; font-size: 10px; color: rgba(245, 222, 179, 0.2); letter-spacing: 1px;'>
                    Sudirman Tower, LV 25, Jakarta <br>
                    <a href='mailto:concierge@coffeetime.id' style='color: rgba(245, 222, 179, 0.4); text-decoration: none;'>concierge@coffeetime.id</a>
                </div>
            </div>
            ";

            $email->setMessage($message);

            if ($email->send()) {
                return $this->response->setJSON(['success' => true, 'message' => 'Instruksi pemulihan telah dikirim ke email Anda.']);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Gagal mengirim email. Periksa pengaturan SMTP.']);
            }
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Alamat email tidak terdaftar dalam catatan kami.']);
    }

    // ==========================================
    // HALAMAN INPUT PASSWORD BARU
    // ==========================================
    public function reset_password($token)
    {
        $userModel = new UserModel();
        
        $user = $userModel->where('reset_token', $token)
                        ->where('reset_expires_at >', date('Y-m-d H:i:s'))
                        ->first();

        if (!$user) {
            // Panggil view error dengan desain mewah
            return view('auth/token_expired');
        }

        return view('auth/reset_password', ['token' => $token]);
    }

    // ==========================================
    // PROSES UPDATE PASSWORD BARU
    // ==========================================
    public function process_reset()
    {
        $token = $this->request->getPost('token');
        $password = $this->request->getPost('password');
        $confirm  = $this->request->getPost('confirm_password');

        if ($password !== $confirm) {
            return redirect()->back()->with('error', 'Konfirmasi password tidak cocok.');
        }

        $userModel = new UserModel();
        $user = $userModel->where('reset_token', $token)->first();

        if ($user) {
            $userModel->update($user['id'], [
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'reset_token' => null, // Hapus token setelah dipakai
                'reset_expires_at' => null
            ]);
            return redirect()->to('auth/login')->with('success', 'Password berhasil diperbarui. Silakan login kembali.');
        }

        return redirect()->back()->with('error', 'Terjadi kesalahan sistem yang tidak terduga.');
    }
}
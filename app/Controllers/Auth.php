<?php

namespace App\Controllers;

use App\Models\Model_Auth;
use Config\Services; // Tambahkan ini


class Auth extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->Model_Auth = new Model_Auth();
        $this->email = Services::email();
    }

    public function register()
{
    if (!session()->get('logged_in')) {
        return redirect()->to('/auth/login')->with('error', 'Anda harus login terlebih dahulu.');
    }

    // Your register logic here...
    return view('register_view');
}

public function save_register()
{
    if (!session()->get('logged_in')) {
        return redirect()->to('/auth/login')->with('error', 'Anda harus login terlebih dahulu.');
    }

    if (!$this->validate([
        'username' => [
            'label' => 'Username',
            'rules' => 'required|is_unique[user.username]',
            'errors' => [
                'required' => '{field} wajib diisi',
                'is_unique' => '{field} sudah digunakan',
            ],
        ],
        'email' => [
            'label' => 'Email',
            'rules' => 'required|valid_email|is_unique[user.email]',
            'errors' => [
                'required' => '{field} wajib diisi',
                'valid_email' => '{field} harus berupa email yang valid',
                'is_unique' => '{field} sudah digunakan',
            ],
        ],
        'password' => [
            'label' => 'Password',
            'rules' => 'required|min_length[6]',
            'errors' => [
                'required' => '{field} wajib diisi',
                'min_length' => '{field} harus memiliki minimal 6 karakter',
            ],
        ],
        'confirm_password' => [
            'label' => 'Konfirmasi Password',
            'rules' => 'required|matches[password]',
            'errors' => [
                'required' => '{field} wajib diisi',
                'matches' => '{field} tidak cocok dengan Password',
            ],
        ],
        'role' => [
            'label' => 'Role',
            'rules' => 'required|in_list[admin,user]', // 🔥 Pastikan role hanya bisa admin atau user
            'errors' => [
                'required' => '{field} wajib dipilih',
                'in_list' => '{field} harus berupa Admin atau User',
            ],
        ],
    ])) {
        session()->setFlashdata('error', $this->validator->getErrors());
        return redirect()->to(base_url('auth/register'))->withInput();
    }

    // **🔹 Pastikan Role Tidak Kosong**
    $role = $this->request->getPost('role');
    if ($role !== 'admin' && $role !== 'user') {
        session()->setFlashdata('error', 'Role tidak valid!');
        return redirect()->to(base_url('auth/register'))->withInput();
    }

    // 🔥 Simpan data ke database dengan role yang benar
    $data = [
        'username' => $this->request->getPost('username'),
        'email' => $this->request->getPost('email'),
        'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        'role' => $role,
    ];

    $this->Model_Auth->save_register($data);

    session()->setFlashdata('pesan', 'User berhasil ditambahkan sebagai ' . ucfirst($role) . '!');
    return redirect()->to(base_url('auth/register'));
}

    

    public function login()
    {
        $data = ['title' => 'login'];
        return view('login_view', $data);
    }

    public function cek_login()
    {
        if (!$this->validate([
            'username_or_email' => ['label' => 'Username atau Email', 'rules' => 'required'],
            'password' => ['label' => 'Password', 'rules' => 'required'],
        ])) {
            session()->setFlashdata('error_message', 'Harap isi semua kolom.');
            return redirect()->to(base_url('auth/login'))->withInput();
        }
    
        $usernameOrEmail = $this->request->getPost('username_or_email');
        $password = $this->request->getPost('password');
    
        $user = $this->Model_Auth->login($usernameOrEmail);
    
        if (!$user) {
            session()->setFlashdata('error_message', 'Username atau Email tidak ditemukan.');
            return redirect()->to(base_url('auth/login'))->withInput();
        }
    
        if (!password_verify($password, $user['password'])) {
            session()->setFlashdata('error_message', 'Password yang Anda masukkan salah.');
            return redirect()->to(base_url('auth/login'))->withInput();
        }
    
        session()->set([
            'logged_in' => true,
            'username' => $user['username'],
            'email' => $user['email'],
            'role' => $user['role'], // Simpan role dalam sesi
            'user_id' => $user['id'],
        ]);
    
        session()->setFlashdata('success_message', 'Login berhasil! Selamat datang, ' . $user['username'] . '.');
        return redirect()->to(base_url('AnggaranController'));
    }
    

    

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth/login')->with('success', 'Anda telah berhasil logout.');
    }

    // ==========================================================
    // ================ GANTI PASSWORD SECTION ==================
    // ==========================================================

    /**
     * Menampilkan form ganti password
     */
    public function ganti_password()
    {
        // Pastikan user sudah login
        if (!session()->get('logged_in')) {
            // Jika belum login, redirect ke login
            return redirect()->to('/auth/login')->with('pesan', 'Silakan login terlebih dahulu.');
        }

        $data = [
            'title' => 'Ganti Password',
        ];
        return view('ganti_password_view', $data);
    }

    /**
     * Menerima input form dan melakukan update password
     */
    public function update_password()
    {
        // Validasi input
        if (!$this->validate([
            'password_lama' => [
                'label' => 'Password Lama',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} wajib diisi',
                ],
            ],
            'password_baru' => [
                'label' => 'Password Baru',
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => '{field} wajib diisi',
                    'min_length' => '{field} harus memiliki minimal 6 karakter',
                ],
            ],
            'konfirmasi_password' => [
                'label' => 'Konfirmasi Password',
                'rules' => 'required|matches[password_baru]',
                'errors' => [
                    'required' => '{field} wajib diisi',
                    'matches' => '{field} tidak cocok dengan Password Baru',
                ],
            ],
        ])) {
            // Jika validasi gagal, kirim error ke session
            session()->setFlashdata('error', $this->validator->getErrors());
            return redirect()->to(base_url('auth/ganti_password'))->withInput();
        }
    
        // Proses penggantian password jika validasi sukses
        $password_lama = $this->request->getPost('password_lama');
        $password_baru = $this->request->getPost('password_baru');
    
        // Ambil data user dari session
        $username = session()->get('username');
        $user = $this->Model_Auth->login($username);
    
        // Verifikasi password lama
        if (!password_verify($password_lama, $user['password'])) {
            session()->setFlashdata('error', 'Password lama salah.');
            return redirect()->to(base_url('auth/ganti_password'))->withInput();
        }
    
        // Hash password baru dan update di database
        $hashedPassword = password_hash($password_baru, PASSWORD_DEFAULT);
        $this->Model_Auth->update_password($username, $hashedPassword);
    
        session()->setFlashdata('success', 'Password berhasil diubah!');
        return redirect()->to(base_url('auth/ganti_password'));
    }

    
   public function lupa_password()
    {
        return view('lupa_password_view', ['title' => 'Lupa Password']);
    }

    public function proses_lupa_password()
{
    // Validasi input email
    if (!$this->validate([
        'email' => [
            'label' => 'Email',
            'rules' => 'required|valid_email',
            'errors' => [
                'required' => '{field} wajib diisi',
                'valid_email' => '{field} harus berupa email yang valid',
            ],
        ],
    ])) {
        session()->setFlashdata('error', $this->validator->getErrors());
        return redirect()->to(base_url('auth/lupa_password'))->withInput();
    }

    // Ambil email dari input
    $email = $this->request->getPost('email');
    $user = $this->Model_Auth->where('email', $email)->first();

    // Jika email tidak ditemukan
    if (!$user) {
        session()->setFlashdata('error', 'Email tidak terdaftar.');
        return redirect()->to(base_url('auth/lupa_password'))->withInput();
    }

    // Generate token reset password
    $token = bin2hex(random_bytes(32));
    $this->Model_Auth->save_reset_token($email, $token);

    // Link untuk reset password
    $resetLink = base_url("auth/reset_password/$token");

    // Konfigurasi email service
    $emailService = \Config\Services::email();
    $emailService->setTo($email); // 🟢 **Pastikan di sini email user benar!**
    $emailService->setFrom('yourapp@gmail.com', 'Your App Name'); // 🛑 Gunakan email aplikasi, bukan user
    $emailService->setSubject('Reset Password');
    $emailService->setMessage("Klik link berikut untuk reset password Anda: <a href='$resetLink'>$resetLink</a>");

    // Kirim email
    if ($emailService->send()) {
        session()->setFlashdata('success', 'Link reset password telah dikirim ke email Anda.');
    } else {
        // Jika gagal kirim email, tampilkan error debugging
        session()->setFlashdata('error', 'Gagal mengirim email reset password.');
        dd($emailService->printDebugger(['headers']));
    }

    return redirect()->to(base_url('auth/lupa_password'));
}


    public function reset_password($token)
    {
        // Cek apakah token valid
        $user = $this->Model_Auth->get_reset_token($token);

        if (!$user) {
            session()->setFlashdata('error', 'Token tidak valid atau sudah kedaluwarsa.');
            return redirect()->to(base_url('auth/lupa_password'));
        }

        $data = [
            'title' => 'Reset Password',
            'token' => $token,
        ];

        return view('reset_password_view', $data);
    }

    public function update_reset_password()
    {
        if (!$this->validate([
            'password' => [
                'label' => 'Password Baru',
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'Password baru wajib diisi.',
                    'min_length' => 'Password minimal harus 6 karakter.',
                ],
            ],
            'confirm_password' => [
                'label' => 'Konfirmasi Password',
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Konfirmasi password wajib diisi.',
                    'matches' => 'Konfirmasi password tidak cocok.',
                ],
            ],
        ])) {
            session()->setFlashdata('error', $this->validator->getErrors());
            return redirect()->back()->withInput();
        }

        $token = $this->request->getPost('token');
        $password = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

        if ($this->Model_Auth->update_password_by_token($token, $password)) {
            session()->setFlashdata('success', 'Password berhasil diubah. Silakan login.');
            return redirect()->to(base_url('auth/login'));
        } else {
            session()->setFlashdata('error', 'Token tidak valid atau sudah kedaluwarsa.');
            return redirect()->to(base_url('auth/lupa_password'));
        }
    }


    
}

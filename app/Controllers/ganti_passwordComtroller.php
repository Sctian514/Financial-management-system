<?php

namespace App\Controllers;

use App\Models\UserModel; // model untuk tabel user
use CodeIgniter\Controller;

class Auth extends Controller
{
    public function ganti_password()
    {
        // Tampilkan form ganti password (GET)
        return view('auth/ganti_password');
    }

    public function update_password()
    {
        $request = service('request');

        // Tangkap data dari form
        $oldPassword    = $request->getPost('old_password');
        $newPassword    = $request->getPost('new_password');
        $confirmNewPass = $request->getPost('confirm_new_password');

        // Validasi sederhana
        if (empty($oldPassword) || empty($newPassword) || empty($confirmNewPass)) {
            return redirect()->back()->with('error', 'Semua kolom harus diisi.');
        }

        if ($newPassword !== $confirmNewPass) {
            return redirect()->back()->with('error', 'Konfirmasi password baru tidak cocok.');
        }

        // Misal ambil user yang sedang login, contohnya:
        $session = session();
        $userId  = $session->get('user_id'); // pastikan Anda punya sistem login
        if (empty($userId)) {
            return redirect()->to('/auth/login')->with('error', 'Anda belum login.');
        }

        // Cek di database
        $userModel = new UserModel();
        $userData  = $userModel->find($userId);

        // Verifikasi password lama
        // Asumsi password disimpan dalam bentuk hash (password_hash)
        if (!password_verify($oldPassword, $userData['password'])) {
            return redirect()->back()->with('error', 'Password lama salah.');
        }

        // Simpan password baru (di-hash kembali)
        $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $userModel->update($userId, ['password' => $hashedNewPassword]);

        return redirect()->to('/auth/ganti_password')
                         ->with('success', 'Password berhasil diubah!');
    }
}

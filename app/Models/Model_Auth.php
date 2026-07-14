<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_Auth extends Model
{
    protected $table = 'user'; // Nama tabel di database
    protected $primaryKey = 'id'; // Primary key
    protected $allowedFields = ['username', 'email', 'password', 'reset_token']; // Kolom yang diizinkan untuk diisi
    protected $returnType = 'array'; // Mengembalikan data sebagai array

    /**
     * Fungsi untuk login berdasarkan username atau email
     */
    public function login($usernameOrEmail)
    {
        return $this->where('username', $usernameOrEmail)
                    ->orWhere('email', $usernameOrEmail)
                    ->first();
    }

    /**
     * Fungsi untuk menyimpan data registrasi pengguna
     */
    public function save_register($data)
    {
        return $this->db->table('user')->insert($data);
        return $this->insert($data);
    }

    /**
     * Fungsi untuk memperbarui password pengguna
     */
    public function update_password($username, $hashedPassword)
    {
        return $this->where('username', $username)
                    ->set('password', $hashedPassword)
                    ->update();
    }

    /**
     * Fungsi untuk menyimpan token reset password
     */
    public function save_reset_token($email, $token)
    {
        return $this->where('email', $email)
                    ->set(['reset_token' => $token])
                    ->update();
    }

    public function get_reset_token($token)
    {
        return $this->where('reset_token', $token)->first();
    }

    public function update_password_by_token($token, $password)
    {
        $user = $this->where('reset_token', $token)->first();

        if ($user) {
            return $this->where('reset_token', $token)
                        ->set(['password' => $password, 'reset_token' => null])
                        ->update();
        }

        return false;
    }
}
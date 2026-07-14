<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<style>
    body {
        background: linear-gradient(to right, #6a11cb, #2575fc);
        font-family: 'Poppins', sans-serif;
    }

    .card {
        border-radius: 15px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    }

    .btn-primary {
        background-color: #4e73df;
        border: none;
        transition: 0.3s;
    }

    .btn-primary:hover {
        background-color: #375ac3;
    }

    .form-control {
        border-radius: 50px;
        padding: 12px;
        font-size: 14px;
        color: #333;
    }

    .form-control:focus {
        box-shadow: none;
        border-color: #4e73df;
    }

    .input-group-text {
        background-color: #4e73df;
        color: white;
        border-radius: 50px 0 0 50px;
    }

    /* Perbaikan Dropdown */
    select.form-control {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        padding: 12px 15px; /* Padding lebih besar agar sejajar */
        font-size: 14px; /* Ukuran teks lebih kecil agar tidak terpotong */
        height: 48px; /* Tinggi dropdown disesuaikan dengan input lain */
        cursor: pointer;
        color: #999; /* Warna default sebelum dipilih */
        border-radius: 50px;
    }

    select.form-control:focus {
        color: #333; /* Warna teks setelah dipilih */
        border-color: #4e73df;
    }

    select.form-control option {
        color: #333; /* Warna teks pilihan */
    }

    /* Tambahkan ikon panah dropdown */
    .input-group select {
        background-image: url('data:image/svg+xml;utf8,<svg fill="%234e73df" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20px" height="20px"><path d="M7 10l5 5 5-5z"/></svg>');
        background-repeat: no-repeat;
        background-position: right 15px center;
        background-size: 16px;
    }
</style>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="col-lg-5 col-md-8">
        <div class="card o-hidden border-0 shadow-lg">
            <div class="card-body p-5">
                <div class="text-center">
                    <h2 class="h4 text-gray-900 mb-4">Buat Akun Baru</h2>
                    <p class="mb-4">Silakan isi formulir untuk mendaftar</p>
                </div>

                <!-- Tampilkan error jika ada -->
                <?php $errors = session()->getFlashdata('error') ?>
                <?php if ($errors && is_array($errors)) : ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errors as $error) : ?>
                            <p><?= esc($error) ?></p>
                        <?php endforeach ?>
                    </div>
                <?php endif; ?>

                <!-- Tampilkan pesan sukses -->
                <?php if (session()->getFlashdata('pesan')) : ?>
                    <div class="alert alert-success">
                        <?= session()->getFlashdata('pesan'); ?>
                    </div>
                <?php endif; ?>

                <!-- Form Register -->
                <form class="user" action="<?= base_url('auth/save_register') ?>" method="POST">
                    <?= csrf_field(); ?>

                    <div class="form-group mb-3">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-user"></i>
                            </span>
                            <input type="text" name="username" class="form-control" placeholder="Masukkan Username" required>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" name="email" class="form-control" placeholder="Masukkan Email" required>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" name="password" class="form-control" placeholder="Masukkan Password" required>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" name="confirm_password" class="form-control" placeholder="Konfirmasi Password" required>
                        </div>
                    </div>

                    <!-- Dropdown Role dengan Ikon -->
                    <div class="form-group mb-3">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-user-tag"></i>
                            </span>
                            <select name="role" class="form-control" required>
                                <option value="" disabled selected>Pilih Role</option>
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                    </div>

                    <button class="btn btn-primary btn-user btn-block" type="submit">Buat Akun</button>
                </form>

                <hr>
                <div class="text-center">
                    <a href="<?= base_url('AnggaranController') ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Font Awesome for Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<?= $this->endSection(); ?>

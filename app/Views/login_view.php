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
        padding: 15px;
        font-size: 16px;
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

    .alert {
        padding: 12px;
        border-radius: 10px;
        text-align: center;
        font-weight: 500;
        transition: all 0.5s ease-in-out;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
</style>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="col-lg-5 col-md-8">
        <div class="card o-hidden border-0 shadow-lg">
            <div class="card-body p-5">

                <!-- Menampilkan Pesan Error/Sukses -->
                <?php if (session()->getFlashdata('error_message')): ?>
                    <div class="alert alert-danger" id="alert-message">
                        <?= session()->getFlashdata('error_message') ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('success_message')): ?>
                    <div class="alert alert-success" id="alert-message">
                        <?= session()->getFlashdata('success_message') ?>
                    </div>
                <?php endif; ?>

                <div class="text-center">
                    <h2 class="h4 text-gray-900 mb-4">Welcome Back!</h2>
                    <p class="mb-4">Masukkan kredensial Anda untuk mengakses akun.</p>
                </div>

                <!-- Form Login -->
                <form class="user" action="<?= base_url('auth/cek_login') ?>" method="POST">
                    <?= csrf_field(); ?>

                    <div class="form-group mb-3">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-user"></i>
                            </span>
                            <input type="text" name="username_or_email" class="form-control" placeholder="Masukkan Username atau Email" required>
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

                    <button class="btn btn-primary btn-user btn-block" type="submit">Login</button>
                </form>

                <hr>
                <div class="text-center">
                    <a class="small" href="<?= base_url('auth/lupa_password') ?>">Lupa Password?</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Font Awesome for Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<!-- Script untuk menghilangkan alert setelah 5 detik -->
<script>
    setTimeout(function() {
        var alert = document.getElementById('alert-message');
        if (alert) {
            alert.style.opacity = '0';
            setTimeout(function() {
                alert.style.display = 'none';
            }, 500);
        }
    }, 5000);
</script>

<?= $this->endSection(); ?>

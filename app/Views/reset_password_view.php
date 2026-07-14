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
</style>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="col-lg-5 col-md-8">
        <div class="card o-hidden border-0 shadow-lg">
            <div class="card-body p-5">
                <div class="text-center">
                    <h2 class="h4 text-gray-900 mb-4">Reset Password</h2>
                    <p class="mb-4">Masukkan password baru Anda untuk mengatur ulang akun.</p>
                </div>

                <!-- Tampilkan error jika ada -->
                <?php if (session()->getFlashdata('error')) : ?>
                    <div class="alert alert-danger">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <!-- Form Reset Password -->
                <form class="user" action="<?= base_url('auth/update_reset_password') ?>" method="post">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="token" value="<?= $token ?>">

                    <div class="form-group mb-3">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" name="password" class="form-control" placeholder="Masukkan Password Baru" required>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" name="confirm_password" class="form-control" placeholder="Konfirmasi Password Baru" required>
                        </div>
                    </div>

                    <button class="btn btn-primary btn-user btn-block" type="submit">Reset Password</button>
                </form>

                <hr>
                <div class="text-center">
                    <a class="small" href="<?= base_url('auth/login') ?>">Kembali ke Login</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->extend('dashboard/index'); ?>

<?= $this->section('content'); ?>

<!-- Custom Styles -->
<style>
    body {
        background: linear-gradient(to right, #4e73df, #224abe);
        font-family: 'Poppins', sans-serif;
    }

    .container-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
        max-width: 500px;
        margin: auto;
    }

    .btn {
        border-radius: 50px;
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
    }

    .form-control {
        border-radius: 10px;
        padding: 12px;
        font-size: 14px;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .alert {
        border-radius: 10px;
        font-size: 14px;
    }
</style>

<div class="container my-5">
    <div class="container-card">
        <h2 class="text-center text-primary">Ganti Password</h2>
        <p class="text-center text-muted">Silakan masukkan password lama dan buat password baru.</p>

        <!-- Pesan Error -->
        <?php if (session()->has('error')): ?>
            <div class="alert alert-danger">
                <strong><i class="fas fa-exclamation-triangle"></i> Error:</strong>
                <ul>
                    <?php 
                    $errors = session('error');
                    if (is_array($errors)) {
                        foreach ($errors as $err) {
                            echo "<li>$err</li>";
                        }
                    } else {
                        echo "<li>$errors</li>";
                    }
                    ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Pesan Sukses -->
        <?php if (session()->has('success')): ?>
            <div class="alert alert-success">
                <strong><i class="fas fa-check-circle"></i> Berhasil!</strong> <?= session('success') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('auth/update_password') ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="password_lama" class="form-label">Password Lama</label>
                <input type="password" name="password_lama" id="password_lama" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password_baru" class="form-label">Password Baru</label>
                <input type="password" name="password_baru" id="password_baru" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="konfirmasi_password" class="form-label">Konfirmasi Password Baru</label>
                <input type="password" name="konfirmasi_password" id="konfirmasi_password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success w-100"><i class="fas fa-lock"></i> Ubah Password</button>
            <a href="<?= base_url('AnggaranController') ?>" class="btn btn-secondary w-100 mt-2"><i class="fas fa-arrow-left"></i> Kembali</a>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->extend('dashboard/index'); ?>

<?= $this->section('content'); ?>

<style>
    body {
        background: linear-gradient(to right, #4e73df, #224abe);
        font-family: 'Poppins', sans-serif;
    }

    .container-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        max-width: 600px;
        margin: auto;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
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
        border: 2px solid #ced4da;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #4e73df;
        box-shadow: 0px 0px 8px rgba(78, 115, 223, 0.5);
    }

    .input-group-text {
        background: #4e73df;
        color: white;
        border-radius: 10px;
    }
</style>

<div class="container my-5">
    <div class="container-card">
        <h2 class="text-center text-primary"><?= $title ?></h2>
        <p class="text-center text-muted">Silakan tambahkan sub kegiatan baru.</p>

        <!-- Pesan error jika ada -->
        <?php if (session()->has('error')): ?>
            <div class="alert alert-danger text-center">
                <?= session('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= route_to('kegiatan.store') ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-4">
                <label for="subKegiatan" class="form-label fw-bold">Sub Kegiatan</label>
                <input
                    type="text"
                    name="subKegiatan"
                    id="subKegiatan"
                    class="form-control"
                    placeholder="Masukkan nama sub kegiatan"
                    required>
            </div>

            <!-- hidden param idAnggaran -->
            <input type="hidden" name="idAnggaran" value="<?= $idAnggaran ?>">

            <div class="text-center">
                <button type="submit" class="btn btn-success w-50"><i class="fas fa-save"></i> Simpan</button>
                <a href="<?= base_url('kegiatan/' . $idAnggaran) ?>" class="btn btn-secondary w-50">
                    <i class="fas fa-arrow-left"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?= $this->endSection(); ?>

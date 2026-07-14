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
        <p class="text-center text-muted">Silakan perbarui informasi sub kegiatan.</p>

        <form action="<?= route_to('kegiatan.update') ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="idSubKegiatan" value="<?= $kegiatanData->idSubKegiatan ?>">
            <input type="hidden" name="idAnggaran" value="<?= $kegiatanData->idAnggaran ?>">

            <div class="mb-4">
                <label for="subKegiatan" class="form-label fw-bold">Sub Kegiatan</label>
                <input
                    type="text"
                    name="subKegiatan"
                    id="subKegiatan"
                    value="<?= $kegiatanData->subKegiatan ?>"
                    class="form-control">
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-success w-50"><i class="fas fa-save"></i> Update</button>
                <a href="<?= base_url('kegiatan/' . $kegiatanData->idAnggaran) ?>" class="btn btn-secondary w-50">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?= $this->endSection(); ?>

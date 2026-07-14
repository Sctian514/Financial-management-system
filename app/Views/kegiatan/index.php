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

    .table {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
    }

    .table thead {
        background: #4e73df;
        color: white;
    }

    .table tbody tr:hover {
        background: rgba(78, 115, 223, 0.1);
    }
</style>

<div class="container-fluid my-5">
    <div class="container-card">
        <h2 class="text-center text-primary"><?= $title ?></h2>
        <p class="text-center text-muted">Kelola daftar sub kegiatan di sini.</p>

        <!-- Pesan Flash -->
        <?php if (session()->has('success')): ?>
            <div class="alert alert-success text-center"><?= session('success') ?></div>
        <?php endif; ?>
        <?php if (session()->has('error')): ?>
            <div class="alert alert-danger text-center"><?= session('error') ?></div>
        <?php endif; ?>

        <div class="text-end mb-3">
            <a href="<?= base_url('kegiatan/create/' . $idAnggaran) ?>" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Kegiatan
            </a>
        </div>

        <!-- Form Pencarian -->
        <form action="<?= route_to('kegiatan.search', $idAnggaran) ?>" method="get" class="row g-3 mb-4">
            <div class="col-md-6">
                <input type="text" name="subKegiatan" class="form-control" placeholder="Cari Sub Kegiatan..." value="<?= $subKegiatan ?? '' ?>">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-success w-100"><i class="fas fa-search"></i> Cari</button>
            </div>
            <div class="col-md-3">
                <a href="<?= base_url('kegiatan/' . $idAnggaran) ?>" class="btn btn-secondary w-100"><i class="fas fa-sync"></i> Reset</a>
            </div>
        </form>

        <!-- Tabel Data -->
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr class="text-center">
                        <th>Sub Kegiatan</th>
                        <th>Realisasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($results)): ?>
                        <?php foreach ($results as $row): ?>
                            <tr class="text-center">
                                <td>
                                    <a href="<?= base_url('rincian/' . $row->idSubKegiatan) ?>" class="text-decoration-none text-primary">
                                        <?= $row->subKegiatan ?>
                                    </a>
                                </td>
                                <td><?= $row->realisasi ?></td>
                                <td>
                                    <a href="<?= route_to('kegiatan.edit', $row->idSubKegiatan) ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="<?= route_to('kegiatan.delete', $row->idSubKegiatan) ?>"
                                        onclick="return confirm('Yakin hapus data?');"
                                        class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center text-danger">Tidak ada data</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="text-center mt-4">
            <a href="<?= base_url('AnggaranController') ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?= $this->endSection(); ?>
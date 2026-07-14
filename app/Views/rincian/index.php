<?= $this->extend('dashboard/index'); ?>

<?= $this->section('content'); ?>

<!-- Custom CSS -->
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
</style>

<div class="container my-5">
    <div class="container-card">
        <h2 class="text-center text-primary"><?= $title ?></h2>

        <!-- Pesan Flash -->
        <?php if (session()->has('success')): ?>
            <div class="alert alert-success text-center"><?= session('success') ?></div>
        <?php endif; ?>
        <?php if (session()->has('error')): ?>
            <div class="alert alert-danger text-center"><?= session('error') ?></div>
        <?php endif; ?>

        <!-- Tombol Tambah -->
        <div class="text-end mb-3">
            <a href="<?= base_url('rincian/create/' . $idSubKegiatan) ?>" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Rincian
            </a>
        </div>

        <!-- Form Pencarian -->
        <form action="<?= route_to('rincian.search', $idSubKegiatan) ?>" method="get" class="row g-3 mb-4">
            <div class="col-md-5">
                <input type="text" name="keyword" class="form-control" placeholder="Cari No SPM..." value="<?= $keyword ?? '' ?>">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-success w-100"><i class="fas fa-search"></i> Cari</button>
            </div>
            <div class="col-md-3">
                <a href="<?= base_url('rincian/' . $idSubKegiatan) ?>" class="btn btn-secondary w-100"><i class="fas fa-sync"></i> Reset</a>
            </div>
        </form>

        <!-- Tabel Data -->
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr class="text-center">
                        <th>No SPM</th>
                        <th>Kode Rekening</th>
                        <th>Nilai</th>
                        <th>PPN</th>
                        <th>PPH</th>
                        <th>NTPN</th>
                        <th>E-Faktur</th>
                        <th>Keterangan</th>
                        <th>Waktu Kegiatan</th>
                        <th>Terakhir Diedit</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($results)): ?>
                        <?php foreach ($results as $row): ?>
                            <tr class="text-center">
                                <td><?= $row->noSPM ?></td>
                                <td><?= $row->kodeRekening ?></td>
                                <td><?= $row->nilai ?></td>
                                <td><?= $row->ppn ?></td>
                                <td><?= $row->pph ?></td>
                                <td><?= $row->ntpn ?></td>
                                <td><?= $row->{'e-faktur'} ?></td>
                                <td><?= $row->keterangan ?></td>
                                <td><?= $row->waktuKegiatan ?></td>
                                <td><?= isset($row->updated_at) ? date('d-m-Y H:i:s', strtotime($row->updated_at)) : '-' ?></td>
                                <td>
                                    <a href="<?= route_to('rincian.edit', $row->idRincian) ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="<?= route_to('rincian.delete', $row->idRincian) ?>"
                                       onclick="return confirm('Yakin hapus data?');"
                                       class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="11" class="text-center text-danger">Tidak ada data</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if ($idAnggaran): ?>
            <a href="<?= base_url('kegiatan/' . $idAnggaran) ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Kegiatan
            </a>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?= $this->endSection(); ?>
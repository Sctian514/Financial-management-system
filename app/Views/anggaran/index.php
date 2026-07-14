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

    .modal-content {
        border-radius: 15px;
    }

    /* Responsive Table */
    td {
        word-wrap: break-word;
        white-space: normal;
        max-width: 250px; /* Sesuaikan jika perlu */
    }

    /* Pastikan tombol aksi tetap sejajar */
    .table td:last-child {
        min-width: 200px;
        text-align: center;
    }

    /* Gunakan flexbox untuk tombol aksi */
    .action-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        justify-content: center;
    }

    /* Ukuran tombol agar seragam */
    .action-buttons .btn {
        flex: 1;
        min-width: 80px;
        max-width: 100px;
        text-align: center;
    }
</style>

<div class="container-fluid my-5">
    <div class="container-card">
        <h2 class="text-center text-primary"><?= $title ?></h2>

        <!-- Pesan Flash -->
        <?php if (session()->has('success')): ?>
            <div class="alert alert-success text-center"><?= session('success') ?></div>
        <?php endif; ?>
        <?php if (session()->has('error')): ?>
            <div class="alert alert-danger text-center"><?= session('error') ?></div>
        <?php endif; ?>
        <?php if (!session()->get('logged_in')): ?>
            <?= redirect()->to('/auth/login')->with('error', 'Anda harus login terlebih dahulu.'); ?>
        <?php endif; ?>

        <div class="text-end mb-3">
            <a href="<?= route_to('anggaran.create') ?>" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Anggaran
            </a>
        </div>

        <!-- Form Pencarian -->
        <form action="<?= route_to('anggaran.search') ?>" method="get" class="row g-3 mb-4">
            <div class="col-md-4">
                <input type="text" name="bidang" class="form-control" placeholder="Cari Bidang..." value="<?= $bidang ?? '' ?>">
            </div>
            <div class="col-md-3">
                <input type="text" name="tahun" class="form-control" placeholder="Tahun (YYYY)" value="<?= $tahun ?? '' ?>">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-success w-100"><i class="fas fa-search"></i> Cari</button>
            </div>
            <div class="col-md-2">
                <a href="<?= base_url('AnggaranController') ?>" class="btn btn-secondary w-100"><i class="fas fa-sync"></i> Reset</a>
            </div>
        </form>

        <!-- Tabel Data -->
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr class="text-center">
                        <th>Bidang</th>
                        <th>Anggaran</th>
                        <th>Tahun</th>
                        <th>Realisasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($results)): ?>
                        <?php foreach ($results as $row): ?>
                            <tr class="text-center">
                                <td><?= $row->Bidang ?></td>
                                <td>
                                    <a href="<?= base_url('kegiatan/' . $row->idAnggaran) ?>" class="text-decoration-none text-primary">
                                        <strong><?= $row->Anggaran ?></strong>
                                    </a>
                                </td>
                                <td><?= $row->Tahun ?></td>
                                <td><?= $row->realisasi ?></td>
                                <td>
                                    <a href="<?= route_to('anggaran.edit', $row->idAnggaran) ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="<?= route_to('anggaran.delete', $row->idAnggaran) ?>"
                                        onclick="return confirm('Yakin hapus data?');"
                                        class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </a>
                                    <button class="btn btn-info btn-sm btn-laporan" data-id="<?= $row->idAnggaran ?>" data-bs-toggle="modal" data-bs-target="#laporanModal">
                                        <i class="fas fa-chart-bar"></i> Grafik
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-danger">Tidak ada data</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Laporan -->
<div class="modal fade" id="laporanModal" tabindex="-1" aria-labelledby="laporanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="laporanModalLabel">Laporan Realisasi SubKegiatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <canvas id="laporanChart" width="400" height="200"></canvas>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-close-modal" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Script -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let laporanChart;
        document.querySelectorAll('.btn-laporan').forEach(button => {
            button.addEventListener('click', function() {
                const idAnggaran = this.getAttribute('data-id');
                fetch(`<?= base_url('AnggaranController/laporan/') ?>/${idAnggaran}`)
                    .then(response => response.json())
                    .then(data => {
                        const ctx = document.getElementById('laporanChart').getContext('2d');

                        if (laporanChart) {
                            laporanChart.destroy();
                        }

                        laporanChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: data.labels,
                                datasets: [{
                                    label: 'Realisasi',
                                    data: data.data,
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });

                        const modal = new bootstrap.Modal(document.getElementById('laporanModal'));
                        modal.show();
                    })
                    .catch(error => {
                        console.error('Error fetching laporan:', error);
                    });
            });
        });

        // Kembali ke halaman anggaran setelah modal ditutup
        document.getElementById('laporanModal').addEventListener('hidden.bs.modal', function() {
            window.location.href = '<?= base_url('AnggaranController') ?>';
        });

    });
</script>

<?= $this->endSection(); ?>
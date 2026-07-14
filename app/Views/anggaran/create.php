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

    .btn {
        border-radius: 50px;
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
    }
</style>

<div class="container my-5">
    <div class="container-card">
        <h2 class="text-center text-primary"><?= $title ?></h2>

        <!-- Tampilkan error jika ada -->
        <?php if (session()->has('error')): ?>
            <div class="alert alert-danger text-center">
                <?= session('error') ?>
            </div>
        <?php endif; ?>

        <!-- Form Input -->
        <form action="<?= route_to('anggaran.store') ?>" method="post" id="anggaranForm">
            <?= csrf_field() ?>

            <!-- Bidang -->
            <div class="mb-3">
                <label for="Bidang" class="form-label">Bidang Urusan</label>
                <input type="text" name="Bidang" id="Bidang" class="form-control" placeholder="Masukkan Bidang Anggaran" required>
            </div>

            <!-- Anggaran -->
            <div class="mb-3">
                <label for="Anggaran" class="form-label">Jumlah Anggaran (Rp)</label>
                <input type="text" name="Anggaran" id="Anggaran" class="form-control" placeholder="Masukkan jumlah anggaran" required>
            </div>

            <!-- Tahun -->
            <div class="mb-3">
                <label for="Tahun" class="form-label">Tahun</label>
                <input type="text" name="Tahun" id="Tahun" class="form-control yearpicker" placeholder="Pilih Tahun" readonly required>
            </div>

            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-success mx-2">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="<?= base_url('AnggaranController') ?>" class="btn btn-secondary mx-2">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

<!-- jQuery & Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Bootstrap Datepicker JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<!-- Bootstrap Datepicker CSS -->
<link 
    rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

<script>
    $(document).ready(function () {
        // Format input anggaran dengan pemisah ribuan
        $('#Anggaran').on('input', function () {
            var inputVal = $(this).val().replace(/[^\d]/g, ''); // Hapus semua karakter non-digit
            var formattedVal = inputVal.replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // Format angka dengan titik

            $(this).val(formattedVal);
        });

        // Datepicker untuk tahun
        $('.yearpicker').datepicker({
            format: 'yyyy',        // Format hanya tahun
            viewMode: 'years',     // Mulai tampilan dengan tahun
            minViewMode: 'years',  // Hanya menampilkan pilihan tahun
            autoclose: true        // Tutup otomatis setelah memilih
        });

        // Menghapus tanda titik sebelum submit
        $('#anggaranForm').on('submit', function () {
            var anggaranVal = $('#Anggaran').val();
            var cleanAnggaran = anggaranVal.replace(/\./g, ''); // Hapus semua titik
            $('#Anggaran').val(cleanAnggaran); // Set kembali nilai input tanpa titik
        });
    });
</script>

<?= $this->endSection(); ?>

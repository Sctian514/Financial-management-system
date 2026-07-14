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
        max-width: 700px;
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

    .input-group-text {
        background: #4e73df;
        color: white;
        border-radius: 10px;
    }

    .datepicker {
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }
</style>

<div class="container my-5">
    <div class="container-card">
        <h2 class="text-center text-primary"><?= $title ?></h2>

        <?php if (session()->has('error')): ?>
            <div class="alert alert-danger text-center"><?= session('error') ?></div>
        <?php endif; ?>

        <form action="<?= route_to('rincian.store') ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="noSPM" class="form-label">No SPM</label>
                <input type="text" name="noSPM" id="noSPM" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="kodeRekening" class="form-label">Kode Rekening</label>
                <input type="text" name="kodeRekening" id="kodeRekening" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="nilai" class="form-label">Nilai</label>
                <input type="text" name="nilai" id="nilai" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="ppn" class="form-label">PPN</label>
                <input type="text" name="ppn" id="ppn" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="pph" class="form-label">PPH</label>
                <input type="text" name="pph" id="pph" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="ntpn" class="form-label">NTPN</label>
                <input type="text" name="ntpn" id="ntpn" class="form-control">
            </div>

            <div class="mb-3">
                <label for="e_faktur" class="form-label">E-Faktur</label>
                <input type="text" name="e_faktur" id="e_faktur" class="form-control">
            </div>

            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <input type="text" name="keterangan" id="keterangan" class="form-control">
            </div>

            <!-- Waktu Kegiatan -->
            <div class="mb-3">
                <label for="waktuKegiatan" class="form-label">Waktu Kegiatan</label>
                <div class="input-group">
                    <input
                        type="text"
                        name="waktuKegiatan"
                        id="waktuKegiatan"
                        class="form-control datepicker"
                        placeholder="YYYY-MM-DD"
                        readonly>
                    <span class="input-group-text">
                        <i class="bi bi-calendar"></i>
                    </span>
                </div>
            </div>

            <!-- Hidden Parameter -->
            <input type="hidden" name="idSubKegiatan" value="<?= $idSubKegiatan ?>">

            <button type="submit" class="btn btn-success w-100"><i class="fas fa-save"></i> Simpan</button>
            <a href="<?= base_url('rincian/' . $idSubKegiatan) ?>" class="btn btn-secondary w-100 mt-2"><i class="fas fa-arrow-left"></i> Batal</a>
        </form>
    </div>
</div>

<!-- jQuery, Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap Datepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

<script>
    $(document).ready(function () {
        // Format input angka dengan pemisah ribuan (titik)
        function formatRibuan(input) {
            var inputVal = input.value.replace(/[^\d]/g, ''); // Hapus semua karakter non-digit
            var formattedVal = inputVal.replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // Tambahkan titik sebagai pemisah ribuan
            input.value = formattedVal;
        }

        // Terapkan format angka pada kolom Nilai, PPN, dan PPH
        $('#nilai').on('input', function () {
            formatRibuan(this);
        });

        // Format tanggal dengan datepicker
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
            orientation: 'bottom',
            templates: {
                leftArrow: '<i class="bi bi-chevron-left"></i>',
                rightArrow: '<i class="bi bi-chevron-right"></i>'
            }
        });

        // Tampilkan datepicker saat input difokuskan
        $('.datepicker').on('focus', function () {
            $(this).datepicker('show');
        });

        // Bersihkan format angka sebelum submit agar tersimpan sebagai angka
        $('form').on('submit', function () {
            $('#nilai, #ppn, #pph').each(function () {
                $(this).val($(this).val().replace(/\./g, '')); // Hapus semua titik sebelum dikirim ke server
            });
        });
    });
</script>


<?= $this->endSection(); ?>

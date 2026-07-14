<form action="<?= route_to('data.search') ?>" method="get" class="row g-3">
    <!-- Input Bidang -->
    <div class="col-auto">
        <label for="bidang" class="visually-hidden">Bidang</label>
        <input type="text" name="bidang" id="bidang" class="form-control"
            placeholder="Cari Bidang..."
            value="<?= $bidang ?? '' ?>">
    </div>

    <!-- Input Waktu Pelaksanaan (Datepicker) -->
    <div class="col-auto">
        <label for="waktu_pelaksanaan" class="visually-hidden">Waktu Pelaksanaan</label>
        <input type="text" name="waktu_pelaksanaan" id="waktu_pelaksanaan"
            class="form-control" placeholder="yyyy-mm-dd"
            value="<?= $tanggal ?? '' ?>">
    </div>

    <div class="col-auto">
        <button type="submit" class="btn btn-primary">Cari</button>
        <a href="<?= base_url('DataController') ?>" class="btn btn-secondary">Reset</a>
    </div>
</form>
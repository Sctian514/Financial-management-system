<?php

namespace App\Models;

use CodeIgniter\Model;

class RincianModel extends Model
{
    protected $table = 'rincian';
    protected $primaryKey = 'idRincian';
    protected $useTimestamps = true; // Aktifkan timestamp otomatis
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $allowedFields = [
        'noSPM',
        'kodeRekening',
        'nilai',
        'ppn',
        'pph',
        'ntpn',
        'e-faktur',
        'keterangan',
        'waktuKegiatan',
        'idSubKegiatan',
        'created_at',
        'updated_at' // Pastikan ini ada
    ];

    protected $returnType = 'object';

    // Fungsi untuk format Nilai dalam Rupiah
    private function formatRupiah($value)
{
    $value = floatval(str_replace('.', '', $value)); // Hilangkan titik dan ubah ke angka
    return 'Rp.' . number_format($value, 0, ',', '.');
}

private function formatAngka($value)
{
    $value = floatval(str_replace('.', '', $value)); // Pastikan nilai adalah angka
    return number_format($value, 0, ',', '.');
}

    public function searchRincian($idSubKegiatan, $keyword = null)
    {
        $builder = $this->db->table($this->table);
        $builder->where('idSubKegiatan', $idSubKegiatan);

        if (!empty($keyword)) {
            $builder->like('noSPM', $keyword);
        }

        $results = $builder->get()->getResult();

        // Format hanya nilai dengan "Rp.", PPN & PPH tetap angka biasa
        foreach ($results as $row) {
            $row->nilai = $this->formatRupiah($row->nilai);
        }

        return $results;
    }

    public function getRincianBySubKegiatan($idSubKegiatan)
    {
        $results = $this->where('idSubKegiatan', $idSubKegiatan)->findAll();

        // Format hanya nilai dengan "Rp.", PPN & PPH tetap angka biasa
        foreach ($results as $row) {
            $row->nilai = $this->formatRupiah($row->nilai);
        }

        return $results;
    }

    public function updateRincian($id, $data)
    {
        // Tambahkan updated_at saat update
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->update($id, $data);
    }
}
<?php

namespace App\Models;

use CodeIgniter\Model;

class AnggaranModel extends Model
{
    protected $table = 'anggaran';
    protected $primaryKey = 'idAnggaran';
    protected $allowedFields = ['Bidang', 'Anggaran', 'Tahun'];
    protected $returnType = 'object';


    private function formatRupiah($value)
    {
        return 'Rp. ' . number_format($value, 0, ',', '.');
    }

    public function getAnggaranWithRealisasi()
    {
        $builder = $this->db->table('anggaran AS a');
        $builder->select('a.idAnggaran, a.Bidang, a.Anggaran, a.Tahun');
        $builder->select('COALESCE(SUM(r.nilai), 0) AS realisasi');
        $builder->join('kegiatan AS k', 'k.idAnggaran = a.idAnggaran', 'left');
        $builder->join('rincian AS r', 'r.idSubKegiatan = k.idSubKegiatan', 'left');
        $builder->groupBy('a.idAnggaran');

        $query = $builder->get();
        $results = $query->getResult();

        // Format realisasi sebagai "Rp."
        foreach ($results as $row) {
            $row->realisasi = $this->formatRupiah($row->realisasi);
            $row->Anggaran = $this->formatRupiah($row->Anggaran);
        }

        return $results;
    }



    public function searchAnggaran($bidang = null, $tahun = null)
    {
        $builder = $this->db->table('anggaran AS a');
        $builder->select('a.idAnggaran, a.Bidang, a.Anggaran, a.Tahun');
        $builder->select('COALESCE(SUM(r.nilai),0) AS realisasi');

        // Join ke kegiatan
        $builder->join('kegiatan AS k', 'k.idAnggaran=a.idAnggaran', 'left');
        // Join ke rincian
        $builder->join('rincian AS r', 'r.idSubKegiatan=k.idSubKegiatan', 'left');

        if (!empty($bidang)) {
            $builder->like('a.Bidang', $bidang);
        }
        if (!empty($tahun)) {
            $builder->where('a.Tahun', $tahun);
        }

        $builder->groupBy('a.idAnggaran');

        return $builder->get()->getResult();
    }
}

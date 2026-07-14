<?php

namespace App\Models;

use CodeIgniter\Model;

class KegiatanModel extends Model
{
    protected $table = 'kegiatan';
    protected $primaryKey = 'idSubKegiatan';
    protected $allowedFields = [
        'subKegiatan',
        'idAnggaran',
    ];
    protected $returnType = 'object';

    /**
     * Ambil Kegiatan + realisasi (sum nilai), difilter oleh idAnggaran
     */
    private function formatRupiah($value)
    {
        return 'Rp. ' . number_format($value, 0, ',', '.');
    }
    public function getKegiatanWithRealisasi($idAnggaran)
    {
        $builder = $this->db->table('kegiatan AS k');
        $builder->select('k.idSubKegiatan, k.subKegiatan');
        $builder->select('COALESCE(SUM(r.nilai), 0) AS realisasi');
        $builder->join('rincian AS r', 'r.idSubKegiatan = k.idSubKegiatan', 'left');
        $builder->where('k.idAnggaran', $idAnggaran);
        $builder->groupBy('k.idSubKegiatan');


        $query = $builder->get();
        $results = $query->getResult();

        // Format realisasi sebagai "Rp."
        foreach ($results as $row) {
            $row->realisasi = $this->formatRupiah($row->realisasi);
        }

        return $results;
    }



    public function searchKegiatan($idAnggaran, $subKegiatan = null)
    {
        $builder = $this->db->table('kegiatan AS k');
        $builder->select('k.idSubKegiatan, k.subKegiatan');
        $builder->select('COALESCE(SUM(r.nilai),0) AS realisasi');
        $builder->join('rincian AS r', 'r.idSubKegiatan=k.idSubKegiatan', 'left');

        $builder->where('k.idAnggaran', $idAnggaran);

        if (!empty($subKegiatan)) {
            $builder->like('k.subKegiatan', $subKegiatan);
        }

        $builder->groupBy('k.idSubKegiatan');
        return $builder->get()->getResult();
    }
}

<?php

namespace App\Controllers;

use App\Models\AnggaranModel;
use CodeIgniter\Controller;

class AnggaranController extends Controller
{
    public function index()
    {
        $anggaranModel = new AnggaranModel();
        $results = $anggaranModel->getAnggaranWithRealisasi();

        $data = [
            'title'   => 'Data Anggaran',
            'results' => $results
        ];

        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login')->with('error', 'Anda harus login terlebih dahulu.');
        }
        

        return view('anggaran/index', $data);
    }


    public function search()
    {
        $request = service('request');
        $bidang = $request->getVar('bidang');
        $tahun  = $request->getVar('tahun');

        $anggaranModel = new AnggaranModel();
        $results = $anggaranModel->searchAnggaran($bidang, $tahun);

        $data = [
            'title'   => 'Data Anggaran (Hasil Pencarian)',
            'results' => $results,
            'bidang'  => $bidang,
            'tahun'   => $tahun
        ];
        return view('anggaran/index', $data);
    }

    public function create()
    {
        $data = ['title' => 'Tambah Data Anggaran'];
        return view('anggaran/create', $data);
    }

    public function store()
    {
        $request = service('request');

        $postData = [
            'Bidang'   => $request->getPost('Bidang'),
            'Anggaran' => $request->getPost('Anggaran'),
            'Tahun'    => $request->getPost('Tahun')
        ];

        if (empty($postData['Bidang'])) {
            return redirect()->back()->with('error', 'Bidang wajib diisi!');
        }

        $anggaranModel = new AnggaranModel();
        $anggaranModel->insert($postData);

        return redirect()->to(base_url('anggaran'))->with('success', 'Data anggaran berhasil disimpan!');
    }

    public function edit($idAnggaran)
    {
        // Gunakan fungsi decrypt_id() untuk mendekripsi ID

        if (!$idAnggaran) {
            return redirect()->to('/anggaran')->with('error', 'ID tidak valid.');
        }

        $anggaranModel = new AnggaranModel();
        $row = $anggaranModel->find($idAnggaran);

        if (!$row) {
            return redirect()->to('/anggaran')->with('error', 'Data tidak ditemukan');
        }

        $data = [
            'title'        => 'Edit Anggaran',
            'anggaranData' => $row
        ];

        return view('anggaran/edit', $data);
    }


    public function update()
    {
        $idAnggaran = $this->request->getPost('idAnggaran');
        if (!$idAnggaran) {
            return redirect()->back()->with('error', 'ID Anggaran tidak valid');
        }

        $postData = [
            'Bidang'   => $this->request->getPost('Bidang'),
            'Anggaran' => $this->request->getPost('Anggaran'),
            'Tahun'    => $this->request->getPost('Tahun')
        ];

        $anggaranModel = new AnggaranModel();
        $anggaranModel->update($idAnggaran, $postData);

        return redirect()->to(base_url('anggaran'))->with('success', 'Data Anggaran berhasil diupdate!');
    }

    public function delete($idAnggaran)
    {
        $anggaranModel = new AnggaranModel();
        $anggaranModel->delete($idAnggaran);

        return redirect()->to(base_url('AnggaranController'))->with('success', 'Data Anggaran berhasil dihapus!');
    }

    public function laporan($idAnggaran)
    {
        $db = \Config\Database::connect();
        $query = $db->table('kegiatan')
            ->select('subKegiatan, COALESCE(SUM(rincian.nilai), 0) AS realisasi')
            ->join('rincian', 'rincian.idSubKegiatan = kegiatan.idSubKegiatan', 'left')
            ->where('kegiatan.idAnggaran', $idAnggaran)
            ->groupBy('kegiatan.idSubKegiatan')
            ->get();

        $results = $query->getResult();

        $labels = [];
        $data = [];

        foreach ($results as $row) {
            $labels[] = $row->subKegiatan;
            $data[] = $row->realisasi;
        }

        return $this->response->setJSON([
            'labels' => $labels,
            'data'   => $data
        ]);
    }
}

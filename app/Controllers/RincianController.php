<?php

namespace App\Controllers;

use App\Models\RincianModel;
use CodeIgniter\Controller;

class RincianController extends Controller
{
    protected $model;
    public function index($idSubKegiatan)
    {
        $model = new RincianModel();
        // $results = $model->where('idSubKegiatan', $idSubKegiatan)->findAll();
        $results = $model->getRincianBySubKegiatan($idSubKegiatan);
        // Dapatkan koneksi DB (karena $this->db tidak otomatis ada di Controller)
        $db = \Config\Database::connect();

        // Gunakan $db untuk query manual
        $keg = $db->table('kegiatan')
            ->where('idSubKegiatan', $idSubKegiatan)
            ->get()->getRow();
        $idAnggaran = $keg ? $keg->idAnggaran : null;

        $data = [
            'title'         => 'Data Rincian',
            'idSubKegiatan' => $idSubKegiatan,
            'idAnggaran'    => $idAnggaran,
            'results'       => $results
        ];
        return view('rincian/index', $data);
    }



    public function search($idSubKegiatan)
    {
        $db = \Config\Database::connect();
        $keg = $db->table('kegiatan')
            ->where('idSubKegiatan', $idSubKegiatan)
            ->get()->getRow();
        $idAnggaran = $keg ? $keg->idAnggaran : null;

        $keyword = $this->request->getVar('keyword');
        $rincianModel = new RincianModel();
        $results = $rincianModel->searchRincian($idSubKegiatan, $keyword);

        $data = [
            'title'         => 'Data Rincian (Hasil Pencarian)',
            'idSubKegiatan' => $idSubKegiatan,
            'idAnggaran'    => $idAnggaran,
            'results'       => $results,
            'keyword'       => $keyword
        ];
        return view('rincian/index', $data);
    }



    public function create($idSubKegiatan)
    {

        // Validasi
        if (!$idSubKegiatan) {
            return redirect()->to('/error')->with('error', 'ID tidak valid');
        }

        $data = [
            'title' => 'Tambah Rincian',
            'idSubKegiatan' => $idSubKegiatan
        ];

        return view('rincian/create', $data);
    }

    public function store()
    {
        $postData = [
            'noSPM'         => $this->request->getPost('noSPM'),
            'kodeRekening'  => $this->request->getPost('kodeRekening'),
            'nilai'         => $this->request->getPost('nilai'),
            'ppn'           => $this->request->getPost('ppn'),
            'pph'           => $this->request->getPost('pph'),
            'ntpn'          => $this->request->getPost('ntpn'),
            'e-faktur'      => $this->request->getPost('e_faktur'),
            'keterangan'    => $this->request->getPost('keterangan'),
            'waktuKegiatan' => $this->request->getPost('waktuKegiatan'),
            'idSubKegiatan' => $this->request->getPost('idSubKegiatan') // Hanya ini FK
        ];

        $model = new RincianModel();
        $model->insert($postData);

        return redirect()->to(base_url('rincian/' . $postData['idSubKegiatan']))
            ->with('success', 'Data rincian berhasil disimpan!');
    }

    public function edit($idRincian)
    {
        $model = new RincianModel();
        $row = $model->find($idRincian);

        if (!$row) {
            return redirect()->back()->with('error', 'Data rincian tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Rincian',
            'rincianData' => $row
        ];
        return view('rincian/edit', $data);
    }

    public function update()
    {
        $idRincian = $this->request->getPost('idRincian');
        if (!$idRincian) {
            return redirect()->back()->with('error', 'ID rincian tidak valid');
        }

        $postData = [
            'noSPM'         => $this->request->getPost('noSPM'),
            'kodeRekening'  => $this->request->getPost('kodeRekening'),
            'nilai'         => $this->request->getPost('nilai'),
            'ppn'           => $this->request->getPost('ppn'),
            'pph'           => $this->request->getPost('pph'),
            'ntpn'          => $this->request->getPost('ntpn'),
            'e-faktur'      => $this->request->getPost('e_faktur'),
            'keterangan'    => $this->request->getPost('keterangan'),
            'waktuKegiatan' => $this->request->getPost('waktuKegiatan'),
            'idSubKegiatan' => $this->request->getPost('idSubKegiatan')
        ];

        $model = new RincianModel();
        $model->update($idRincian, $postData);

        // Redirect balik ke 'rincian/'.$idSubKegiatan
        return redirect()->to(base_url('rincian/' . $postData['idSubKegiatan']))
            ->with('success', 'Data rincian diupdate!');
    }

    public function delete($idRincian)
    {
        // Perlu cari row untuk tahu idSubKegiatan
        $model = new RincianModel();
        $row = $model->find($idRincian);
        if (!$row) {
            return redirect()->back()->with('error', 'Data rincian tidak ditemukan');
        }
        $idSubKegiatan = $row->idSubKegiatan;

        $model->delete($idRincian);

        return redirect()->to(base_url('rincian/' . $idSubKegiatan))
            ->with('success', 'Data rincian dihapus!');
    }

    private function formatRupiah($value)
    {
        return 'Rp. ' . number_format($value, 0, ',', '.');
    }
}

<?php

namespace App\Controllers;

use App\Models\KegiatanModel;
use CodeIgniter\Controller;

class KegiatanController extends Controller
{
    // Menampilkan kegiatan + realisasi (filter by idAnggaran)
    public function index($idAnggaran)
    {
        $kegiatanModel = new KegiatanModel();
        $results = $kegiatanModel->getKegiatanWithRealisasi($idAnggaran);

        $data = [
            'title'   => 'Data Kegiatan',
            'results' => $results,
            'idAnggaran' => $idAnggaran
        ];
        return view('kegiatan/index', $data);
    }

    // Pencarian subKegiatan (filter idAnggaran)
    public function search($idAnggaran)
    {
        $request = service('request');
        $subKegiatan = $request->getVar('subKegiatan');

        $kegiatanModel = new KegiatanModel();
        $results = $kegiatanModel->searchKegiatan($idAnggaran, $subKegiatan);

        $data = [
            'title'       => 'Data Kegiatan (Hasil Pencarian)',
            'idAnggaran'  => $idAnggaran,
            'results'     => $results,
            'subKegiatan' => $subKegiatan
        ];
        return view('kegiatan/index', $data);
    }

    public function create($idAnggaran)
    {
        $data = [
            'title'      => 'Tambah Data Kegiatan',
            'idAnggaran' => $idAnggaran
        ];
        return view('kegiatan/create', $data);
    }

    // Simpan data kegiatan baru
    public function store()
    {
        // Tangkap input form
        $subKegiatan = $this->request->getPost('subKegiatan');
        $idAnggaran  = $this->request->getPost('idAnggaran');

        // Validasi sederhana
        if (empty($subKegiatan)) {
            return redirect()->back()->with('error', 'subKegiatan wajib diisi!');
        }

        // Buat array lengkap, termasuk idAnggaran
        $postData = [
            'subKegiatan' => $subKegiatan,
            'idAnggaran'  => $idAnggaran
        ];

        // Insert ke DB
        $kegiatanModel = new KegiatanModel();
        $kegiatanModel->insert($postData);

        // Redirect balik
        return redirect()->to(base_url('kegiatan/' . $idAnggaran))
            ->with('success', 'Data Kegiatan berhasil disimpan!');
    }

    public function edit($idSubKegiatan)
    {
        $model = new KegiatanModel();
        $row = $model->find($idSubKegiatan);

        if (!$row) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Kegiatan',
            'kegiatanData' => $row
        ];
        return view('kegiatan/edit', $data);
    }

    public function update()
    {
        $idSubKegiatan = $this->request->getPost('idSubKegiatan');
        if (!$idSubKegiatan) {
            return redirect()->back()->with('error', 'ID subKegiatan tidak valid');
        }

        $postData = [
            'subKegiatan' => $this->request->getPost('subKegiatan'),
            'idAnggaran'  => $this->request->getPost('idAnggaran')
        ];

        $model = new KegiatanModel();
        $model->update($idSubKegiatan, $postData);

        // Balik ke 'kegiatan/$idAnggaran'
        return redirect()->to(base_url('kegiatan/' . $postData['idAnggaran']))
            ->with('success', 'Data Kegiatan berhasil diupdate!');
    }

    public function delete($idSubKegiatan)
    {
        // Sebelum hapus, kita butuh idAnggaran agar redirect
        $model = new KegiatanModel();
        $row = $model->find($idSubKegiatan);
        if (!$row) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }
        $idAnggaran = $row->idAnggaran;

        $model->delete($idSubKegiatan);
        return redirect()->to(base_url('kegiatan/' . $idAnggaran))
            ->with('success', 'Kegiatan berhasil dihapus!');
    }
}

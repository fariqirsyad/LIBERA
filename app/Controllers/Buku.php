<?php

namespace App\Controllers;

use App\Models\BukuModel;

class Buku extends BaseController
{
    protected $bukuModel;

    public function __construct()
    {
        $this->bukuModel = new BukuModel();
    }

    public function index()
    {
        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $buku = $this->bukuModel->search($keyword)->findAll();
        } else {
            $buku = $this->bukuModel->findAll();
        }

        $data = [
            'title' => 'Daftar Buku | Libera',
            'buku'  => $buku
        ];

        return view('buku/index', $data);
    }

    public function create()
    {
        if (session()->get('role') == 'anggota') {
            return redirect()->to('/buku')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        return view('buku/create', ['title' => 'Tambah Buku']);
    }

    public function save()
{
    $fileCover = $this->request->getFile('cover');

    // Cek apakah ada file yang diunggah
    if ($fileCover && $fileCover->isValid() && !$fileCover->hasMoved()) {
        $namaCover = $fileCover->getRandomName();
        // Pindahkan ke public/uploads/cover
        $fileCover->move(FCPATH . 'uploads/cover', $namaCover);
    } else {
        $namaCover = 'jpg'; 
    }

    $this->bukuModel->save([
        'judul'         => $this->request->getVar('judul'),
        'penulis'       => $this->request->getVar('penulis'),
        'stok'          => $this->request->getVar('stok'),
        'denda_perhari' => $this->request->getVar('denda_perhari'),
        'cover'         => $namaCover 
    ]);

    session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
    return redirect()->to('/buku');
}

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Buku',
            'buku'  => $this->bukuModel->find($id)
        ];
        return view('buku/edit', $data);
    }

    public function update($id)
    {
        $bukuLama = $this->bukuModel->find($id);
        $fileCover = $this->request->getFile('cover');

        if ($fileCover->getError() == 4) {
            $namaCover = $bukuLama['cover'];
        } else {
            $namaCover = $fileCover->getRandomName();
            $fileCover->move('uploads/cover', $namaCover);

            // Perbaikan: Cek apakah string tidak kosong dan benar-benar merujuk ke file
            if (!empty($bukuLama['cover']) && $bukuLama['cover'] != 'jpg') {
                $pathFileLama = 'uploads/cover/' . $bukuLama['cover'];
                if (is_file($pathFileLama) && file_exists($pathFileLama)) {
                    unlink($pathFileLama);
                }
            }
        }

        $this->bukuModel->update($id, [
            'judul'         => $this->request->getVar('judul'),
            'penulis'       => $this->request->getVar('penulis'),
            'stok'          => $this->request->getVar('stok'),
            'denda_perhari' => $this->request->getVar('denda_perhari'),
            'cover'         => $namaCover
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah.');
        return redirect()->to('/buku');
    }

   public function delete($id)
{
    // 1. Cari data buku berdasarkan ID
    $buku = $this->bukuModel->find($id);

    // 2. Pastikan data ditemukan untuk menghindari error null object
    if ($buku) {
        $namaFile = $buku['cover'];
        $pathFile = 'uploads/cover/' . $namaFile;

        // 3. Validasi: Nama file tidak boleh kosong, bukan default, dan benar-benar sebuah FILE
        if (!empty($namaFile) && $namaFile != 'jpg') {
            // Cek fisik file dan pastikan bukan direktori (is_file)
            if (file_exists($pathFile) && is_file($pathFile)) {
                unlink($pathFile);
            }
        }
    }

    // 4. Hapus data dari database
    $this->bukuModel->delete($id);
    
    session()->setFlashdata('pesan', 'Data berhasil dihapus.');
    return redirect()->to('/buku');
}
}
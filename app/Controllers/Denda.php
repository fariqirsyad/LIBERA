<?php

namespace App\Controllers;

use App\Models\PeminjamanModel;
use App\Models\DendaModel;

class Denda extends BaseController
{
    protected $peminjamanModel;
    protected $dendaModel;

    public function __construct()
    {
        $this->peminjamanModel = new PeminjamanModel();
        $this->dendaModel = new DendaModel();
    }

    public function index()
    {
        // Jika anggota, hanya lihat denda sendiri. Jika admin/petugas, lihat semua.
        $id_user = (session()->get('role') == 'anggota') ? session()->get('id') : null;
        
        $data = [
            'title' => 'Daftar Tagihan Denda',
            'denda' => $this->dendaModel->getDendaWithDetails($id_user)
        ];

        return view('denda/index', $data);
    }

   public function bayar($id)
{
    $fileBukti = $this->request->getFile('bukti');
    
    if ($fileBukti->isValid() && !$fileBukti->hasMoved()) {
        // Beri nama acak agar tidak bentrok
        $namaFile = $fileBukti->getRandomName();
        $fileBukti->move('img/bukti_bayar/', $namaFile);

        // Update data di database
        $this->dendaModel->update($id, [
            'metode_bayar' => $this->request->getPost('metode_bayar'),
            'bukti'        => $namaFile,
            'status'       => 'menunggu_verifikasi'
        ]);

        return redirect()->to('/denda/saya')->with('pesan', 'Bukti pembayaran berhasil diupload, menunggu verifikasi.');
    }

    return redirect()->back()->with('error', 'Gagal upload file.');
}

    public function verifikasi($id, $status)
    {
        // Hanya untuk admin atau petugas
        $this->dendaModel->update($id, ['status' => $status]);
        return redirect()->back()->with('success', 'Status denda berhasil diperbarui.');
    }

    public function setujui($id)
{
    $this->dendaModel->update($id, ['status' => 'lunas']);
    return redirect()->back()->with('pesan', 'Pembayaran berhasil dikonfirmasi.');
}

public function tolak($id)
{
    // Mengembalikan status agar anggota bisa upload ulang bukti yang benar
    $this->dendaModel->update($id, [
        'status' => 'belum_bayar',
        'bukti'  => null
    ]);
    return redirect()->back()->with('error', 'Pembayaran ditolak.');
}
}
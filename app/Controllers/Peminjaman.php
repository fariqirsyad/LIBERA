<?php

namespace App\Controllers;

use App\Models\PeminjamanModel;
use App\Models\BukuModel;
use DateTime;

class Peminjaman extends BaseController
{
    protected $pinjamModel;
    protected $bukuModel;

    public function __construct()
    {
        // Inisialisasi model di construct agar bisa dipakai di semua method
        $this->pinjamModel = new PeminjamanModel();
        $this->bukuModel = new BukuModel();
    }

    public function index()
    {
        $id_user = session()->get('id');
        $role = session()->get('role');

        // Logika: Admin/Petugas lihat semua, Anggota lihat miliknya saja
        if ($role == 'admin' || $role == 'petugas') {
            $data_pinjam = $this->pinjamModel->getPeminjaman(); 
        } else {
            $data_pinjam = $this->pinjamModel->where('peminjaman.id_user', $id_user)->getPeminjaman(); 
        }

        // --- LOGIKA DENDA OTOMATIS (REAL-TIME) ---
        $tgl_sekarang = new DateTime(date('Y-m-d'));

        foreach ($data_pinjam as &$p) {
            // Jika status masih dipinjam, hitung potensi denda
            if ($p['status'] == 'dipinjam') {
                $tgl_kembali = new DateTime($p['tgl_kembali']);
                
                if ($tgl_sekarang > $tgl_kembali) {
                    $selisih = $tgl_sekarang->diff($tgl_kembali)->days;
                    // Gunakan denda_perhari dari tabel buku, jika tidak ada set default 1000
                    $tarif_denda = $p['denda_perhari'] ?? 1000; 
                    $p['denda'] = $selisih * $tarif_denda;
                } else {
                    $p['denda'] = 0;
                }
            }
        }

        $data = [
            'title'  => 'Data Peminjaman',
            'pinjam' => $data_pinjam
        ];

        return view('peminjaman/index', $data);
    }

    public function tambah($id_buku)
    {
        $buku = $this->bukuModel->find($id_buku);

        if ($buku['stok'] > 0) {
            $this->pinjamModel->save([
                'id_user'     => session()->get('id'), 
                'id_buku'     => $id_buku,
                'tgl_pinjam'  => date('Y-m-d'),
                'tgl_kembali' => date('Y-m-d', strtotime('+2 days')),
                'status'      => 'diajukan',
                'denda'       => 0
            ]);

            $this->bukuModel->update($id_buku, [
                'stok' => $buku['stok'] - 1
            ]);

            return redirect()->to('/peminjaman')->with('pesan', 'Peminjaman telah diajukan!');
        } else {
            return redirect()->back()->with('error', 'Maaf, stok buku sedang habis.');
        }
    }

    public function konfirmasi($id)
    {
        $this->pinjamModel->update($id, [
            'status' => 'dipinjam'
        ]);

        return redirect()->to('/peminjaman')->with('pesan', 'Peminjaman telah dikonfirmasi.');
    }

    public function kembalikan($id)
    {
        // Ambil data peminjaman dan denda_perhari dari join tabel buku
        $dataPinjam = $this->pinjamModel->select('peminjaman.*, buku.denda_perhari, buku.id_buku')
                                    ->join('buku', 'buku.id_buku = peminjaman.id_buku')
                                    ->find($id);

        $tgl_kembali = new DateTime($dataPinjam['tgl_kembali']);
        $tgl_sekarang = new DateTime(date('Y-m-d'));
        $denda = 0;

        // Hitung denda jika telat
        if ($tgl_sekarang > $tgl_kembali) {
            $selisih = $tgl_sekarang->diff($tgl_kembali)->days;
            $denda = $selisih * ($dataPinjam['denda_perhari'] ?? 1000);
        }

        // Update status peminjaman
        $this->pinjamModel->update($id, [
            'tgl_dikembalikan' => date('Y-m-d'),
            'status'           => 'kembali',
            'denda'            => $denda
        ]);

        // Kembalikan stok buku (+1)
        $buku = $this->bukuModel->find($dataPinjam['id_buku']);
        $this->bukuModel->update($dataPinjam['id_buku'], ['stok' => $buku['stok'] + 1]);

        return redirect()->to('/peminjaman')->with('pesan', 'Buku kembali. Denda akhir: Rp ' . number_format($denda, 0, ',', '.'));
    }

    // --- FUNGSI HAPUS DATA PEMINJAMAN ---
    public function hapus($id)
    {
        $dataPinjam = $this->pinjamModel->find($id);

        if ($dataPinjam) {
            // Jika data dihapus saat statusnya belum dikembalikan (masih diajukan/dipinjam), 
            // maka kembalikan stok buku ke jumlah semula.
            if ($dataPinjam['status'] != 'kembali') {
                $buku = $this->bukuModel->find($dataPinjam['id_buku']);
                $this->bukuModel->update($dataPinjam['id_buku'], [
                    'stok' => $buku['stok'] + 1
                ]);
            }

            $this->pinjamModel->delete($id);
            return redirect()->to('/peminjaman')->with('pesan', 'Data peminjaman berhasil dihapus.');
        }

        return redirect()->to('/peminjaman')->with('error', 'Data tidak ditemukan.');
    }
}
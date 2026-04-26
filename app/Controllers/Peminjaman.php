<?php

namespace App\Controllers;

use App\Models\PeminjamanModel;
use App\Models\BukuModel;
use App\Models\DendaModel; // Tambahkan model denda
use DateTime;

class Peminjaman extends BaseController
{
    protected $pinjamModel;
    protected $bukuModel;

    public function __construct()
    {
        $this->pinjamModel = new PeminjamanModel();
        $this->bukuModel = new BukuModel();
    }

    public function index()
    {
        // Sesuaikan key session dengan yang Anda gunakan (id atau id_user)
        $id_user = session()->get('id_user') ?? session()->get('id');
        $role = session()->get('role');

        if ($role == 'admin' || $role == 'petugas') {
            $data_pinjam = $this->pinjamModel->getPeminjaman(); 
        } else {
            $data_pinjam = $this->pinjamModel->where('peminjaman.id_user', $id_user)->getPeminjaman(); 
        }

        // --- LOGIKA DENDA OTOMATIS (REAL-TIME) ---
        $tgl_sekarang = new DateTime(date('Y-m-d'));

        foreach ($data_pinjam as &$p) {
            // Hitung denda berjalan hanya jika statusnya masih dipinjam
            if ($p['status'] == 'dipinjam') {
                $tgl_kembali = new DateTime($p['tgl_kembali']);
                
                if ($tgl_sekarang > $tgl_kembali) {
                    $selisih = $tgl_sekarang->diff($tgl_kembali)->days;
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

    // --- PROSES ANGGOTA: AJUKAN PENGEMBALIAN & KIRIM BUKTI ---
    public function ajukan_kembali($id)
    {
        $dataPinjam = $this->pinjamModel->join('buku', 'buku.id_buku = peminjaman.id_buku')->find($id);
        
        // Hitung denda final saat tombol ditekan
        $tgl_kembali = new DateTime($dataPinjam['tgl_kembali']);
        $tgl_sekarang = new DateTime(date('Y-m-d'));
        $dendaFinal = 0;

        if ($tgl_sekarang > $tgl_kembali) {
            $selisih = $tgl_sekarang->diff($tgl_kembali)->days;
            $dendaFinal = $selisih * ($dataPinjam['denda_perhari'] ?? 1000);
        }

        // Jika ada denda, proses upload bukti
        if ($dendaFinal > 0) {
            $fileBukti = $this->request->getFile('bukti');
            if ($fileBukti && $fileBukti->isValid() && !$fileBukti->hasMoved()) {
                $namaFile = $fileBukti->getRandomName();
                $fileBukti->move('img/bukti_bayar', $namaFile);

                // Masukkan data ke tabel denda
                $this->dendaModel->save([
                    'id_peminjaman' => $id,
                    'denda'         => $dendaFinal,
                    'metode_bayar'  => $this->request->getPost('metode_bayar'),
                    'bukti'         => $namaFile,
                    'status'        => 'menunggu_verifikasi'
                ]);
            }
        }

        // Update status peminjaman menjadi menunggu konfirmasi admin
        $this->pinjamModel->update($id, [
            'status' => 'menunggu konfirmasi',
            'denda'  => $dendaFinal
        ]);

        return redirect()->to('/peminjaman')->with('pesan', 'Pengembalian diajukan. Tunggu verifikasi admin.');
    }

    // --- PROSES ADMIN: KONFIRMASI BUKU KEMBALI ---
    // app/Controllers/Peminjaman.php

public function selesaikan($id)
{
    $pinjam = $this->pinjamModel->find($id);
    $tgl_kembali = strtotime($pinjam['tgl_kembali']); // Tanggal jatuh tempo
    $tgl_sekarang = time(); // Tanggal hari ini
    
    $denda = 0;
    if ($tgl_sekarang > $tgl_kembali) {
        $selisih = floor(($tgl_sekarang - $tgl_kembali) / (60 * 60 * 24)); // Hitung selisih hari
        $tarif_denda = 5000; // Contoh tarif Rp 5.000 per hari
        $denda = $selisih * $tarif_denda;
    }

    // Update data peminjaman
    $this->pinjamModel->save([
        'id_peminjaman' => $id,
        'status' => 'kembali',
        'tgl_dikembalikan' => date('Y-m-d'),
        'denda' => $denda
    ]);

    // Jika ada denda, masukkan juga ke tabel denda (fitur Denda)
    if ($denda > 0) {
        $this->dendaModel->save([
            'id_peminjaman' => $id,
            'id_user'       => $pinjam['id_user'],
            'jumlah_denda'  => $denda,
            'status_bayar'  => 'belum lunas'
        ]);
    }

    return redirect()->to('/peminjaman')->with('pesan', 'Buku dikembalikan. Denda: Rp ' . number_format($denda));
}

    public function tambah($id_buku)
    {
        $buku = $this->bukuModel->find($id_buku);
        if ($buku['stok'] > 0) {
            $this->pinjamModel->save([
                'id_user'     => session()->get('id_user') ?? session()->get('id'), 
                'id_buku'     => $id_buku,
                'tgl_pinjam'  => date('Y-m-d'),
                'tgl_kembali' => date('Y-m-d', strtotime('-2 days')),
                'status'      => 'diajukan',
                'denda'       => 5000
            ]);

            $this->bukuModel->update($id_buku, ['stok' => $buku['stok'] - 1]);
            return redirect()->to('/peminjaman')->with('pesan', 'Peminjaman telah diajukan!');
        }
        return redirect()->back()->with('error', 'Stok buku habis.');
    }

    public function konfirmasi($id)
    {
        $this->pinjamModel->update($id, ['status' => 'dipinjam']);
        return redirect()->to('/peminjaman')->with('pesan', 'Peminjaman telah dikonfirmasi.');
    }

    public function hapus($id)
    {
        $dataPinjam = $this->pinjamModel->find($id);
        if ($dataPinjam) {
            if ($dataPinjam['status'] != 'kembali') {
                $buku = $this->bukuModel->find($dataPinjam['id_buku']);
                $this->bukuModel->update($dataPinjam['id_buku'], ['stok' => $buku['stok'] + 1]);
            }
            $this->pinjamModel->delete($id);
            return redirect()->to('/peminjaman')->with('pesan', 'Data dihapus.');
        }
        return redirect()->to('/peminjaman')->with('error', 'Data tidak ditemukan.');
    }
}
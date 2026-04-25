<?php

namespace App\Models;

use CodeIgniter\Model;

class PeminjamanModel extends Model
{
    protected $table            = 'peminjaman';
    protected $primaryKey       = 'id_peminjaman';
    protected $allowedFields    = [
        'id_user', 'id_buku', 'tgl_pinjam', 
        'tgl_kembali', 'tgl_dikembalikan', 'denda', 'status'
    ];

    public function getPeminjaman()
    {
        return $this->select('peminjaman.*, users.nama as nama_user, buku.judul as judul_buku, buku.denda_perhari')
                    ->join('users', 'users.id = peminjaman.id_user')
                    ->join('buku', 'buku.id_buku = peminjaman.id_buku')
                    ->orderBy('id_peminjaman', 'DESC')
                    ->findAll();
    }
}
<?php

namespace App\Models;

use CodeIgniter\Model;

class DendaModel extends Model
{
    protected $table            = 'denda';
    protected $primaryKey       = 'id_denda';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['id_peminjaman', 'jumlah_denda', 'metode_bayar', 'status', 'bukti'];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'update_at';

    public function getDendaWithDetails($id_user = null)
    {
        $builder = $this->db->table($this->table);
        $builder->select('denda.*, peminjaman.tgl_pinjam, peminjaman.tgl_kembali, buku.judul, users.nama');
        $builder->join('peminjaman', 'peminjaman.id_peminjaman = denda.id_peminjaman');
        $builder->join('buku', 'buku.id_buku = peminjaman.id_buku');
        $builder->join('users', 'users.id = peminjaman.id_user');
        
        if ($id_user !== null) {
            $builder->where('peminjaman.id_user', $id_user);
        }
        
        return $builder->get()->getResultArray();
    }
}
<?php

namespace App\Models;

use CodeIgniter\Model;

class BukuModel extends Model
{
    protected $table            = 'buku';
    protected $primaryKey       = 'id_buku';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['judul', 'penulis', 'stok', 'denda_perhari', 'cover'];

    // Fungsi pencarian (Search)
    public function search($keyword)
    {
        return $this->table('buku')->like('judul', $keyword)->orLike('penulis', $keyword);
    }
}
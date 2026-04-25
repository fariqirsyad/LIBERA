<?php

namespace App\Controllers;

class Home extends BaseController
{
   // Di dalam method index() atau dashboard()
public function index()
{
    $db = \Config\Database::connect();

    // Mengambil data real-time dari database
    $data = [
        'totalBuku'   => $db->table('buku')->countAllResults(),
        'totalPinjam' => $db->table('peminjaman')->countAllResults(),
        'nama'        => session()->get('nama')
    ];

    // Karena nama file Anda home.php, maka panggil 'home'
    return view('layouts/dashboard', $data); 
}
}

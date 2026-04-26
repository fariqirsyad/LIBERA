<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Variabel Filter
$authFilter = ['filter' => 'auth'];

// Variabel Role
$admin     = ['filter' => 'role:admin'];
$petugas     = ['filter' => 'role:petugas'];
$anggota     = ['filter' => 'role:anggota'];
$intRole   = ['filter' => 'role:admin, petugas'];
$allRole   = ['filter' => 'role:admin, petugas, anggota'];

// Login
$routes->get('/', 'Auth::login');
$routes->get('login', 'Auth::login');
$routes->post('/proses-login', 'Auth::prosesLogin');
$routes->get('/logout', 'Auth::logout');


// Halaman utama
$routes->get('home', 'Home::index');
$routes->get('/dashboard', 'Home::index', $authFilter);

// user
$routes->get('user', 'Users::index');
$routes->get('/users/create', 'Users::create'); // form tambah user
$routes->post('/users/store', 'Users::store'); // aksi simpan user
$routes->get('/users', 'Users::index', $intRole); // menampilkan data user hanya untuk admin dan petugas
$routes->get('/users/edit/(:num)', 'Users::edit/$1', $allRole); // form edit user
$routes->post('/users/update/(:num)', 'Users::update/$1', $allRole); // aksi update user
$routes->get('/users/delete/(:num)', 'Users::delete/$1', $allRole); // aksi hapus user
$routes->get('users/detail/(:num)', 'Users::detail/$1', $allRole); // aksi detail user
$routes->get('users/print', 'Users::print', $allRole); // aksi print data user
$routes->get('users/wa/(:num)', 'Users::wa/$1', $allRole); // aksi kirim ke whatsapp

// buku
$routes->get('buku', 'Buku::index');
$routes->get('buku/create', 'Buku::create');
$routes->post('buku/save', 'Buku::save');
$routes->get('buku/edit/(:num)', 'Buku::edit/$1');
$routes->post('buku/update/(:num)', 'Buku::update/$1');
$routes->delete('buku/(:num)', 'Buku::delete/$1');

// peminjaman
$routes->get('peminjaman', 'Peminjaman::index');
$routes->get('peminjaman/tambah/(:num)', 'Peminjaman::tambah/$1');
$routes->get('peminjaman/konfirmasi/(:num)', 'Peminjaman::konfirmasi/$1');
$routes->get('peminjaman/kembalikan/(:num)', 'Peminjaman::kembalikan/$1');
$routes->get('peminjaman/hapus/(:num)', 'Peminjaman::hapus/$1');
$routes->get('peminjaman/selesaikan/(:num)', 'Peminjaman::selesaikan/$1');

// Backup
$routes->get('/backup', 'Backup::index');
$routes->get('/restore', 'Restore::index');
$routes->post('/restore/auth', 'Restore::auth');
$routes->get('/restore/form', 'Restore::form');
$routes->post('/restore/process', 'Restore::process');
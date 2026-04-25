<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid py-4">
    <div class="row align-items-center mb-5">
        <div class="col-md-6">
            <h2 class="fw-bold text-dark mb-1">Koleksi Buku</h2>
            <p class="text-muted mb-0">Temukan berbagai literatur menarik di Libera Library</p>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <?php if (session()->get('role') != 'anggota') : ?>
                <a href="<?= site_url('buku/create') ?>" class="btn btn-primary shadow-sm rounded-pill px-4 py-2">
                    <i class="bi bi-plus-circle-fill me-2"></i>Tambah Buku Baru
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="search-container mb-5">
        <form action="" method="get">
            <div class="input-group shadow-sm rounded-pill bg-white border p-2">
                <span class="input-group-text bg-transparent border-0 px-3">
                    <i class="bi bi-search text-primary"></i>
                </span>
                <input type="text" class="form-control border-0 shadow-none" name="keyword" 
                       placeholder="Cari judul atau penulis..." value="<?= request()->getVar('keyword'); ?>">
                <button class="btn btn-primary rounded-pill px-4" type="submit">Cari Buku</button>
            </div>
        </form>
    </div>

    <?php if (session()->getFlashdata('pesan')) : ?>
        <div class="alert alert-success border-0 shadow-sm rounded-4 py-3 mb-4">
            <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('pesan'); ?>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <?php foreach ($buku as $b) : ?>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 card-buku overflow-hidden">
                    <div class="position-relative">
                        <div class="position-absolute top-0 end-0 m-3 z-3">
                            <span class="badge rounded-pill <?= $b['stok'] > 0 ? 'bg-success' : 'bg-danger' ?> shadow-sm px-3 py-2">
                                Stok: <?= $b['stok']; ?>
                            </span>
                        </div>
                        
                        <div class="cover-wrapper" style="height: 280px; overflow: hidden; background-color: #f1f1f1;">
                            <?php 
                                $coverPath = 'uploads/cover/' . $b['cover'];
                                $displayCover = ($b['cover'] && file_exists(FCPATH . $coverPath)) ? base_url($coverPath) : base_url('uploads/cover/default.jpg');
                            ?>
                            <img src="<?= $displayCover; ?>" class="card-img-top" alt="<?= $b['judul']; ?>" 
                                 style="height: 100%; width: 100%; object-fit: cover; transition: transform 0.3s ease;">
                        </div>
                    </div>

                    <div class="card-body p-4 d-flex flex-column">
                        <h6 class="card-title fw-bold text-dark text-truncate mb-1" title="<?= $b['judul']; ?>">
                            <?= $b['judul']; ?>
                        </h6>
                        <p class="text-muted small mb-4">
                            <i class="bi bi-person-fill me-1 text-primary"></i> <?= $b['penulis']; ?>
                        </p>
                        
                        <div class="mt-auto pt-3 border-top">
                            <div class="row g-2">
                                <?php if (session('role') == 'anggota') : ?>
                                    <div class="col-12 text-center">
                                        <?php if ($b['stok'] > 0) : ?>
                                            <a href="<?= site_url('peminjaman/tambah/' . $b['id_buku']) ?>" 
                                               class="btn btn-outline-primary btn-sm w-100 rounded-pill py-2" 
                                               onclick="return confirm('Pinjam buku ini?')">
                                               Pinjam Sekarang
                                            </a>
                                        <?php else : ?>
                                            <button class="btn btn-light btn-sm w-100 rounded-pill py-2 disabled">Stok Habis</button>
                                        <?php endif; ?>
                                    </div>
                                <?php else : ?>
                                    <div class="col-8">
                                        <a href="<?= site_url('buku/edit/' . $b['id_buku']) ?>" 
                                           class="btn btn-warning btn-sm w-100 rounded-pill text-white py-2 shadow-sm d-flex align-items-center justify-content-center">
                                           <i class="bi bi-pencil-square me-1"></i>Edit
                                        </a>
                                    </div>
                                    <div class="col-4">
                                        <form action="<?= site_url('buku/' . $b['id_buku']) ?>" method="post">
                                            <?= csrf_field(); ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-outline-danger btn-sm w-100 rounded-pill py-2" 
                                                    onclick="return confirm('Hapus data ini?')">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php if (empty($buku)) : ?>
    <div class="text-center py-5">
        <div class="empty-state">
            <i class="bi bi-search-heart display-1 text-light"></i>
            <p class="text-muted mt-3">Wah, buku yang kamu cari tidak ditemukan.</p>
        </div>
    </div>
<?php endif; ?>

<style>
    .card-buku {
        transition: all 0.3s ease;
    }
    .card-buku:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.1) !important;
    }
    .card-buku:hover img {
        transform: scale(1.05);
    }
    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: white;
    }
</style>

<?= $this->endSection(); ?>
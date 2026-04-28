<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LIBERA</title>

    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/bootstrap-icons-1.13.1/bootstrap-icons.css') ?>" rel="stylesheet">
    
    <style>
        body {
            /* Overlay hitam (0.6) sedikit lebih tebal agar gambar tidak menabrak teks */
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), 
                        url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&q=80&w=2000');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            color: #ffffff;
        }

        /* Navbar Klasik: Gelap Solid */
        .navbar {
            background: #1a1a1a !important; 
            border-bottom: 2px solid #d4af37;
            padding: 0.8rem 1rem;
        }

        .navbar-brand {
            font-weight: 800;
            color: #d4af37 !important;
            font-size: 1.5rem;
        }

        .nav-link {
            color: #ffffff !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .nav-link:hover, .nav-link.active {
            color: #d4af37 !important;
            background: rgba(212, 175, 55, 0.15);
        }

        /* Card Klasik: Gelap transparan dengan border emas */
        .card {
            background: rgba(20, 20, 20, 0.8) !important;
            backdrop-filter: none !important; 
            border: 1px solid rgba(212, 175, 55, 0.5) !important;
            border-radius: 12px !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5) !important;
            color: #ffffff !important;
        }

        .main-content {
            padding-top: 30px;
            padding-bottom: 50px;
        }

        /* SOLUSI TEKS TIDAK KELIHATAN: Memberikan bayangan pada semua teks konten */
        .main-content h1, 
        .main-content h2, 
        .main-content h3, 
        .main-content p,
        .main-content span {
            color: #ffffff !important;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.9) !important;
        }

        /* Menyesuaikan teks di dalam card agar tetap kontras */
        .card .text-dark, .card .text-muted {
            color: #ffffff !important;
            text-shadow: none !important; /* Di dalam card tidak butuh shadow berlebih */
        }

        .object-fit-cover {
            object-fit: cover;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url('home') ?>">
                <i class="bi bi-book-half me-2"></i>LIBERA
            </a>
            
            <button class="navbar-toggler border-0 shadow-none text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4 gap-2">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('home') ?>">
                            <i class="bi bi-grid-fill me-1"></i> Dashboard
                        </a>
                    </li>

                    <?php if (session()->get('role') == 'admin') : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('users') ?>">
                            <i class="bi bi-people-fill me-1"></i> Users
                        </a>
                    </li>
                    <?php endif; ?>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('buku') ?>">
                            <i class="bi bi-journal-text me-1"></i> Daftar Buku
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('peminjaman') ?>">
                            <i class="bi bi-arrow-left-right me-1"></i> Peminjaman
                        </a>
                    </li>
                    <?php if (session()->get('role') == 'admin' || session()->get('role') == 'petugas') : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('denda/kelola'); ?>">
                            <i class="bi bi-cash-stack"></i> Verifikasi Denda
                        </a>
                    </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('denda/saya'); ?>">
                                <i class="bi bi-cash-stack"></i> Denda Saya
                            </a>
                        </li>
                    <?php endif; ?>
                    
                </ul>
                
                <div class="d-flex align-items-center border-start border-secondary ps-lg-4 ms-lg-2">
                    <div class="text-end me-3 d-none d-sm-block">
                        <p class="mb-0 small fw-bold lh-1 text-white"><?= session()->get('nama') ?></p>
                        <small class="text-warning fw-bold" style="font-size: 10px;">
                            <?= strtoupper(session()->get('role')) ?>
                        </small>
                    </div>
                    
                    <div class="dropdown">
                        <a href="#" class="d-block link-light text-decoration-none" data-bs-toggle="dropdown">
                            <img src="<?= base_url('uploads/users/' . (session()->get('foto') ?: 'default.png')) ?>" 
                                 alt="profile" width="38" height="38" class="rounded-circle border border-warning object-fit-cover shadow-sm">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3 rounded-3">
                            <li>
                                <a class="dropdown-item py-2" href="<?= base_url('users/edit/' . session()->get('id')) ?>">
                                    <i class="bi bi-person me-2"></i> Profil Saya
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item py-2 text-danger" href="<?= base_url('logout') ?>">
                                    <i class="bi bi-box-arrow-right me-2"></i> Log Out
                                </a>
                                <?php if (session()->get('role') == 'admin') : ?>
<a href="<?= base_url('/backup') ?>" class="btn btn-success">Backup Database</a>
<?php endif; ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="container main-content">
        <?= $this->renderSection('content') ?>
    </div>

    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>
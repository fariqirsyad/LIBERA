<div class="p-3">
    <a href="#" class="d-flex align-items-center mb-4 text-decoration-none text-dark">
        <i class="bi bi-book-half me-2 fs-4 text-primary"></i>
        <span class="fs-5 fw-bold">LIBERA<span class="text-primary"></span></span>
    </a>

    <div class="nav flex-column nav-pills">
        <a href="<?= base_url('/') ?>" class="nav-link text-dark py-2 px-3 mb-1 d-flex align-items-center border-bottom-0">
            <i class="bi bi-grid-1x2-fill me-3"></i> Dashboard
        </a>

        <?php if (session()->get('role') == 'admin' || session()->get('role') == 'petugas') : ?>
            <a href="<?= base_url('/users') ?>" class="nav-link text-dark py-2 px-3 mb-1 d-flex align-items-center">
                <i class="bi bi-people-fill me-3"></i> Users
            </a>
        <?php endif; ?>

        <a href="<?= base_url('/buku') ?>" class="nav-link text-dark py-2 px-3 mb-1 d-flex align-items-center">
            <i class="bi bi-journal-bookmark-fill me-3"></i> Daftar Buku
        </a>

        <a href="<?= base_url('/peminjaman') ?>" class="nav-link text-dark py-2 px-3 mb-1 d-flex align-items-center">
            <i class="bi bi-arrow-left-right me-3"></i> Peminjaman
        </a>

        <?php $idu = session('id'); ?>
        <a href="<?= base_url('users/edit/' . $idu) ?>" class="nav-link text-dark py-2 px-3 mb-1 d-flex align-items-center">
            <i class="bi bi-gear-fill me-3"></i> Setting
        </a>

        <a href="<?= base_url('/logout') ?>" class="nav-link text-danger py-2 px-3 mt-3 d-flex align-items-center border-top">
            <i class="bi bi-box-arrow-right me-3"></i> Log Out
        </a>
    </div>

    <div class="mt-5 pt-4 border-top">
        <div class="text-center">
            <img src="<?= base_url('uploads/users/' . session()->get('foto')) ?>" 
                 class="rounded-circle shadow-sm border mb-2" 
                 style="object-fit: cover; width: 80px; height: 80px;" />
            <div class="small text-muted">Masuk sebagai:</div>
            <div class="fw-bold text-dark text-truncate px-2"><?= session('nama'); ?></div>
            <span class="badge bg-light text-primary border border-primary mt-1" style="font-size: 0.7rem;">
                <?= strtoupper(session('role')); ?>
            </span>
        </div>
    </div>
</div>
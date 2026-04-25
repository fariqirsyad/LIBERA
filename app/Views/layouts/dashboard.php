<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="mb-5">
        <h2 class="fw-bold text-dark mb-1">Dashboard</h2>
        <p class="text-muted small">Selamat datang kembali, <b><?= esc($nama) ?></b> di LIBERA Library.</p>
    </div>

    <div class="row g-4">
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 card-stat">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-shape bg-primary-subtle text-primary rounded-4 me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="bi bi-bookshelf fs-3"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-1 fw-medium">Total Koleksi Buku</p>
                        <h3 class="fw-bold mb-0"><?= $totalBuku ?></h3> 
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 card-stat">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-shape bg-success-subtle text-success rounded-4 me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="bi bi-arrow-left-right fs-3"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-1 fw-medium">Total Peminjaman</p>
                        <h3 class="fw-bold mb-0"><?= $totalPinjam ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 card-stat">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-shape bg-info-subtle text-info rounded-4 me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="bi bi-hdd-network fs-3"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-1 fw-medium">Status Sistem</p>
                        <div class="d-flex align-items-center">
                            <span class="status-indicator"></span>
                            <h6 class="fw-bold mb-0 text-success">Online</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card-stat { transition: all 0.3s ease; }
    .card-stat:hover { transform: translateY(-5px); }
    .status-indicator {
        width: 10px; height: 10px; background-color: #198754;
        border-radius: 50%; display: inline-block; margin-right: 8px;
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(25, 135, 84, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(25, 135, 84, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(25, 135, 84, 0); }
    }
    .bg-primary-subtle { background-color: #e7f1ff !important; }
    .bg-success-subtle { background-color: #e6f4ea !important; }
    .bg-info-subtle { background-color: #e1f5fe !important; }
</style>
<?= $this->endSection() ?>
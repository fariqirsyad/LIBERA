<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid py-4">
    <div class="card border-0 shadow-sm rounded-4 bg-white">
        <div class="card-body">
            <h5 class="mb-4 fw-bold text-dark"><i class="bi bi-clock-history"></i> Log Peminjaman Buku</h5>
            
            <?php if (session()->getFlashdata('pesan')) : ?>
                <div class="alert alert-success border-0 shadow-sm mb-4"><?= session()->getFlashdata('pesan'); ?></div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-white">Peminjam</th>
                            <th class="text-white">Judul Buku</th>
                            <th class="text-white">Tgl Pinjam</th>
                            <th class="text-white">Jatuh Tempo</th>
                            <th class="text-center text-white">Status</th>
                            <th class="text-white">Denda</th>
                            <th class="text-center text-white">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pinjam as $p) : ?>
                        <tr class="text-dark">
                            <td><span class="fw-bolder text-black"><?= $p['nama_user']; ?></span></td>
                            <td class="text-black"><?= $p['judul_buku']; ?></td>
                            <td class="text-black"><?= date('d M Y', strtotime($p['tgl_pinjam'])); ?></td>
                            <td class="text-black"><?= date('d M Y', strtotime($p['tgl_kembali'])); ?></td>
                            <td class="text-center">
                                <?php 
                                    $badgeClass = 'secondary';
                                    if ($p['status'] == 'diajukan') $badgeClass = 'info';
                                    if ($p['status'] == 'dipinjam') $badgeClass = 'warning';
                                    if ($p['status'] == 'kembali') $badgeClass = 'success';
                                    if ($p['status'] == 'menunggu konfirmasi') $badgeClass = 'primary';
                                ?>
                                <span class="badge rounded-pill bg-<?= $badgeClass; ?> px-3">
                                    <?= ucfirst($p['status']); ?>
                                </span>
                            </td>
                            <td class="text-danger fw-bold">
                                <?= ($p['denda'] > 0) ? 'Rp ' . number_format($p['denda'], 0, ',', '.') : '-'; ?>
                            </td>
                            <td class="text-center">
                                <div class="d-flex gap-2 justify-content-center">
                                    <?php if (session('role') != 'anggota') : ?>
                                        <?php if ($p['status'] == 'diajukan') : ?>
                                            <a href="<?= base_url('peminjaman/konfirmasi/' . $p['id_peminjaman']); ?>" class="btn btn-sm btn-success rounded-pill px-3">Setujui</a>
                                        <?php elseif ($p['status'] == 'menunggu konfirmasi') : ?>
                                            <a href="<?= base_url('peminjaman/selesaikan/' . $p['id_peminjaman']); ?>" class="btn btn-sm btn-primary rounded-pill px-3">Konfirmasi Selesai</a>
                                        <?php elseif ($p['status'] == 'kembali') : ?>
                                            <small class="text-muted fw-bold">Selesai: <?= date('d M Y', strtotime($p['tgl_dikembalikan'])); ?></small>
                                        <?php endif; ?>

                                        <a href="<?= base_url('peminjaman/hapus/' . $p['id_peminjaman']); ?>" class="btn btn-sm btn-outline-danger rounded-circle" onclick="return confirm('Hapus data?')">
                                             <i class="bi bi-trash"></i>
                                        </a>
                                    <?php else : ?>
                                        <?php if ($p['status'] == 'dipinjam') : ?>
    <a href="<?= base_url('peminjaman/selesaikan/' . $p['id_peminjaman']); ?>" 
       class="btn btn-sm btn-warning rounded-pill px-3 shadow-sm" 
       onclick="return confirm('Apakah buku ini sudah benar-benar kembali?')">
        <i class="bi bi-check-circle"></i> Selesaikan
    </a>
<?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    /* CSS Tambahan untuk memastikan semua teks di dalam baris berwarna hitam */
    .table tbody tr td {
        color: #000000 !important;
        font-weight: 500;
    }
    .text-black {
        color: #000000 !important;
    }
    .card {
        background-color: rgba(255, 255, 255, 0.95) !important;
    }
</style>
<?= $this->endSection(); ?>
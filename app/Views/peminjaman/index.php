<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid py-4">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">
            <h5 class="mb-4 fw-bold text-dark">Log Peminjaman Buku</h5>
            
            <?php if (session()->getFlashdata('pesan')) : ?>
                <div class="alert alert-success border-0 shadow-sm mb-4"><?= session()->getFlashdata('pesan'); ?></div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Peminjam</th>
                            <th>Judul Buku</th>
                            <th>Tgl Pinjam</th>
                            <th>Jatuh Tempo</th>
                            <th class="text-center">Status</th>
                            <th>Denda</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pinjam as $p) : ?>
                        <tr>
                            <td><span class="fw-bold"><?= $p['nama_user']; ?></span></td>
                            <td><?= $p['judul_buku']; ?></td>
                            <td><?= date('d M Y', strtotime($p['tgl_pinjam'])); ?></td>
                            <td><?= date('d M Y', strtotime($p['tgl_kembali'])); ?></td>
                            <td class="text-center">
                                <?php 
                                    $badgeClass = 'secondary';
                                    if ($p['status'] == 'diajukan') $badgeClass = 'info';
                                    if ($p['status'] == 'dipinjam') $badgeClass = 'warning';
                                    if ($p['status'] == 'kembali') $badgeClass = 'success';
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
                                            <a href="<?= base_url('peminjaman/konfirmasi/' . $p['id_peminjaman']); ?>" 
                                               class="btn btn-sm btn-success rounded-pill px-3"
                                               onclick="return confirm('Setujui peminjaman ini?')">
                                               <i class="bi bi-check2"></i> Setujui
                                            </a>

                                        <?php elseif ($p['status'] == 'dipinjam') : ?>
                                            <a href="<?= base_url('peminjaman/kembalikan/' . $p['id_peminjaman']); ?>" 
                                               class="btn btn-sm btn-primary rounded-pill px-3" 
                                               onclick="return confirm('Konfirmasi pengembalian buku?')">
                                               <i class="bi bi-arrow-return-left"></i> Selesai
                                            </a>

                                        <?php else : ?>
                                            <small class="text-muted">
                                                Dikembalikan: <br>
                                                <span class="fw-bold text-dark"><?= date('d M Y', strtotime($p['tgl_dikembalikan'])); ?></span>
                                            </small>
                                        <?php endif; ?>

                                        <a href="<?= base_url('peminjaman/hapus/' . $p['id_peminjaman']); ?>" 
                                           class="btn btn-sm btn-outline-danger rounded-circle" 
                                           title="Hapus Data"
                                           onclick="return confirm('Hapus data peminjaman ini? Tindakan ini tidak dapat dibatalkan.')">
                                            <i class="bi bi-trash"></i>
                                        </a>

                                    <?php else : ?>
                                        <span class="text-muted small">Tidak ada aksi</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        
                        <?php if (empty($pinjam)) : ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Belum ada data peminjaman.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
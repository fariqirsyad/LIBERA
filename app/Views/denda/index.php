<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-money-bill-wave"></i> Log Tagihan Denda</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th>Peminjam</th>
                            <th>Judul Buku</th>
                            <th>Jumlah Denda</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($denda as $d) : ?>
                            <tr>
                                <td><strong><?= $d['nama']; ?></strong></td>
                                <td><?= $d['judul']; ?></td>
                                <td>Rp <?= number_format($d['jumlah_denda'], 0, ',', '.'); ?></td>
                                <td class="text-center">
                                    <span class="badge <?= ($d['status'] == 'lunas') ? 'badge-success' : (($d['status'] == 'menunggu_verifikasi') ? 'badge-warning' : 'badge-danger'); ?>">
                                        <?= str_replace('_', ' ', $d['status']); ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <?php if (session()->get('role') == 'anggota' && $d['status'] == 'belum_bayar') : ?>
                                        <button type="button" class="btn btn-primary btn-sm" 
                                                data-toggle="modal" data-bs-toggle="modal" 
                                                data-target="#modalBayar<?= $d['id_denda']; ?>" data-bs-target="#modalBayar<?= $d['id_denda']; ?>">
                                            Bayar
                                        </button>
                                    <?php elseif (in_array(session()->get('role'), ['admin', 'petugas']) && $d['status'] == 'menunggu_verifikasi') : ?>
                                        <button type="button" class="btn btn-info btn-sm" 
                                                data-toggle="modal" data-bs-toggle="modal" 
                                                data-target="#modalPeriksa<?= $d['id_denda']; ?>" data-bs-target="#modalPeriksa<?= $d['id_denda']; ?>">
                                            Periksa
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php foreach ($denda as $d) : ?>
    
    <div class="modal fade" id="modalBayar<?= $d['id_denda']; ?>" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 9999;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pembayaran Denda</h5>
                    <button type="button" class="close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('denda/bayar/' . $d['id_denda']); ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <div class="modal-body text-left">
                        <p>Judul: <strong><?= $d['judul']; ?></strong></p>
                        <div class="form-group">
                            <label>Pilih Bukti Pembayaran</label>
                            <input type="file" name="bukti" class="form-control-file" accept="image/*" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Kirim Bukti</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalPeriksa<?= $d['id_denda']; ?>" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 9999;">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-left">
                <div class="modal-header">
                    <h5 class="modal-title">Verifikasi Pembayaran</h5>
                    <button type="button" class="close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img src="<?= base_url('img/bukti_bayar/' . $d['bukti']); ?>" class="img-fluid img-thumbnail mb-3" style="max-height: 400px;">
                    <div class="alert alert-info">
                        Peminjam: <strong><?= $d['nama']; ?></strong>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="<?= base_url('denda/tolak/' . $d['id_denda']); ?>" class="btn btn-danger">Tolak</a>
                    <a href="<?= base_url('denda/setujui/' . $d['id_denda']); ?>" class="btn btn-success">Setujui</a>
                </div>
            </div>
        </div>
    </div>

<?php endforeach; ?>
<?= $this->endSection(); ?>
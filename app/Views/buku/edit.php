<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3 border-0">
                    <div class="d-flex align-items-center">
                        <a href="<?= site_url('buku') ?>" class="btn btn-sm btn-light rounded-circle me-3">
                            <i class="bi bi-arrow-left"></i>
                        </a>
                        <h5 class="mb-0 fw-bold text-dark">Edit Data Buku</h5>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="<?= site_url('buku/update/' . $buku['id_buku']) ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        
                        <div class="mb-3">
                            <label for="judul" class="form-label small fw-bold text-secondary">Judul Buku</label>
                            <input type="text" class="form-control form-control-lg fs-6 rounded-3" id="judul" name="judul" value="<?= $buku['judul']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="penulis" class="form-label small fw-bold text-secondary">Nama Penulis</label>
                            <input type="text" class="form-control form-control-lg fs-6 rounded-3" id="penulis" name="penulis" value="<?= $buku['penulis']; ?>" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="stok" class="form-label small fw-bold text-secondary">Jumlah Stok</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 rounded-start-3"><i class="bi bi-box-seam"></i></span>
                                    <input type="number" class="form-control form-control-lg fs-6 rounded-end-3" id="stok" name="stok" value="<?= $buku['stok']; ?>" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="denda_perhari" class="form-label small fw-bold text-secondary">Denda / Hari (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 rounded-start-3">Rp</span>
                                    <input type="number" class="form-control form-control-lg fs-6 rounded-end-3" id="denda_perhari" name="denda_perhari" value="<?= $buku['denda_perhari']; ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="cover" class="form-label small fw-bold text-secondary">Cover Buku</label>
                            <div class="mb-2">
                                <small class="text-muted d-block mb-1">Cover saat ini:</small>
                                <img src="<?= base_url('uploads/cover/' . ($buku['cover'] ?: 'default.jpg')) ?>" class="img-thumbnail rounded" width="100">
                            </div>
                            <input type="file" class="form-control rounded-3" id="cover" name="cover" accept="image/*">
                            <div class="form-text small">Pilih file baru jika ingin mengganti cover (JPG/PNG/WEBP).</div>
                        </div>

                        <hr class="my-4 text-muted opacity-25">

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning btn-lg fs-6 rounded-pill shadow-sm text-white">
                                <i class="bi bi-save me-2"></i>Simpan Perubahan
                            </button>
                            <a href="<?= site_url('buku') ?>" class="btn btn-link text-secondary text-decoration-none small">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
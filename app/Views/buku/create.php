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
                        <h5 class="mb-0 fw-bold text-dark">Tambah Koleksi Buku</h5>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="<?= site_url('buku/save') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        
                        <div class="mb-3">
                            <label for="judul" class="form-label small fw-bold text-secondary">Judul Buku</label>
                            <input type="text" 
                                   class="form-control form-control-lg fs-6 rounded-3" 
                                   id="judul" 
                                   name="judul" 
                                   placeholder="Masukkan judul lengkap buku" 
                                   required 
                                   autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="penulis" class="form-label small fw-bold text-secondary">Nama Penulis</label>
                            <input type="text" 
                                   class="form-control form-control-lg fs-6 rounded-3" 
                                   id="penulis" 
                                   name="penulis" 
                                   placeholder="Nama penulis buku" 
                                   required>
                        </div>

                        <div class="mb-3">
                            <label for="cover" class="form-label small fw-bold text-secondary">Cover Buku (Foto)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 rounded-start-3"><i class="bi bi-image"></i></span>
                                <input type="file" 
                                       class="form-control form-control-lg fs-6 rounded-end-3" 
                                       id="cover" 
                                       name="cover" 
                                       accept="image/*">
                            </div>
                            <div class="form-text small text-muted">Format: JPG, PNG, atau WEBP. Maksimal 2MB.</div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="stok" class="form-label small fw-bold text-secondary">Jumlah Stok</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 rounded-start-3"><i class="bi bi-box-seam"></i></span>
                                    <input type="number" 
                                           class="form-control form-control-lg fs-6 rounded-end-3" 
                                           id="stok" 
                                           name="stok" 
                                           min="0" 
                                           placeholder="0" 
                                           required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="denda_perhari" class="form-label small fw-bold text-secondary">Denda / Hari (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 rounded-start-3">Rp</span>
                                    <input type="number" 
                                           class="form-control form-control-lg fs-6 rounded-end-3" 
                                           id="denda_perhari" 
                                           name="denda_perhari" 
                                           value="5000" 
                                           required>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4 text-muted opacity-25">

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg fs-6 rounded-pill shadow-sm">
                                <i class="bi bi-check-lg me-2"></i>Simpan Data Buku
                            </button>
                            <a href="<?= site_url('buku') ?>" class="btn btn-link text-secondary text-decoration-none small">
                                Batalkan dan Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
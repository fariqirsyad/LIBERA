<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container main-content">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h1 class="display-5 fw-bold text-white" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.8);">Data Users</h1>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <div class="card mb-4 p-3 border-0 shadow" style="background: rgba(255, 255, 255, 0.95);">
        <form method="get" action="" class="row g-2 align-items-center">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="keyword" class="form-control border-start-0 shadow-none" placeholder="Cari nama..." value="<?= $_GET['keyword'] ?? '' ?>">
                </div>
            </div>
            <div class="col-md-3">
                <select name="role" class="form-select shadow-none">
                    <option value="">-- Semua Role --</option>
                    <option value="admin" <?= (($_GET['role'] ?? '') == 'admin') ? 'selected' : '' ?>>Admin</option>
                    <option value="petugas" <?= (($_GET['role'] ?? '') == 'petugas') ? 'selected' : '' ?>>Petugas</option>
                    <option value="anggota" <?= (($_GET['role'] ?? '') == 'anggota') ? 'selected' : '' ?>>Anggota</option>
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary fw-bold px-4">Cari</button>
                <a href="<?= base_url('users') ?>" class="btn btn-outline-secondary px-3">Reset</a>
                <a href="<?= base_url('users/print?' . http_build_query($_GET)) ?>" target="_blank" class="btn btn-outline-dark px-3">
                    <i class="bi bi-printer me-1"></i> Print
                </a>
            </div>
        </form>
    </div>

    <div class="card shadow border-0 overflow-hidden" style="background-color: #ffffff !important;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light" style="border-bottom: 2px solid #d4af37;">
                    <tr class="fw-bold" style="color: #212529 !important;">
                        <th class="ps-4 py-3">No</th>
                        <th class="py-3">Info User</th>
                        <th class="py-3">Email</th>
                        <th class="py-3 text-center">Role</th>
                        <th class="py-3 text-center">Foto</th>
                        <?php if (session()->get('role') == 'admin') : ?>
                            <th class="py-3 text-center pe-4">Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php $no = 1 + (10 * ($pager->getCurrentPage() - 1)); ?>
                        <?php foreach ($users as $u): ?>
                        <tr>
                            <td class="ps-4" style="color: #6c757d !important;"><?= $no++ ?></td>
                            <td>
                                <div class="fw-bold" style="color: #212529 !important;"><?= $u['nama'] ?></div>
                                <small style="color: #6c757d !important;">@<?= $u['username'] ?></small>
                            </td>
                            <td style="color: #212529 !important;"><?= $u['email'] ?></td>
                            <td class="text-center">
                                <span class="badge border border-primary text-primary small px-3 py-2">
                                    <?= strtoupper($u['role']) ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <?php if ($u['foto']): ?>
                                    <img src="<?= base_url('uploads/users/' . $u['foto']) ?>" width="45" height="45" class="rounded-circle border shadow-sm object-fit-cover">
                                <?php else: ?>
                                    <div class="rounded-circle bg-light border d-inline-flex align-items-center justify-content-center text-muted" style="width: 45px; height: 45px;">
                                        <i class="bi bi-person"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <?php if (session()->get('role') == 'admin') : ?>
                                <td class="text-center pe-4">
                                    <div class="btn-group">
                                        <a href="<?= base_url('users/detail/' . $u['id']) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a>
                                        <a href="<?= base_url('users/edit/' . $u['id']) ?>" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                                        <a href="<?= base_url('users/wa/' . $u['id']) ?>" target="_blank" class="btn btn-sm btn-outline-success"><i class="bi bi-whatsapp"></i></a>
                                        <a href="<?= base_url('users/delete/' . $u['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus user ini?')"><i class="bi bi-trash"></i></a>
                                    </div>
                                </td>
                            <?php endif; ?>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <p class="text-muted">Belum ada data user.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4 d-flex justify-content-center">
        <?= $pager->links() ?>
    </div>
</div>
<?= $this->endSection() ?>
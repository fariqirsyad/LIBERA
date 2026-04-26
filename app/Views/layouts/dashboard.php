<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="mb-5 text-white">
        <h2 class="fw-bold mb-1"></h2>
    </div>

    <div class="row g-4">
        <div class="col-12">
            <div class="p-5 text-center">
                <i class="bi bi-clover-fill text-success" style="font-size: 4rem;"></i>
                <h3 class="text-white mt-3">SELAMAT DATANG DI DASHBOARD LIBERA</h3>
                <p class="text-white mt-3"> <b><?= esc($nama) ?></b> </p>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styling agar teks dashboard kontras dengan background Black Clover */
    h2, p, b {
        color: #ffffff !important;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    }
    
    /* Animasi tambahan untuk ikon semanggi jika ingin efek sihir */
    .bi-clover-fill {
        filter: drop-shadow(0 0 10px rgba(25, 135, 84, 0.8));
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
</style>
<?= $this->endSection() ?>
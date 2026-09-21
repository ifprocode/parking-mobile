<div class="container mt-4">
    <div class="mb-4">
        <h4>Hi, <?= htmlspecialchars($user_name) ?>!</h4>
        <p class="text-muted">Summary incoming and outgoing after navbar</p>
    </div>

    <div class="d-grid gap-3">
        <a href="<?= base_url('parkingin/photo') ?>" class="btn btn-green btn-lg py-4 d-flex flex-column align-items-center justify-content-center" style="border-radius: 12px;">
            <i class="bi bi-box-arrow-in-right fs-1 mb-2"></i>
            <span class="fw-bold">TAMBAH KENDARAAN MASUK</span>
        </a>

        <a href="<?= base_url('parkingout/scan') ?>" class="btn btn-blue btn-lg py-4 d-flex flex-column align-items-center justify-content-center" style="border-radius: 12px;">
            <i class="bi bi-box-arrow-right fs-1 mb-2"></i>
            <span class="fw-bold">PROSES KENDARAAN KELUAR</span>
        </a>
    </div>
</div>

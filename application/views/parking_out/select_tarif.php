<div class="container mt-4 mb-5">
    <div class="mb-4 text-center">
        <h4 class="fw-bold">Pilih Tipe Kendaraan</h4>
        <p class="text-muted">Pilih tarif sebelum memindai resi</p>
    </div>

    <div class="row g-3 justify-content-center">
        <?php foreach($tarifs as $t): ?>
        <div class="col-12 col-md-6">
            <a href="<?= base_url('parkingout/scan/' . $t->id) ?>" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100 p-3 bg-primary text-white text-center" style="border-radius: 15px;">
                    <i class="bi <?= stripos($t->vehicle_type, 'motor') !== false ? 'bi-bicycle' : 'bi-car-front-fill' ?> fs-1 mb-2"></i>
                    <h5 class="fw-bold mb-1 text-uppercase"><?= $t->vehicle_type ?></h5>
                    <small class="opacity-75">
                        (<?= (isset($t->mode) && $t->mode == 'flat') ? 'Flat: Rp '.number_format($t->flat_fare,0,',','.') : 'Progresif: Rp '.number_format($t->hourly_fare,0,',','.').'/jam' ?>)
                    </small>
                </div>
            </a>
        </div>
        <?php endforeach; ?>

        <?php if(empty($tarifs)): ?>
        <div class="col-12 text-center text-muted py-5">
            <i class="bi bi-exclamation-circle fs-1 d-block mb-3"></i>
            Belum ada master tarif yang dikonfigurasi.<br>Silakan tambahkan di menu Admin.
        </div>
        <?php endif; ?>
    </div>
</div>

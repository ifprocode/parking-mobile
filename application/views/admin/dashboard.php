<div class="container mt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Dashboard Admin</h4>
        <div class="text-muted small"><?= date('l, d F Y') ?></div>
    </div>

    <div class="row g-3">
        <!-- Total Masuk -->
        <div class="col-6">
            <div class="card bg-primary text-white border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-white-50 mb-1">Masuk Hari Ini</h6>
                            <h3 class="fw-bold mb-0"><?= $metrics['total_in'] ?></h3>
                        </div>
                        <i class="bi bi-box-arrow-in-right fs-1 text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Keluar -->
        <div class="col-6">
            <div class="card bg-success text-white border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-white-50 mb-1">Keluar Hari Ini</h6>
                            <h3 class="fw-bold mb-0"><?= $metrics['total_out'] ?></h3>
                        </div>
                        <i class="bi bi-box-arrow-right fs-1 text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Inside -->
        <div class="col-6">
            <div class="card bg-warning text-dark border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-dark-50 mb-1">Total di Dalam</h6>
                            <h3 class="fw-bold mb-0"><?= $metrics['total_inside'] ?></h3>
                        </div>
                        <i class="bi bi-car-front-fill fs-1 text-dark-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Income -->
        <div class="col-6">
            <div class="card bg-info text-white border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-white-50 mb-1">Pendapatan</h6>
                            <h5 class="fw-bold mb-0">Rp <?= number_format($metrics['total_income'], 0, ',', '.') ?></h5>
                        </div>
                        <i class="bi bi-wallet2 fs-1 text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <!-- Total Batal Parkir -->
        <div class="col-12">
            <div class="card bg-secondary text-white border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-white-50 mb-1">Total Batal Parkir (Hari Ini)</h6>
                            <h3 class="fw-bold mb-0"><?= isset($metrics['total_cancelled']) ? $metrics['total_cancelled'] : 0 ?></h3>
                        </div>
                        <i class="bi bi-x-octagon fs-1 text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="<?= base_url('admin/vehicles') ?>" class="btn btn-outline-primary w-100 py-3 shadow-sm rounded-3 fw-bold">
            <i class="bi bi-list-ul me-2"></i> LIHAT SEMUA KENDARAAN
        </a>
    </div>
</div>

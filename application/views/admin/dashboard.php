<div class="container mt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Dashboard Admin</h4>
        <div class="text-muted small"><?= date('l, d F Y') ?></div>
    </div>

    <!-- Hari Ini -->
    <h6 class="fw-bold text-muted mb-3">Statistik Hari Ini</h6>
    <div class="row g-3 mb-4">
        <div class="col-6">
            <div class="card bg-primary text-white border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-white-50 mb-1">Kendaraan Masuk</h6>
                            <h3 class="fw-bold mb-0"><?= $metrics['total_in'] ?></h3>
                        </div>
                        <i class="bi bi-box-arrow-in-right fs-1 text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card bg-success text-white border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-white-50 mb-1">Kendaraan Keluar</h6>
                            <h3 class="fw-bold mb-0"><?= $metrics['total_out'] ?></h3>
                        </div>
                        <i class="bi bi-box-arrow-right fs-1 text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>
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
        <div class="col-6">
            <div class="card bg-secondary text-white border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-white-50 mb-1">Batal Parkir</h6>
                            <h3 class="fw-bold mb-0"><?= isset($metrics['total_cancelled']) ? $metrics['total_cancelled'] : 0 ?></h3>
                        </div>
                        <i class="bi bi-x-octagon fs-1 text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Keseluruhan -->
    <h6 class="fw-bold text-muted mb-3">Statistik Keseluruhan (Semua Waktu)</h6>
    <div class="row g-3 mb-4">
        <div class="col-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-1 small">Total Transaksi</h6>
                    <h4 class="fw-bold text-primary mb-0"><?= $overall_metrics['total_in'] ?></h4>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-1 small">Total Pendapatan</h6>
                    <h4 class="fw-bold text-success mb-0">Rp <?= number_format($overall_metrics['total_income'], 0, ',', '.') ?></h4>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card bg-warning text-dark border-0 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center py-2">
                    <div class="fw-bold">Masih di Dalam Parkiran</div>
                    <h3 class="fw-bold mb-0"><?= $overall_metrics['total_inside'] ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <!-- Pendapatan per Operator -->
        <div class="col-12 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white fw-bold">Pendapatan per Operator</div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <?php if(empty($income_per_user)): ?>
                            <li class="list-group-item text-muted text-center py-3">Belum ada data</li>
                        <?php else: ?>
                            <?php foreach($income_per_user as $iu): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-person-circle text-muted me-2"></i><?= $iu->name ?></span>
                                <span class="fw-bold text-success">Rp <?= number_format($iu->total_income, 0, ',', '.') ?></span>
                            </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Kendaraan per Tipe -->
        <div class="col-12 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white fw-bold">Proporsi Tipe Kendaraan</div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <?php if(empty($vehicle_types)): ?>
                            <li class="list-group-item text-muted text-center py-3">Belum ada data</li>
                        <?php else: ?>
                            <?php foreach($vehicle_types as $vt): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-car-front text-muted me-2"></i><?= $vt->vehicle_type ?></span>
                                <span class="badge bg-primary rounded-pill"><?= $vt->total_count ?></span>
                            </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="<?= base_url('admin/vehicles') ?>" class="btn btn-outline-primary w-100 py-3 shadow-sm rounded-3 fw-bold">
            <i class="bi bi-list-ul me-2"></i> LIHAT SEMUA DATA KENDARAAN
        </a>
    </div>
</div>

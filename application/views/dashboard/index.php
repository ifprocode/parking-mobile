<div class="container mt-4">
    <div class="mb-4">
        <h4>Hi, <?= htmlspecialchars($user_name) ?>!</h4>
        <p class="text-muted">Pilih menu operasi di bawah ini</p>
    </div>

    <?php if($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= $this->session->flashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <div class="row mb-4">
        <div class="col-12">
            <?php if(isset($role) && $role === 'admin'): ?>
                <div class="card bg-success text-white border-0 shadow-sm text-center p-3" style="border-radius: 12px;">
                    <h6 class="mb-1" style="font-size: 0.8rem; opacity: 0.8;">Total Transaksi (Hari Ini)</h6>
                    <h2 class="mb-0 fw-bold"><?= isset($total_trx) ? $total_trx : 0 ?></h2>
                </div>
            <?php else: ?>
                <div class="card bg-primary text-white border-0 shadow-sm text-center p-3" style="border-radius: 12px;">
                    <h6 class="mb-1" style="font-size: 0.8rem; opacity: 0.8;">Transaksi Anda (Hari Ini)</h6>
                    <h2 class="mb-0 fw-bold"><?= isset($user_trx) ? $user_trx : 0 ?></h2>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <?php if(isset($role) && $role === 'admin'): ?>
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-dark text-white fw-bold">
            <i class="bi bi-graph-up-arrow me-2"></i> Statistik Keseluruhan (Admin)
        </div>
        <div class="card-body">
            <div class="row text-center mb-3">
                <div class="col-4">
                    <h6 class="text-muted" style="font-size: 0.65rem;">TOTAL PENDAPATAN</h6>
                    <h6 class="fw-bold text-success">Rp <?= number_format($overall_metrics['total_income'], 0, ',', '.') ?></h6>
                </div>
                <div class="col-4">
                    <h6 class="text-muted" style="font-size: 0.65rem;">TOTAL MASUK</h6>
                    <h6 class="fw-bold text-primary"><?= $overall_metrics['total_in'] ?></h6>
                </div>
                <div class="col-4">
                    <h6 class="text-muted" style="font-size: 0.65rem;">TOTAL KELUAR</h6>
                    <h6 class="fw-bold text-danger"><?= $overall_metrics['total_out'] ?></h6>
                </div>
            </div>
            
            <div class="row text-center mb-3">
                <div class="col-12">
                    <div class="p-2 bg-light rounded border">
                        <h6 class="text-muted mb-1" style="font-size: 0.75rem;">KENDARAAN DI DALAM (SAAT INI)</h6>
                        <h4 class="fw-bold mb-0 text-warning"><?= $overall_metrics['total_inside'] ?></h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <h6 class="fw-bold border-bottom pb-2" style="font-size: 0.85rem;">Pendapatan per User</h6>
                    <ul class="list-group list-group-flush" style="font-size: 0.8rem;">
                        <?php foreach($income_per_user as $iu): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <?= htmlspecialchars($iu->name) ?>
                            <span class="fw-bold">Rp <?= number_format($iu->total_income, 0, ',', '.') ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold border-bottom pb-2" style="font-size: 0.85rem;">Total Jenis Kendaraan</h6>
                    <ul class="list-group list-group-flush" style="font-size: 0.8rem;">
                        <?php foreach($vehicle_types as $vt): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <?= htmlspecialchars($vt->vehicle_type) ?>
                            <span class="badge bg-secondary rounded-pill"><?= $vt->total_count ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="d-grid gap-3">
        <a href="<?= base_url('parkingin/select_tarif') ?>" class="btn btn-green btn-lg py-4 d-flex flex-column align-items-center justify-content-center" style="border-radius: 12px;">
            <i class="bi bi-box-arrow-in-right fs-1 mb-2"></i>
            <span class="fw-bold">TAMBAH KENDARAAN MASUK</span>
        </a>

        <a href="<?= base_url('parkingout/scan') ?>" class="btn btn-blue btn-lg py-4 d-flex flex-column align-items-center justify-content-center" style="border-radius: 12px;">
            <i class="bi bi-box-arrow-right fs-1 mb-2"></i>
            <span class="fw-bold">PROSES KENDARAAN KELUAR</span>
        </a>
    </div>
</div>



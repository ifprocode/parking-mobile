<div class="container mt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">List Kendaraan</h4>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.9rem;">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">Plat / Resi</th>
                            <th>Waktu Masuk</th>
                            <th>Waktu Keluar</th>
                            <th class="text-end pe-3">Tarif</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($transactions)): ?>
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">Belum ada data transaksi.</td>
                        </tr>
                        <?php else: ?>
                            <?php foreach($transactions as $t): ?>
                            <tr>
                                <td class="ps-3">
                                    <div class="fw-bold text-primary"><?= $t->plate_number ?></div>
                                    <small class="text-muted"><?= $t->receipt_number ?></small>
                                </td>
                                <td>
                                    <small><?= date('d M Y', strtotime($t->time_in)) ?></small><br>
                                    <span class="badge bg-success"><?= date('H:i', strtotime($t->time_in)) ?></span>
                                </td>
                                <td>
                                    <?php if($t->time_out): ?>
                                        <small><?= date('d M Y', strtotime($t->time_out)) ?></small><br>
                                        <span class="badge bg-danger"><?= date('H:i', strtotime($t->time_out)) ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Di Dalam</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end pe-3 fw-bold">
                                    <?php if($t->total_fare): ?>
                                        Rp <?= number_format($t->total_fare, 0, ',', '.') ?>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

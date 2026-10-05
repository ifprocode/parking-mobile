<div class="container mt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">List Kendaraan</h4>
    </div>

    <!-- Search Filter -->
    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body p-3">
            <form action="<?= base_url('admin/vehicles') ?>" method="GET" class="d-flex flex-wrap gap-2">
                <input type="date" name="date" class="form-control" style="width: auto;" value="<?= isset($date) ? htmlspecialchars($date) : '' ?>">
                <input type="text" name="search" class="form-control" style="flex: 1;" placeholder="Cari Nomor Tiket / Plat Nomor..." value="<?= isset($search) ? htmlspecialchars($search) : '' ?>">
                <select name="status" class="form-select" style="width: auto;">
                    <option value="">Semua Status</option>
                    <option value="belum_keluar" <?= (isset($status) && $status == 'belum_keluar') ? 'selected' : '' ?>>Belum Keluar</option>
                    <option value="batal" <?= (isset($status) && $status == 'batal') ? 'selected' : '' ?>>Dibatalkan</option>
                </select>
                <select name="operator_id" class="form-select" style="width: auto;">
                    <option value="">Semua Operator</option>
                    <?php if(!empty($users)): ?>
                        <?php foreach($users as $u): ?>
                            <option value="<?= $u->id ?>" <?= (isset($operator_id) && $operator_id == $u->id) ? 'selected' : '' ?>><?= $u->name ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Cari</button>
                <?php if(!empty($search) || !empty($date) || !empty($status) || !empty($operator_id)): ?>
                    <a href="<?= base_url('admin/vehicles') ?>" class="btn btn-outline-secondary">Reset</a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.9rem;">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">Plat / Resi</th>
                            <th>Foto / Jenis</th>
                            <th>Waktu Masuk</th>
                            <th>Waktu Keluar</th>
                            <th class="text-end">Tarif</th>
                            <th class="text-center pe-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($transactions)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada data transaksi.</td>
                        </tr>
                        <?php else: ?>
                            <?php foreach($transactions as $t): ?>
                            <tr>
                                <td class="ps-3">
                                    <div class="fw-bold text-primary"><?= $t->plate_number ?></div>
                                    <small class="text-muted"><?= $t->receipt_number ?></small><br>
                                    <small class="text-muted" style="font-size: 0.75rem;"><i class="bi bi-person-circle"></i> <?= isset($t->operator_name) && $t->operator_name ? $t->operator_name : 'Sistem' ?></small>
                                </td>
                                <td>
                                    <?php 
                                        $foto_path = FCPATH . 'foto/' . $t->photo_in;
                                        if(!empty($t->photo_in) && file_exists($foto_path)): 
                                    ?>
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#photoModal" onclick="document.getElementById('modalImage').src='<?= base_url('foto/'.$t->photo_in) ?>'">
                                            <img src="<?= base_url('foto/'.$t->photo_in) ?>" alt="Foto" class="img-thumbnail me-1" style="max-height: 40px; cursor: pointer;">
                                        </a>
                                    <?php else: ?>
                                        <span class="badge bg-secondary mb-1">No Photo</span><br>
                                    <?php endif; ?>
                                    <span class="badge bg-info text-dark"><?= isset($t->vehicle_type) ? $t->vehicle_type : '-' ?></span>
                                </td>
                                <td>
                                    <small><?= date('d M Y', strtotime($t->time_in)) ?></small><br>
                                    <span class="badge bg-success"><?= date('H:i', strtotime($t->time_in)) ?></span>
                                </td>
                                <td>
                                    <?php if(isset($t->status) && $t->status == 'cancelled'): ?>
                                        <small><?= date('d M Y', strtotime($t->time_out)) ?></small><br>
                                        <span class="badge bg-secondary">Batal Parkir</span>
                                    <?php elseif($t->time_out): ?>
                                        <small><?= date('d M Y', strtotime($t->time_out)) ?></small><br>
                                        <span class="badge bg-danger"><?= date('H:i', strtotime($t->time_out)) ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Di Dalam</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end fw-bold">
                                    <?php if($t->total_fare): ?>
                                        Rp <?= number_format($t->total_fare, 0, ',', '.') ?>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td class="text-center pe-3">
                                    <?php if(!isset($t->status) || $t->status != 'cancelled'): ?>
                                        <a href="<?= base_url('admin/cancel_vehicle/'.$t->id) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin membatalkan kendaraan ini (Tidak jadi parkir)?')">
                                            <i class="bi bi-x-circle"></i> Batal
                                        </a>
                                    <?php else: ?>
                                        <a href="<?= base_url('admin/reactivate_vehicle/'.$t->id) ?>" class="btn btn-sm btn-outline-success" onclick="return confirm('Yakin ingin mengaktifkan kembali kendaraan ini?')">
                                            <i class="bi bi-check-circle"></i> Aktifkan
                                        </a>
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

<!-- Photo Modal -->
<div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="photoModalLabel">Foto Kendaraan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center p-0">
        <img id="modalImage" src="" alt="Foto Besar" class="img-fluid w-100">
      </div>
    </div>
  </div>
</div>

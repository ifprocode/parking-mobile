<div class="container mt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Master Tarif</h4>
        <button class="btn btn-primary btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#tarifModal" onclick="resetForm()">
            <i class="bi bi-plus-lg"></i> Tambah
        </button>
    </div>

    <?php if($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <?= $this->session->flashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">Tipe</th>
                            <th>Mode Kalkulasi</th>
                            <th>Tarif Flat (Harian)</th>
                            <th>Per Jam (Progresif)</th>
                            <th class="text-end pe-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($tarifs)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada data tarif.</td>
                        </tr>
                        <?php else: ?>
                            <?php foreach($tarifs as $t): ?>
                            <tr>
                                <td class="ps-3 fw-bold"><?= $t->vehicle_type ?></td>
                                <td>
                                    <?php if(isset($t->mode) && $t->mode == 'flat'): ?>
                                        <span class="badge bg-info">Flat (Harian)</span>
                                    <?php else: ?>
                                        <span class="badge bg-primary">Progresif</span>
                                    <?php endif; ?>
                                </td>
                                <td>Rp <?= number_format($t->flat_fare, 0, ',', '.') ?></td>
                                <td>Rp <?= number_format($t->hourly_fare, 0, ',', '.') ?></td>
                                <td class="text-end pe-3">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle" onclick="editTarif(<?= $t->id ?>, '<?= $t->vehicle_type ?>', '<?= isset($t->mode) ? $t->mode : 'progresif' ?>', <?= $t->flat_fare ?>, <?= $t->hourly_fare ?>)">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <a href="<?= base_url('admin/delete_tarif/'.$t->id) ?>" class="btn btn-sm btn-outline-danger rounded-circle" onclick="return confirm('Hapus tarif ini?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
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

<!-- Modal Form -->
<div class="modal fade" id="tarifModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="<?= base_url('admin/save_tarif') ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modalTitle">Tambah Tarif</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="tarif_id">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Tipe Kendaraan</label>
                        <input type="text" class="form-control" name="vehicle_type" id="vehicle_type" required placeholder="Misal: Mobil, Motor">
                    </div>
                    <div class="mb-3 p-3 border rounded bg-light">
                        <label class="form-label fw-bold small d-block mb-2">Mode Kalkulasi</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="mode" id="mode_progresif" value="progresif" checked>
                            <label class="form-check-label" for="mode_progresif">Progresif</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="mode" id="mode_flat" value="flat">
                            <label class="form-check-label" for="mode_flat">Flat (Harian)</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Tarif Flat Harian (Rp)</label>
                        <input type="number" class="form-control" name="flat_fare" id="flat_fare" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Tarif Per Jam Progresif (Rp)</label>
                        <input type="number" class="form-control" name="hourly_fare" id="hourly_fare" required>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function resetForm() {
    document.getElementById('modalTitle').innerText = 'Tambah Tarif';
    document.getElementById('tarif_id').value = '';
    document.getElementById('vehicle_type').value = '';
    document.getElementById('mode_progresif').checked = true;
    document.getElementById('flat_fare').value = '';
    document.getElementById('hourly_fare').value = '';
}

function editTarif(id, type, mode, flat, hourly) {
    document.getElementById('modalTitle').innerText = 'Edit Tarif';
    document.getElementById('tarif_id').value = id;
    document.getElementById('vehicle_type').value = type;
    if (mode === 'flat') {
        document.getElementById('mode_flat').checked = true;
    } else {
        document.getElementById('mode_progresif').checked = true;
    }
    document.getElementById('flat_fare').value = flat;
    document.getElementById('hourly_fare').value = hourly;
    
    var myModal = new bootstrap.Modal(document.getElementById('tarifModal'));
    myModal.show();
}
</script>

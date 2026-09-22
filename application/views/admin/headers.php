<div class="container mt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Master Header Aplikasi</h4>
        <button class="btn btn-primary fw-bold px-3 rounded-pill shadow-sm" onclick="resetForm()" data-bs-toggle="modal" data-bs-target="#headerModal">
            <i class="bi bi-plus-lg me-1"></i> Tambah
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
                            <th class="ps-3">Nama Header</th>
                            <th>Status</th>
                            <th class="text-end pe-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($headers)): ?>
                        <tr>
                            <td colspan="3" class="text-center py-4 text-muted">Belum ada data header.</td>
                        </tr>
                        <?php else: ?>
                            <?php foreach($headers as $h): ?>
                            <tr>
                                <td class="ps-3 fw-bold"><?= htmlspecialchars($h->header_name) ?></td>
                                <td>
                                    <?php if($h->is_active == 1): ?>
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Aktif</span>
                                    <?php else: ?>
                                        <a href="<?= base_url('admin/set_active_header/'.$h->id) ?>" class="btn btn-sm btn-outline-secondary rounded-pill">Jadikan Aktif</a>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end pe-3">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle" onclick="editHeader(<?= $h->id ?>, '<?= addslashes($h->header_name) ?>')">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <a href="<?= base_url('admin/delete_header/'.$h->id) ?>" class="btn btn-sm btn-outline-danger rounded-circle" onclick="return confirm('Hapus header ini?')">
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
<div class="modal fade" id="headerModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="<?= base_url('admin/save_header') ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modalTitle">Tambah Header</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="header_id">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Nama Header</label>
                        <input type="text" class="form-control" name="header_name" id="header_name" required placeholder="Misal: Parkir Kita">
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
    document.getElementById('modalTitle').innerText = 'Tambah Header';
    document.getElementById('header_id').value = '';
    document.getElementById('header_name').value = '';
}

function editHeader(id, name) {
    document.getElementById('modalTitle').innerText = 'Edit Header';
    document.getElementById('header_id').value = id;
    document.getElementById('header_name').value = name;
    
    var myModal = new bootstrap.Modal(document.getElementById('headerModal'));
    myModal.show();
}
</script>

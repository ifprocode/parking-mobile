<div class="container mt-3">
    
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0">Manajemen User</h5>
        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#userModal" onclick="resetForm()">
            <i class="bi bi-plus-lg"></i> Tambah
        </button>
    </div>

    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show text-center" role="alert" style="font-size: 0.9rem;">
            <?= $this->session->flashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0" style="font-size: 0.85rem;">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Gate</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($users as $u): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td class="fw-bold"><?= $u->name ?></td>
                            <td><?= $u->email ?></td>
                            <td><span class="badge <?= $u->role == 'admin' ? 'bg-danger' : 'bg-primary' ?>"><?= strtoupper($u->role) ?></span></td>
                            <td><?= isset($u->gate) && !empty($u->gate) ? $u->gate : '-' ?></td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-primary" onclick="editUser(<?= $u->id ?>, '<?= $u->name ?>', '<?= $u->email ?>', '<?= $u->role ?>', '<?= isset($u->gate) ? $u->gate : '' ?>')"><i class="bi bi-pencil"></i></button>
                                <?php if($u->id != $this->session->userdata('id')): ?>
                                <a href="<?= base_url('admin/delete_user/'.$u->id) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin hapus user ini?')"><i class="bi bi-trash"></i></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal User -->
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="<?= base_url('admin/save_user') ?>" method="post">
          <div class="modal-header">
            <h5 class="modal-title fw-bold" id="userModalLabel">Tambah/Edit User</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="id" id="user_id">
            
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" class="form-control" name="name" id="name" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password <small class="text-muted">(Isi untuk mengganti/buat baru)</small></label>
                <input type="password" class="form-control" name="password" id="password">
            </div>

            <div class="mb-3">
                <label class="form-label">Role</label>
                <select class="form-select" name="role" id="role" required>
                    <option value="operator">OPERATOR</option>
                    <option value="admin">ADMIN</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Gate <small class="text-muted">(Optional untuk Admin)</small></label>
                <select class="form-select" name="gate" id="gate">
                    <option value="">-- Pilih Gate --</option>
                    <option value="Mobil">Mobil</option>
                    <option value="Motor">Motor</option>
                </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
      </form>
    </div>
  </div>
</div>

<script>
function resetForm() {
    document.getElementById('user_id').value = '';
    document.getElementById('name').value = '';
    document.getElementById('email').value = '';
    document.getElementById('password').value = '';
    document.getElementById('role').value = 'operator';
    document.getElementById('gate').value = '';
}

function editUser(id, name, email, role, gate) {
    document.getElementById('user_id').value = id;
    document.getElementById('name').value = name;
    document.getElementById('email').value = email;
    document.getElementById('password').value = '';
    document.getElementById('role').value = role;
    document.getElementById('gate').value = gate;
    
    var userModal = new bootstrap.Modal(document.getElementById('userModal'));
    userModal.show();
}
</script>

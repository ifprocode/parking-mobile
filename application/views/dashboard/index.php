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

    <div class="d-grid gap-3">
        <!-- Trigger Modal -->
        <button type="button" class="btn btn-green btn-lg py-4 d-flex flex-column align-items-center justify-content-center" style="border-radius: 12px;" data-bs-toggle="modal" data-bs-target="#cameraConfirmModal">
            <i class="bi bi-box-arrow-in-right fs-1 mb-2"></i>
            <span class="fw-bold">TAMBAH KENDARAAN MASUK</span>
        </button>

        <a href="<?= base_url('parkingout/select_tarif') ?>" class="btn btn-blue btn-lg py-4 d-flex flex-column align-items-center justify-content-center" style="border-radius: 12px;">
            <i class="bi bi-box-arrow-right fs-1 mb-2"></i>
            <span class="fw-bold">PROSES KENDARAAN KELUAR</span>
        </a>
    </div>
</div>

<!-- Camera Confirmation Modal -->
<div class="modal fade" id="cameraConfirmModal" tabindex="-1" aria-labelledby="cameraConfirmModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="cameraConfirmModalLabel">Izin Akses Kamera</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Aplikasi membutuhkan akses ke kamera untuk mengambil foto plat dan kendaraan. Apakah Anda ingin melanjutkan?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <a href="<?= base_url('parkingin/photo') ?>" class="btn btn-primary">Gunakan Kamera</a>
      </div>
    </div>
  </div>
</div>

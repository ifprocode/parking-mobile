<div class="container mt-3">
    
    <div class="card p-3 mb-4 shadow-sm border-0">
        <h5 class="fw-bold text-center mb-3 text-uppercase border-bottom pb-2">Ringkasan Keluar</h5>
        
        <div class="row text-center mb-3">
            <div class="col-6">
                <h6 class="fw-bold small mb-1">FOTO MASUK</h6>
                <img src="https://placehold.co/150x100/333/fff?text=Car+In" alt="Car Entry" class="img-fluid rounded border">
            </div>
            <div class="col-6">
                <h6 class="fw-bold small mb-1">FOTO KELUAR</h6>
                <img src="https://placehold.co/150x100/333/fff?text=Car+Out" alt="Car Exit" class="img-fluid rounded border">
            </div>
        </div>
        
        <div class="text-center mb-4">
            <p class="mb-1 fw-bold">Durasi: <?= $duration ?></p>
        </div>
        
        <div class="bg-success text-white text-center p-3 rounded-3 mb-4">
            <h6 class="mb-1">TOTAL TARIF:</h6>
            <h3 class="fw-bold mb-0"><?= $total_fare ?></h3>
        </div>
        
        <button class="btn btn-primary btn-lg w-100 fw-bold d-flex justify-content-center align-items-center" onclick="window.print();">
            <i class="bi bi-file-earmark-pdf-fill me-2 fs-4"></i> CETAK STRUK PDF
        </button>
    </div>
    
    <div class="text-center mt-4">
        <a href="<?= base_url('dashboard') ?>" class="text-decoration-none">Kembali ke Beranda</a>
    </div>

</div>

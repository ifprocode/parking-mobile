<div class="container text-center mt-3">
    
    <div class="card p-4">
        <h5 class="fw-bold mb-3">SIMPAN BERHASIL</h5>
        
        <!-- Placeholder for QR Code generation, normally done dynamically with a library -->
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?= $receipt ?>" alt="QR Code" class="img-fluid mx-auto mb-3" style="width: 150px; height: 150px;">
        
        <h6 class="fw-bold">NOMOR RESI: <?= $receipt ?></h6>
        
        <div class="row text-start mt-3">
            <div class="col-6 fw-bold">Plat</div>
            <div class="col-6"><?= $plate ?></div>
            
            <div class="col-6 fw-bold">Waktu Masuk</div>
            <div class="col-6"><?= $time_in ?></div>
        </div>
        
        <div class="d-flex align-items-center justify-content-center mt-3 p-2 border rounded">
            <img src="https://placehold.co/60x40/333/fff?text=Car" alt="Car" class="img-fluid rounded me-2">
            <small class="text-muted">Captured Kendaraan</small>
        </div>
    </div>

    <button class="btn btn-primary btn-lg w-100 mt-4 mb-3 d-flex justify-content-center align-items-center" onclick="window.print();">
        <i class="bi bi-printer-fill me-2"></i> CETAK STRUK
    </button>
</div>

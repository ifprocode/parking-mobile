<div class="container mt-3">
    
    <div class="card p-3 mb-4">
        <h5 class="fw-bold text-center mb-3 text-uppercase border-bottom pb-2">Proses Keluar</h5>
        
        <div class="text-center mb-3">
            <h6 class="fw-bold mb-1">FOTO MASUK</h6>
            <img src="<?= $photo_in ?>" alt="Car Entry" class="img-fluid rounded shadow-sm" style="max-height: 150px; width: 100%; object-fit: cover;">
        </div>
        
        <form action="<?= base_url('parkingout/receipt') ?>" method="post">
            <input type="hidden" name="receipt" value="<?= $receipt ?>">
            <input type="hidden" name="photo_in" value="<?= $photo_in ?>">
            
            <div class="mb-3">
                <label class="fw-bold small">WAKTU MASUK:</label>
                <input type="text" class="form-control" name="time_in" value="<?= $time_in ?>" readonly>
            </div>
            
            <div class="mb-3">
                <label class="fw-bold small">WAKTU KELUAR:</label>
                <div class="input-group">
                    <input type="text" class="form-control fw-bold" name="time_out" value="<?= $time_out ?>">
                    <span class="input-group-text"><i class="bi bi-pencil"></i></span>
                </div>
            </div>
            <div class="mb-3">
                <label class="fw-bold small">STATUS PEMBAYARAN:</label>
                <div class="form-control text-success fw-bold">LUNAS</div>
            </div>
            
            <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold mt-2 rounded-3">
                PROSES KENDARAAN KELUAR
            </button>
        </form>
    </div>

</div>

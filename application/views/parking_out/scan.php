<div style="background-color: #000; height: 100vh; position: relative;">
    
    <!-- Top Action Bar -->
    <div class="d-flex justify-content-between p-3 position-absolute w-100" style="z-index: 10; top: 0;">
        <a href="<?= base_url('dashboard') ?>" class="text-white text-decoration-none fs-4"><i class="bi bi-x-lg"></i></a>
    </div>

    <!-- Scanner Viewfinder (Simulated) -->
    <div class="d-flex flex-column align-items-center justify-content-center h-100 position-relative">
        <h5 class="text-white mb-4 fw-bold" style="z-index: 10;">PINDAI QR KODE RESI</h5>
        
        <div style="width: 250px; height: 250px; border: 2px solid #fff; border-radius: 12px; position: relative; z-index: 10;">
            <!-- Simulated scanning laser line -->
            <div style="width: 100%; height: 2px; background-color: red; position: absolute; top: 50%; box-shadow: 0 0 10px red;"></div>
            
            <!-- Simulated ticket inside scanner -->
            <div class="bg-white m-3 h-75 text-dark p-2" style="opacity: 0.8;">
                <small class="d-block fw-bold border-bottom pb-1 mb-1 text-center">SmartPark</small>
                <img src="https://placehold.co/150x40/fff/000?text=||||||||||||||||" alt="barcode" class="w-100 mt-2">
            </div>
        </div>
        
        <div class="position-absolute bg-dark opacity-50 w-100 h-100"></div>
    </div>

    <!-- Action Area -->
    <div class="position-absolute w-100 text-center" style="bottom: 40px; z-index: 10;">
        <form action="<?= base_url('parkingout/confirm') ?>" method="post">
            <input type="hidden" name="receipt" value="SP-12345">
            <button type="submit" class="btn btn-light fw-bold px-5 py-2" style="border-radius: 20px;">
                MASUKKAN MANUAL
            </button>
        </form>
    </div>
</div>

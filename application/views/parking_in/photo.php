<div style="background-color: #000; height: 100vh; position: relative;">
    
    <!-- Top Action Bar -->
    <div class="d-flex justify-content-between p-3 position-absolute w-100" style="z-index: 10; top: 0;">
        <a href="<?= base_url('dashboard') ?>" class="text-white text-decoration-none fs-4"><i class="bi bi-x-lg"></i></a>
        <a href="#" class="text-white text-decoration-none fs-4"><i class="bi bi-arrow-repeat"></i></a>
    </div>

    <!-- Camera Viewfinder (Simulated) -->
    <div class="d-flex align-items-center justify-content-center h-100" style="background: url('https://placehold.co/400x600/333/666?text=Camera+Feed') center center/cover;">
        <!-- Grid lines for alignment -->
        <div style="width: 80%; height: 60%; border: 2px solid rgba(255,255,255,0.5); position: relative;">
            <div style="position: absolute; top: 33%; left: 0; right: 0; border-top: 1px solid rgba(255,255,255,0.3);"></div>
            <div style="position: absolute; top: 66%; left: 0; right: 0; border-top: 1px solid rgba(255,255,255,0.3);"></div>
            <div style="position: absolute; top: 0; bottom: 0; left: 33%; border-left: 1px solid rgba(255,255,255,0.3);"></div>
            <div style="position: absolute; top: 0; bottom: 0; left: 66%; border-left: 1px solid rgba(255,255,255,0.3);"></div>
        </div>
    </div>

    <!-- Capture Area -->
    <div class="position-absolute w-100 text-center" style="bottom: 30px; z-index: 10;">
        <a href="<?= base_url('parkingin/save') ?>" class="btn btn-danger rounded-circle mb-3 d-inline-flex justify-content-center align-items-center" style="width: 70px; height: 70px;">
            <i class="bi bi-camera-fill fs-2"></i>
        </a>
        <div class="bg-dark text-white p-2 mx-auto rounded" style="width: 80%;">
            <div class="fw-bold fs-5">WAKTU: <?= date('H:i:s d M Y') ?></div>
            <small>Ambil Foto Plat/Kendaraan</small>
        </div>
    </div>
</div>

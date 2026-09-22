<div style="background-color: #000; height: 100vh; position: relative;">
    
    <!-- Top Action Bar -->
    <div class="d-flex justify-content-between p-3 position-absolute w-100" style="z-index: 10; top: 0;">
        <a href="<?= base_url('dashboard') ?>" class="text-white text-decoration-none fs-4"><i class="bi bi-x-lg"></i></a>
        <a href="#" class="text-white text-decoration-none fs-4"><i class="bi bi-arrow-repeat"></i></a>
    </div>

    <!-- Real Camera Viewfinder -->
    <div class="d-flex align-items-center justify-content-center h-100 position-relative overflow-hidden">
        <video id="camera-stream" autoplay playsinline style="width: 100%; height: 100%; object-fit: cover;"></video>
        
        <!-- Grid lines for alignment -->
        <div style="width: 80%; height: 60%; border: 2px solid rgba(255,255,255,0.5); position: absolute; z-index: 5;">
            <div style="position: absolute; top: 33%; left: 0; right: 0; border-top: 1px solid rgba(255,255,255,0.3);"></div>
            <div style="position: absolute; top: 66%; left: 0; right: 0; border-top: 1px solid rgba(255,255,255,0.3);"></div>
            <div style="position: absolute; top: 0; bottom: 0; left: 33%; border-left: 1px solid rgba(255,255,255,0.3);"></div>
            <div style="position: absolute; top: 0; bottom: 0; left: 66%; border-left: 1px solid rgba(255,255,255,0.3);"></div>
        </div>
    </div>

    <!-- Capture Area -->
    <div class="position-absolute w-100 text-center" style="bottom: 30px; z-index: 10;">
        <button id="capture-btn" class="btn btn-danger rounded-circle mb-3 d-inline-flex justify-content-center align-items-center" style="width: 70px; height: 70px; box-shadow: 0 0 15px rgba(255,0,0,0.5); border: 2px solid white;">
            <i class="bi bi-camera-fill fs-2"></i>
        </button>
        <div class="bg-dark text-white p-2 mx-auto rounded" style="width: 80%; opacity: 0.9;">
            <div class="fw-bold fs-5">WAKTU: <?= date('H:i:s d M Y') ?></div>
            <small>Ambil Foto Plat/Kendaraan</small>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div id="loading-overlay" class="position-fixed w-100 h-100 d-none flex-column align-items-center justify-content-center" style="top: 0; left: 0; background: rgba(0,0,0,0.8); z-index: 9999;">
    <div class="spinner-border text-light mb-3" role="status" style="width: 3rem; height: 3rem;"></div>
    <h5 class="text-white fw-bold">Mengekstrak Plat Nomor...</h5>
    <small class="text-white-50">Mohon tunggu, proses ini mungkin memakan waktu beberapa detik.</small>
</div>

<!-- Hidden Canvas for Snapshot -->
<canvas id="snapshot-canvas" class="d-none"></canvas>

<!-- Hidden form to submit captured data -->
<form id="ocr-form" action="<?= base_url('parkingin/save') ?>" method="post" class="d-none">
    <input type="hidden" name="plate_number" id="plate_number">
    <input type="hidden" name="photo_base64" id="photo_base64">
</form>

<!-- Tesseract.js -->
<script src='https://cdn.jsdelivr.net/npm/tesseract.js@5/dist/tesseract.min.js'></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const video = document.getElementById('camera-stream');
        const canvas = document.getElementById('snapshot-canvas');
        const captureBtn = document.getElementById('capture-btn');
        const loadingOverlay = document.getElementById('loading-overlay');
        const ocrForm = document.getElementById('ocr-form');
        const plateInput = document.getElementById('plate_number');
        const photoInput = document.getElementById('photo_base64');

        // Request access to the camera (prefer back camera on mobile)
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ 
                video: { facingMode: "environment" } 
            })
            .then(function(stream) {
                video.srcObject = stream;
            })
            .catch(function(error) {
                console.error("Error accessing the camera: ", error);
                alert("Tidak dapat mengakses kamera. Pastikan Anda telah memberikan izin dan mengakses web melalui localhost atau HTTPS.");
            });
        } else {
            alert("Browser ini tidak mendukung akses kamera.");
        }

        // Capture Button Event
        captureBtn.addEventListener('click', async function() {
            // 1. Show Loading Overlay
            loadingOverlay.classList.remove('d-none');
            loadingOverlay.classList.add('d-flex');
            
            // 2. Draw current video frame to canvas
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            const context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            
            // 3. Get Base64 image
            const base64Image = canvas.toDataURL('image/jpeg');
            photoInput.value = base64Image;

            try {
                // 4. Run Tesseract OCR on the image
                const worker = await Tesseract.createWorker('eng');
                const ret = await worker.recognize(base64Image);
                await worker.terminate();
                
                // 5. Clean up OCR text (remove non-alphanumeric, newlines, etc.)
                let text = ret.data.text.replace(/[^a-zA-Z0-9]/g, "").toUpperCase();
                
                // Set fallback if empty
                if (!text || text.trim() === '') {
                    text = "UNREADABLE";
                }

                plateInput.value = text;
                
                // 6. Submit the form
                ocrForm.submit();

            } catch (err) {
                console.error("OCR Error:", err);
                // Even if OCR fails, we submit with "ERROR" so the flow isn't blocked completely
                plateInput.value = "ERROR";
                ocrForm.submit();
            }
        });
    });
</script>

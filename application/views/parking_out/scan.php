<div style="background-color: #000; height: 100vh; position: relative; overflow: hidden;">
    
    <!-- Top Action Bar -->
    <div class="d-flex justify-content-between p-3 position-absolute w-100" style="z-index: 10; top: 0;">
        <a href="<?= base_url('dashboard') ?>" class="text-white text-decoration-none fs-4"><i class="bi bi-x-lg"></i></a>
    </div>

    <!-- Real Camera Viewfinder Container for html5-qrcode -->
    <div id="qr-reader" style="width: 100%; height: 100%; position: absolute; top: 0; left: 0; z-index: 1;"></div>
    
    <!-- Overlay -->
    <div class="d-flex flex-column align-items-center justify-content-center h-100 position-relative pointer-events-none" style="z-index: 5; background: rgba(0,0,0,0.4); pointer-events: none;">
        <h5 class="text-white mb-4 fw-bold">PINDAI QR KODE RESI</h5>
        
        <!-- Scanner Frame -->
        <div style="width: 250px; height: 250px; border: 2px solid rgba(255, 255, 255, 0.8); border-radius: 12px; position: relative; box-shadow: 0 0 0 9999px rgba(0, 0, 0, 0.5);">
            <!-- Scanning laser line -->
            <div style="width: 100%; height: 2px; background-color: red; position: absolute; top: 50%; box-shadow: 0 0 10px red;"></div>
        </div>
        <small class="text-white mt-3" id="scan-status">Mencari QR Code...</small>
    </div>

    <!-- Action Area -->
    <div class="position-absolute w-100 text-center" style="bottom: 40px; z-index: 10;">
        <form id="scan-form" action="<?= base_url('parkingout/confirm') ?>" method="post">
            <input type="hidden" name="tarif_id" value="<?= isset($tarif_id) ? $tarif_id : '' ?>">
            <!-- Will be populated by QR scanner, or fallback manual if empty -->
            <input type="hidden" name="receipt" id="receipt-input" value="SP-12345">
            <button type="button" onclick="manualEntry()" class="btn btn-light fw-bold px-5 py-2" style="border-radius: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.3);">
                MASUKKAN MANUAL
            </button>
        </form>
    </div>
</div>

<!-- SweetAlert2 for nice popups -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- HTML5 QR Code Library -->
<script src="https://unpkg.com/html5-qrcode"></script>

<script>
    // Check for validation errors from controller
    <?php if ($this->session->flashdata('error')): ?>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '<?= $this->session->flashdata('error') ?>',
            confirmButtonColor: '#d33'
        });
    <?php endif; ?>

    let html5QrCode;

    document.addEventListener("DOMContentLoaded", function() {
        const scanStatus = document.getElementById('scan-status');
        const receiptInput = document.getElementById('receipt-input');
        const scanForm = document.getElementById('scan-form');

        html5QrCode = new Html5Qrcode("qr-reader");

        const qrCodeSuccessCallback = (decodedText, decodedResult) => {
            // Stop scanning once we get a result to prevent multiple submissions
            if(html5QrCode) {
                html5QrCode.stop().then(() => {
                    scanStatus.innerText = "QR Code Ditemukan: " + decodedText;
                    receiptInput.value = decodedText;
                    scanForm.submit();
                }).catch(err => {
                    console.error("Failed to stop scanner", err);
                });
            }
        };

        const config = { fps: 10, qrbox: { width: 250, height: 250 }, aspectRatio: 1.0 };

        // Start scanning, prefer back camera
        html5QrCode.start({ facingMode: "environment" }, config, qrCodeSuccessCallback)
        .catch(err => {
            console.error("Error starting camera: ", err);
            scanStatus.innerText = "Error kamera. Gunakan tombol manual.";
            alert("Tidak dapat mengakses kamera. Pastikan Anda telah memberikan izin dan mengakses web melalui localhost atau HTTPS.");
        });
    });

    function manualEntry() {
        // If they click manual, ask for a receipt number prompt, or just submit the mock
        let manualReceipt = prompt("Masukkan Nomor Resi:", "SP-12345");
        if (manualReceipt != null && manualReceipt != "") {
            document.getElementById('receipt-input').value = manualReceipt;
            document.getElementById('scan-form').submit();
        }
    }
</script>

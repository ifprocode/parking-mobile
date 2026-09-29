                                                            <div class="container text-center mt-3">
    
    <div class="card p-4">
        <h5 class="fw-bold mb-3">SIMPAN BERHASIL</h5>
        
        <!-- Placeholder for QR Code generation, normally done dynamically with a library -->
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?= $receipt ?>" alt="QR Code" class="img-fluid mx-auto mb-3" style="width: 150px; height: 150px;">
        
        <h6 class="fw-bold">NOMOR RESI: <?= $receipt ?></h6>
        
        <div class="row text-start mt-3">
            <div class="col-6 fw-bold align-self-center">Plat</div>
            <div class="col-6">
                <div class="input-group input-group-sm">
                    <input type="text" class="form-control fw-bold text-success" id="plate-input" value="<?= $plate ?>" maxlength="10">
                    <button class="btn btn-outline-secondary" type="button" id="btn-update-plate" title="Simpan Perubahan"><i class="bi bi-check-lg"></i></button>
                </div>
                <small id="update-status" class="text-success d-none" style="font-size: 0.7rem;">Berhasil diupdate!</small>
            </div>
            
            <div class="col-6 fw-bold mt-2">Waktu Masuk</div>
            <div class="col-6 mt-2"><?= $time_in ?></div>
            
            <div class="col-6 fw-bold mt-2">Total Tarif</div>
            <div class="col-6 mt-2">Rp <?= number_format(isset($total_fare) ? $total_fare : 0, 0, ',', '.') ?></div>
            
            <div class="col-6 fw-bold mt-2">Status</div>
            <div class="col-6 mt-2"><span class="badge bg-success fs-6">LUNAS</span></div>
        </div>
        
        <div class="mt-3 p-2 border rounded">
            <img src="<?= $photo_src ?>" alt="Car" class="img-fluid rounded shadow-sm" style="max-height: 150px; width: 100%; object-fit: cover;">
            <small class="text-muted d-block mt-2">Captured Kendaraan</small>
        </div>
    </div>

    <button id="btnCetakIframe" type="button" class="btn btn-primary btn-lg w-100 mt-4 mb-2 d-flex justify-content-center align-items-center text-decoration-none" data-url="<?= base_url('parkingin/print_ticket/' . $receipt) ?>">
        <i class="bi bi-printer-fill me-2"></i> CETAK STRUK
    </button>

    <a href="<?= base_url('parkingin/photo/' . (isset($tarif_id) ? $tarif_id : '')) ?>" class="btn btn-outline-primary btn-lg w-100 mb-3 fw-bold d-flex justify-content-center align-items-center text-decoration-none">
        <i class="bi bi-camera-fill me-2"></i> CAPTURE LAGI (<?= isset($tarif_name) && $tarif_name ? strtoupper($tarif_name) : 'TARIF SAMA' ?>)
    </a>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const btnUpdate = document.getElementById('btn-update-plate');
    const plateInput = document.getElementById('plate-input');
    const statusText = document.getElementById('update-status');

    function updatePlate(callback) {
        const newPlate = plateInput.value;
        const receipt = "<?= $receipt ?>";
        
        // Change icon to loading briefly
        btnUpdate.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
        
        // AJAX call to update the plate in the database
        const formData = new FormData();
        formData.append('receipt', receipt);
        formData.append('plate', newPlate);

        fetch('<?= base_url('parkingin/update_plate') ?>', { 
            method: 'POST', 
            body: formData 
        })
        .then(response => response.json())
        .then(data => {
            if(data.status === 'success') {
                btnUpdate.innerHTML = '<i class="bi bi-check-lg"></i>';
                btnUpdate.classList.remove('btn-outline-secondary');
                btnUpdate.classList.add('btn-success');
                statusText.classList.remove('d-none');
                
                setTimeout(() => {
                    statusText.classList.add('d-none');
                    btnUpdate.classList.remove('btn-success');
                    btnUpdate.classList.add('btn-outline-secondary');
                }, 2000);
            }
            if (callback) callback();
        }).catch(() => {
            btnUpdate.innerHTML = '<i class="bi bi-x-lg"></i>';
            if (callback) callback();
        });
    }

    btnUpdate.addEventListener('click', function() {
        updatePlate();
    });

    const btnCetakIframe = document.getElementById('btnCetakIframe');
    if (btnCetakIframe) {
        btnCetakIframe.addEventListener('click', function() {
            const url = this.getAttribute('data-url');
            
            // Show loading on print button
            btnCetakIframe.disabled = true;
            const originalHTML = btnCetakIframe.innerHTML;
            btnCetakIframe.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Menyiapkan...';
            
            // Update plate first, then print
            updatePlate(function() {
                btnCetakIframe.innerHTML = originalHTML;
                btnCetakIframe.disabled = false;
                
                let iframe = document.getElementById('print-iframe');
                
                if (!iframe) {
                    iframe = document.createElement('iframe');
                    iframe.id = 'print-iframe';
                    iframe.style.display = 'none';
                    document.body.appendChild(iframe);
                }
                
                // The iframe src loading will trigger window.print() inside the iframe due to onload="window.print()" in the ticket HTML
                iframe.src = url;
            });
        });
    }
});
</script>

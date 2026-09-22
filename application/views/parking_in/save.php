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
                    <input type="text" class="form-control fw-bold text-success" id="plate-input" value="<?= $plate ?>">
                    <button class="btn btn-outline-secondary" type="button" id="btn-update-plate" title="Simpan Perubahan"><i class="bi bi-check-lg"></i></button>
                </div>
                <small id="update-status" class="text-success d-none" style="font-size: 0.7rem;">Berhasil diupdate!</small>
            </div>
            
            <div class="col-6 fw-bold">Waktu Masuk</div>
            <div class="col-6"><?= $time_in ?></div>
        </div>
        
        <div class="mt-3 p-2 border rounded">
            <img src="<?= $photo_src ?>" alt="Car" class="img-fluid rounded shadow-sm" style="max-height: 150px; width: 100%; object-fit: cover;">
            <small class="text-muted d-block mt-2">Captured Kendaraan</small>
        </div>
    </div>

    <a href="<?= base_url('parkingin/print_ticket/' . $receipt) ?>" target="_blank" class="btn btn-primary btn-lg w-100 mt-4 mb-3 d-flex justify-content-center align-items-center text-decoration-none">
        <i class="bi bi-printer-fill me-2"></i> CETAK STRUK
    </a>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const btnUpdate = document.getElementById('btn-update-plate');
    const plateInput = document.getElementById('plate-input');
    const statusText = document.getElementById('update-status');

    btnUpdate.addEventListener('click', function() {
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
        });
    });
});
</script>

<div class="container d-flex flex-column justify-content-center align-items-center" style="min-height: 80vh;">
    
    <div class="text-center mb-4">
        <h4 class="fw-bold text-secondary">Register</h4>
    </div>

    <div class="card w-100 p-4">
        <form action="<?= base_url('auth/register') ?>" method="post">
            <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger" role="alert">
                    <?= $this->session->flashdata('error') ?>
                </div>
            <?php endif; ?>

            <div class="mb-3">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>

            <div class="mb-4">
                <label for="gate" class="form-label">Gate</label>
                <select class="form-control" id="gate" name="gate" required>
                    <option value="" disabled selected>Pilih Gate</option>
                    <option value="Mobil">Mobil</option>
                    <option value="Motor">Motor</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-100 btn-lg mb-3">REGISTER</button>
            
            <div class="text-center">
                <a href="<?= base_url('auth/login') ?>" class="text-decoration-none">Sudah punya akun? Sign In</a>
            </div>
        </form>
    </div>
</div>

<div class="container d-flex flex-column justify-content-center align-items-center" style="min-height: 80vh;">
    
    <div class="text-center mb-4">
        <h4 class="fw-bold text-secondary">Lupa Password</h4>
    </div>

    <div class="card w-100 p-4">
        <form action="<?= base_url('auth/forgot_password') ?>" method="post">
            <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger" role="alert">
                    <?= $this->session->flashdata('error') ?>
                </div>
            <?php endif; ?>

            <div class="mb-3">
                <label for="email" class="form-label">Email Anda</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            
            <div class="mb-4">
                <label for="new_password" class="form-label">Password Baru</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
            </div>
            
            <button type="submit" class="btn btn-primary w-100 btn-lg mb-3">RESET PASSWORD</button>
            
            <div class="text-center">
                <a href="<?= base_url('auth/login') ?>" class="text-decoration-none">Kembali ke Login</a>
            </div>
        </form>
    </div>
</div>

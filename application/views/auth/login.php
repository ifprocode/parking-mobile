<div class="container d-flex flex-column justify-content-center align-items-center" style="min-height: 80vh;">
    
    <div class="text-center mb-4">
        <h4 class="fw-bold text-secondary">Sign In</h4>
    </div>

    <div class="card w-100 p-4">
        <form action="<?= base_url('auth/login') ?>" method="post">
            <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger" role="alert">
                    <?= $this->session->flashdata('error') ?>
                </div>
            <?php endif; ?>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="admin@smartpark.com" required>
            </div>
            
            <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" value="admin" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">Remember Me</label>
            </div>

            <button type="submit" class="btn btn-primary w-100 btn-lg mb-3">LOGIN</button>
            
            <div class="text-center">
                <a href="<?= base_url('auth/forgot_password') ?>" class="text-decoration-none">Lupa Password?</a>
            </div>
        </form>
    </div>
</div>

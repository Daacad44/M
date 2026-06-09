<?php $pageTitle = 'Login'; ?>
<h4 class="text-center mb-4">Welcome Back</h4>
<form method="POST" action="<?= url('login') ?>">
    <?= Security::csrfField() ?>
    <div class="mb-3">
        <label class="form-label">Email Address</label>
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            <input type="email" name="email" class="form-control" value="<?= old('email') ?>" required autofocus>
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">Password</label>
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-lock"></i></span>
            <input type="password" name="password" class="form-control" required>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="form-check">
            <input type="checkbox" name="remember" class="form-check-input" id="remember">
            <label class="form-check-label" for="remember">Remember Me</label>
        </div>
        <a href="<?= url('forgot-password') ?>" class="text-decoration-none small">Forgot Password?</a>
    </div>
    <button type="submit" class="btn btn-primary w-100 btn-lg">Login</button>
</form>
<p class="text-center mt-4 mb-0">Don't have an account? <a href="<?= url('register') ?>">Register</a></p>

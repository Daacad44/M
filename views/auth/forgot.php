<?php $pageTitle = 'Forgot Password'; ?>
<h4 class="text-center mb-4">Reset Password</h4>
<p class="text-muted text-center mb-4">Enter your email address and we'll send you a link to reset your password.</p>
<form method="POST" action="<?= url('forgot-password') ?>">
    <?= Security::csrfField() ?>
    <div class="mb-4">
        <label class="form-label">Email Address</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
</form>
<p class="text-center mt-4 mb-0"><a href="<?= url('login') ?>">Back to Login</a></p>

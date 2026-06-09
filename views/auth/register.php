<?php $pageTitle = 'Register'; ?>
<h4 class="text-center mb-4">Create Account</h4>
<form method="POST" action="<?= url('register') ?>">
    <?= Security::csrfField() ?>
    <div class="mb-3">
        <label class="form-label">Full Name</label>
        <input type="text" name="full_name" class="form-control" value="<?= old('full_name') ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Email Address</label>
        <input type="email" name="email" class="form-control" value="<?= old('email') ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Phone Number</label>
        <input type="tel" name="phone" class="form-control" value="<?= old('phone') ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" minlength="8" required>
    </div>
    <div class="mb-4">
        <label class="form-label">Confirm Password</label>
        <input type="password" name="confirm_password" class="form-control" minlength="8" required>
    </div>
    <button type="submit" class="btn btn-primary w-100 btn-lg">Register</button>
</form>
<p class="text-center mt-4 mb-0">Already have an account? <a href="<?= url('login') ?>">Login</a></p>

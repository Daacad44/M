<?php $pageTitle = 'Reset Password'; ?>
<h4 class="text-center mb-4">Set New Password</h4>
<form method="POST" action="<?= url('reset-password/' . $token) ?>">
    <?= Security::csrfField() ?>
    <div class="mb-3">
        <label class="form-label">New Password</label>
        <input type="password" name="password" class="form-control" minlength="8" required>
    </div>
    <div class="mb-4">
        <label class="form-label">Confirm Password</label>
        <input type="password" name="confirm_password" class="form-control" minlength="8" required>
    </div>
    <button type="submit" class="btn btn-primary w-100">Reset Password</button>
</form>

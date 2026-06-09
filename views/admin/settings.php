<?php $pageTitle = 'Settings'; ?>
<h4 class="fw-bold mb-4">System Settings</h4>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="POST" action="<?= url('admin/settings') ?>">
            <?= Security::csrfField() ?>
            <h6 class="fw-bold mb-3">General</h6>
            <div class="row g-3 mb-4">
                <div class="col-md-4"><label class="form-label">Site Name</label><input type="text" name="site_name" class="form-control" value="<?= e($settings['site_name'] ?? '') ?>"></div>
                <div class="col-md-4"><label class="form-label">Site Email</label><input type="email" name="site_email" class="form-control" value="<?= e($settings['site_email'] ?? '') ?>"></div>
                <div class="col-md-4"><label class="form-label">Site Phone</label><input type="text" name="site_phone" class="form-control" value="<?= e($settings['site_phone'] ?? '') ?>"></div>
            </div>
            <h6 class="fw-bold mb-3">SMTP Configuration</h6>
            <div class="row g-3 mb-4">
                <div class="col-md-3"><label class="form-label">Host</label><input type="text" name="smtp_host" class="form-control" value="<?= e($settings['smtp_host'] ?? '') ?>"></div>
                <div class="col-md-2"><label class="form-label">Port</label><input type="text" name="smtp_port" class="form-control" value="<?= e($settings['smtp_port'] ?? '587') ?>"></div>
                <div class="col-md-3"><label class="form-label">Username</label><input type="text" name="smtp_username" class="form-control" value="<?= e($settings['smtp_username'] ?? '') ?>"></div>
                <div class="col-md-4"><label class="form-label">Password</label><input type="password" name="smtp_password" class="form-control" value="<?= e($settings['smtp_password'] ?? '') ?>"></div>
            </div>
            <h6 class="fw-bold mb-3">Payment Gateways</h6>
            <div class="row g-3 mb-4">
                <div class="col-md-6"><label class="form-label">Stripe Public Key</label><input type="text" name="stripe_public_key" class="form-control" value="<?= e($settings['stripe_public_key'] ?? '') ?>"></div>
                <div class="col-md-6"><label class="form-label">Stripe Secret Key</label><input type="password" name="stripe_secret_key" class="form-control" value="<?= e($settings['stripe_secret_key'] ?? '') ?>"></div>
                <div class="col-md-6"><label class="form-label">PayPal Client ID</label><input type="text" name="paypal_client_id" class="form-control" value="<?= e($settings['paypal_client_id'] ?? '') ?>"></div>
            </div>
            <button type="submit" class="btn btn-primary">Save Settings</button>
        </form>
    </div>
</div>

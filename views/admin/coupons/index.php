<?php $pageTitle = 'Coupons'; ?>
<div class="d-flex justify-content-between mb-4">
    <h4 class="fw-bold mb-0">Coupons</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCouponModal"><i class="fas fa-plus me-1"></i>Add Coupon</button>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <table class="table table-hover data-table">
            <thead><tr><th>Code</th><th>Type</th><th>Value</th><th>Used</th><th>Expires</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
                <?php foreach ($coupons as $c): ?>
                <tr>
                    <td><strong><?= e($c['code']) ?></strong></td>
                    <td><?= ucfirst($c['discount_type']) ?></td>
                    <td><?= $c['discount_type'] === 'percentage' ? $c['discount_value'] . '%' : formatMoney($c['discount_value']) ?></td>
                    <td><?= $c['used_count'] ?>/<?= $c['max_uses'] ?? '∞' ?></td>
                    <td><?= $c['expires_at'] ? formatDate($c['expires_at']) : 'Never' ?></td>
                    <td><span class="badge bg-<?= $c['status'] === 'active' ? 'success' : 'secondary' ?>"><?= ucfirst($c['status']) ?></span></td>
                    <td><form method="POST" action="<?= url('admin/coupons/delete/' . $c['id']) ?>" class="d-inline" onsubmit="return confirm('Delete?')"><?= Security::csrfField() ?><button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button></form></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="addCouponModal" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content">
        <form method="POST" action="<?= url('admin/coupons/store') ?>">
            <?= Security::csrfField() ?>
            <div class="modal-header"><h5 class="modal-title">Add Coupon</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <div class="mb-3"><label class="form-label">Code</label><input type="text" name="code" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Description</label><input type="text" name="description" class="form-control"></div>
                <div class="row"><div class="col-6 mb-3"><label class="form-label">Type</label><select name="discount_type" class="form-select"><option value="percentage">Percentage</option><option value="fixed">Fixed</option></select></div>
                <div class="col-6 mb-3"><label class="form-label">Value</label><input type="number" step="0.01" name="discount_value" class="form-control" required></div></div>
                <div class="row"><div class="col-6 mb-3"><label class="form-label">Min Amount</label><input type="number" step="0.01" name="min_amount" class="form-control" value="0"></div>
                <div class="col-6 mb-3"><label class="form-label">Max Uses</label><input type="number" name="max_uses" class="form-control"></div></div>
                <div class="mb-3"><label class="form-label">Expires</label><input type="datetime-local" name="expires_at" class="form-control"></div>
            </div>
            <div class="modal-footer"><button type="submit" class="btn btn-primary">Save</button></div>
        </form>
    </div></div>
</div>

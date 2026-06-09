<?php $pageTitle = 'Payments'; ?>
<h4 class="fw-bold mb-4">Payments</h4>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <table class="table table-hover data-table">
            <thead><tr><th>Transaction</th><th>Booking</th><th>User</th><th>Method</th><th>Amount</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
                <?php foreach ($payments as $p): ?>
                <tr>
                    <td><small><?= e($p['transaction_id'] ?? '-') ?></small></td>
                    <td><?= e($p['booking_reference']) ?></td>
                    <td><?= e($p['user_name']) ?></td>
                    <td><?= ucfirst(str_replace('_', ' ', $p['payment_method'])) ?></td>
                    <td><?= formatMoney($p['amount']) ?></td>
                    <td><?= paymentStatusBadge($p['status']) ?></td>
                    <td>
                        <?php if ($p['status'] === 'pending'): ?>
                        <form method="POST" action="<?= url('admin/payments/approve/' . $p['id']) ?>" class="d-inline"><?= Security::csrfField() ?><button class="btn btn-sm btn-success">Approve</button></form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

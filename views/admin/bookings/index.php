<?php $pageTitle = 'Bookings'; ?>
<h4 class="fw-bold mb-4">Bookings</h4>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <table class="table table-hover data-table">
            <thead><tr><th>Reference</th><th>User</th><th>Class</th><th>Amount</th><th>Status</th><th>Date</th><th>Actions</th></tr></thead>
            <tbody>
                <?php foreach ($bookings as $b): ?>
                <tr>
                    <td><strong><?= e($b['booking_reference']) ?></strong></td>
                    <td><?= e($b['user_name']) ?></td>
                    <td><?= cabinClassLabel($b['cabin_class']) ?></td>
                    <td><?= formatMoney($b['final_amount']) ?></td>
                    <td><?= bookingStatusBadge($b['status']) ?></td>
                    <td><?= formatDate($b['created_at']) ?></td>
                    <td>
                        <form method="POST" action="<?= url('admin/bookings/status/' . $b['id']) ?>" class="d-inline">
                            <?= Security::csrfField() ?>
                            <select name="status" class="form-select form-select-sm d-inline-block w-auto" onchange="this.form.submit()">
                                <?php foreach (['pending','confirmed','cancelled','completed'] as $s): ?>
                                <option value="<?= $s ?>" <?= $b['status'] === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

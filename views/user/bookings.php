<?php $pageTitle = 'My Bookings'; ?>
<div class="p-4">
    <h3 class="fw-bold mb-4">My Bookings</h3>
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <table class="table table-hover data-table">
                <thead>
                    <tr>
                        <th>Reference</th>
                        <th>Class</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $b): ?>
                    <tr>
                        <td><strong><?= e($b['booking_reference']) ?></strong></td>
                        <td><?= cabinClassLabel($b['cabin_class']) ?></td>
                        <td><?= formatMoney($b['final_amount']) ?></td>
                        <td><?= bookingStatusBadge($b['status']) ?></td>
                        <td><?= formatDate($b['created_at']) ?></td>
                        <td>
                            <a href="<?= url('user/bookings/' . $b['id']) ?>" class="btn btn-sm btn-outline-primary">View</a>
                            <?php if ($b['status'] === 'pending'): ?>
                            <a href="<?= url('payment/' . $b['id']) ?>" class="btn btn-sm btn-primary">Pay</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

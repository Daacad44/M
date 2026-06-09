<?php $pageTitle = 'Passengers'; ?>
<h4 class="fw-bold mb-4">Passengers</h4>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <table class="table table-hover data-table">
            <thead><tr><th>Name</th><th>Type</th><th>Passport</th><th>Booking</th><th>Date</th></tr></thead>
            <tbody>
                <?php foreach ($passengers as $p): ?>
                <tr>
                    <td><?= e($p['first_name'] . ' ' . $p['last_name']) ?></td>
                    <td><?= ucfirst($p['passenger_type']) ?></td>
                    <td><?= e($p['passport_number'] ?? '-') ?></td>
                    <td><?= e($p['booking_reference']) ?></td>
                    <td><?= formatDate($p['created_at']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

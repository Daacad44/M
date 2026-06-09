<?php $pageTitle = 'Manage Flights'; ?>
<div class="d-flex justify-content-between mb-4">
    <h4 class="fw-bold mb-0">Flights</h4>
    <a href="<?= url('admin/flights/create') ?>" class="btn btn-primary"><i class="fas fa-plus me-1"></i>Add Flight</a>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <table class="table table-hover data-table">
            <thead><tr><th>Flight</th><th>Airline</th><th>Route</th><th>Departure</th><th>Economy</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
                <?php foreach ($flights as $f): ?>
                <tr>
                    <td><strong><?= e($f['flight_number']) ?></strong></td>
                    <td><?= e($f['airline_name']) ?></td>
                    <td><?= e($f['departure_code']) ?> → <?= e($f['arrival_code']) ?></td>
                    <td><?= formatDateTime($f['departure_time']) ?></td>
                    <td><?= formatMoney($f['economy_price']) ?></td>
                    <td><span class="badge bg-<?= $f['status'] === 'scheduled' ? 'success' : 'warning' ?>"><?= ucfirst($f['status']) ?></span></td>
                    <td>
                        <a href="<?= url('admin/flights/edit/' . $f['id']) ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                        <form method="POST" action="<?= url('admin/flights/delete/' . $f['id']) ?>" class="d-inline" onsubmit="return confirm('Delete?')">
                            <?= Security::csrfField() ?>
                            <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

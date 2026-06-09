<?php $pageTitle = 'Reports'; ?>
<h4 class="fw-bold mb-4">Generate Reports</h4>
<div class="row g-4">
    <?php foreach (['flights' => 'Flights', 'revenue' => 'Revenue', 'bookings' => 'Bookings', 'passengers' => 'Passengers'] as $type => $label): ?>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-center p-4">
            <i class="fas fa-file-<?= $type === 'revenue' ? 'invoice-dollar' : 'alt' ?> fa-3x text-primary mb-3"></i>
            <h5><?= $label ?> Report</h5>
            <form method="POST" action="<?= url('admin/reports/generate') ?>">
                <?= Security::csrfField() ?>
                <input type="hidden" name="report_type" value="<?= $type ?>">
                <button type="submit" class="btn btn-primary btn-sm mt-2"><i class="fas fa-download me-1"></i>Export CSV</button>
            </form>
        </div>
    </div>
    <?php endforeach; ?>
</div>

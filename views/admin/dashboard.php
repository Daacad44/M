<?php $pageTitle = 'Admin Dashboard'; ?>
<div class="row g-4 mb-4">
    <div class="col-xl-2 col-md-4">
        <div class="card border-0 shadow-sm stat-card">
            <div class="card-body text-center">
                <i class="fas fa-users fa-2x text-primary mb-2"></i>
                <h3 class="mb-0"><?= number_format($stats['users']) ?></h3>
                <small class="text-muted">Users</small>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4">
        <div class="card border-0 shadow-sm stat-card">
            <div class="card-body text-center">
                <i class="fas fa-plane fa-2x text-success mb-2"></i>
                <h3 class="mb-0"><?= number_format($stats['flights']) ?></h3>
                <small class="text-muted">Flights</small>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4">
        <div class="card border-0 shadow-sm stat-card">
            <div class="card-body text-center">
                <i class="fas fa-ticket-alt fa-2x text-info mb-2"></i>
                <h3 class="mb-0"><?= number_format($stats['bookings']) ?></h3>
                <small class="text-muted">Bookings</small>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm stat-card">
            <div class="card-body text-center">
                <i class="fas fa-dollar-sign fa-2x text-warning mb-2"></i>
                <h3 class="mb-0"><?= formatMoney($stats['revenue']) ?></h3>
                <small class="text-muted">Revenue</small>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm stat-card">
            <div class="card-body text-center">
                <i class="fas fa-clock fa-2x text-danger mb-2"></i>
                <h3 class="mb-0"><?= number_format($stats['pending_payments']) ?></h3>
                <small class="text-muted">Pending Payments</small>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold">Monthly Revenue</div>
            <div class="card-body"><canvas id="revenueChart" height="100"></canvas></div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold">Popular Destinations</div>
            <div class="card-body">
                <?php foreach ($popularDestinations as $dest): ?>
                <div class="d-flex justify-content-between mb-2">
                    <span><?= e($dest['city'] ?? 'N/A') ?> (<?= e($dest['code'] ?? '') ?>)</span>
                    <span class="badge bg-primary"><?= $dest['booking_count'] ?? 0 ?></span>
                </div>
                <?php endforeach; ?>
                <?php if (empty($popularDestinations)): ?>
                <p class="text-muted small">No data yet</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold">Booking Trends (30 Days)</div>
            <div class="card-body"><canvas id="bookingChart" height="120"></canvas></div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold">Recent Bookings</div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead><tr><th>Reference</th><th>User</th><th>Amount</th><th>Status</th></tr></thead>
                    <tbody>
                        <?php foreach ($recentBookings as $b): ?>
                        <tr>
                            <td><?= e($b['booking_reference']) ?></td>
                            <td><?= e($b['user_name']) ?></td>
                            <td><?= formatMoney($b['final_amount']) ?></td>
                            <td><?= bookingStatusBadge($b['status']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const revenueData = <?= json_encode(array_reverse($monthlyRevenue)) ?>;
    new Chart(document.getElementById('revenueChart'), {
        type: 'bar',
        data: {
            labels: revenueData.map(d => d.month),
            datasets: [{ label: 'Revenue', data: revenueData.map(d => d.revenue), backgroundColor: '#0d6efd' }]
        },
        options: { responsive: true, plugins: { legend: { display: false } } }
    });

    const trendData = <?= json_encode($bookingTrends) ?>;
    new Chart(document.getElementById('bookingChart'), {
        type: 'line',
        data: {
            labels: trendData.map(d => d.date),
            datasets: [{ label: 'Bookings', data: trendData.map(d => d.count), borderColor: '#198754', tension: 0.3, fill: false }]
        },
        options: { responsive: true, plugins: { legend: { display: false } } }
    });
});
</script>

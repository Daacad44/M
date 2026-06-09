<?php $pageTitle = 'Dashboard'; ?>
<div class="p-4">
    <h3 class="fw-bold mb-4">Welcome, <?= e(Session::get('user_name')) ?>!</h3>
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm stat-card">
                <div class="card-body d-flex align-items-center">
                    <div class="stat-icon bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                        <i class="fas fa-plane-departure fa-2x text-primary"></i>
                    </div>
                    <div>
                        <h3 class="mb-0"><?= count($upcoming) ?></h3>
                        <small class="text-muted">Upcoming Trips</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm stat-card">
                <div class="card-body d-flex align-items-center">
                    <div class="stat-icon bg-success bg-opacity-10 rounded-circle p-3 me-3">
                        <i class="fas fa-ticket-alt fa-2x text-success"></i>
                    </div>
                    <div>
                        <h3 class="mb-0"><?= count($recentBookings) ?></h3>
                        <small class="text-muted">Total Bookings</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm stat-card">
                <div class="card-body d-flex align-items-center">
                    <div class="stat-icon bg-warning bg-opacity-10 rounded-circle p-3 me-3">
                        <i class="fas fa-bell fa-2x text-warning"></i>
                    </div>
                    <div>
                        <h3 class="mb-0"><?= $unreadCount ?></h3>
                        <small class="text-muted">Notifications</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Upcoming Trips</h5>
                    <a href="<?= url('user/bookings') ?>" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body">
                    <?php if (empty($upcoming)): ?>
                        <p class="text-muted text-center py-4">No upcoming trips. <a href="<?= url('flights/search') ?>">Search flights</a></p>
                    <?php else: ?>
                        <?php foreach (array_slice($upcoming, 0, 3) as $booking): ?>
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                            <div>
                                <h6 class="mb-1"><?= e($booking['booking_reference']) ?></h6>
                                <small class="text-muted"><?= cabinClassLabel($booking['cabin_class']) ?></small>
                            </div>
                            <?= bookingStatusBadge($booking['status']) ?>
                            <a href="<?= url('user/bookings/' . $booking['id']) ?>" class="btn btn-sm btn-outline-primary">View</a>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold">Recent Notifications</div>
                <div class="card-body">
                    <?php if (empty($notifications)): ?>
                        <p class="text-muted small">No notifications</p>
                    <?php else: ?>
                        <?php foreach ($notifications as $n): ?>
                        <div class="mb-2 pb-2 border-bottom">
                            <h6 class="small mb-1"><?= e($n['title']) ?></h6>
                            <p class="text-muted small mb-0"><?= e(substr($n['message'], 0, 60)) ?>...</p>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

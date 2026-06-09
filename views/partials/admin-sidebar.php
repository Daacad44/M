<div class="p-3">
    <div class="text-center mb-4 pt-2">
        <i class="fas fa-plane-departure fa-2x text-white"></i>
        <h5 class="text-white mt-2 mb-0"><?= e(config('app.name')) ?></h5>
        <small class="text-white-50">Admin Panel</small>
    </div>
    <nav class="nav flex-column admin-nav">
        <a class="nav-link" href="<?= url('admin') ?>"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
        <a class="nav-link" href="<?= url('admin/flights') ?>"><i class="fas fa-plane me-2"></i>Flights</a>
        <a class="nav-link" href="<?= url('admin/airlines') ?>"><i class="fas fa-building me-2"></i>Airlines</a>
        <a class="nav-link" href="<?= url('admin/airports') ?>"><i class="fas fa-map-marker-alt me-2"></i>Airports</a>
        <a class="nav-link" href="<?= url('admin/bookings') ?>"><i class="fas fa-ticket-alt me-2"></i>Bookings</a>
        <a class="nav-link" href="<?= url('admin/payments') ?>"><i class="fas fa-credit-card me-2"></i>Payments</a>
        <a class="nav-link" href="<?= url('admin/passengers') ?>"><i class="fas fa-users me-2"></i>Passengers</a>
        <a class="nav-link" href="<?= url('admin/users') ?>"><i class="fas fa-user-friends me-2"></i>Users</a>
        <a class="nav-link" href="<?= url('admin/coupons') ?>"><i class="fas fa-tags me-2"></i>Coupons</a>
        <a class="nav-link" href="<?= url('admin/reviews') ?>"><i class="fas fa-star me-2"></i>Reviews</a>
        <a class="nav-link" href="<?= url('admin/support') ?>"><i class="fas fa-headset me-2"></i>Support</a>
        <a class="nav-link" href="<?= url('admin/faqs') ?>"><i class="fas fa-question-circle me-2"></i>FAQs</a>
        <a class="nav-link" href="<?= url('admin/reports') ?>"><i class="fas fa-chart-bar me-2"></i>Reports</a>
        <a class="nav-link" href="<?= url('admin/settings') ?>"><i class="fas fa-cog me-2"></i>Settings</a>
    </nav>
</div>

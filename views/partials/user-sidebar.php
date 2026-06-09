<div class="p-3">
    <div class="text-center mb-4 pt-3">
        <div class="avatar-circle mx-auto mb-2">
            <i class="fas fa-user fa-2x text-primary"></i>
        </div>
        <h6 class="mb-0"><?= e(Session::get('user_name')) ?></h6>
        <small class="text-muted"><?= e(Session::get('user_email')) ?></small>
    </div>
    <nav class="nav flex-column user-nav">
        <a class="nav-link" href="<?= url('user/dashboard') ?>"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
        <a class="nav-link" href="<?= url('user/bookings') ?>"><i class="fas fa-ticket-alt me-2"></i>My Bookings</a>
        <a class="nav-link" href="<?= url('user/notifications') ?>"><i class="fas fa-bell me-2"></i>Notifications</a>
        <a class="nav-link" href="<?= url('user/profile') ?>"><i class="fas fa-user-cog me-2"></i>Profile</a>
        <a class="nav-link" href="<?= url('user/support') ?>"><i class="fas fa-headset me-2"></i>Support</a>
        <a class="nav-link" href="<?= url('flights/search') ?>"><i class="fas fa-search me-2"></i>Search Flights</a>
        <hr>
        <a class="nav-link text-danger" href="<?= url('logout') ?>"><i class="fas fa-sign-out-alt me-2"></i>Logout</a>
    </nav>
</div>

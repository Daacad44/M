<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= url('') ?>">
            <i class="fas fa-plane-departure me-2"></i><?= e(config('app.name')) ?>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="<?= url('') ?>">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= url('flights/search') ?>">Search Flights</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= url('about') ?>">About</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= url('contact') ?>">Contact</a></li>
            </ul>
            <ul class="navbar-nav">
                <?php if (Session::isLoggedIn()): ?>
                    <?php if (Session::isAdmin()): ?>
                        <li class="nav-item"><a class="nav-link" href="<?= url('admin') ?>"><i class="fas fa-cog me-1"></i>Admin</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a class="nav-link" href="<?= url('user/dashboard') ?>"><i class="fas fa-user me-1"></i>Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= url('logout') ?>"><i class="fas fa-sign-out-alt me-1"></i>Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="<?= url('login') ?>">Login</a></li>
                    <li class="nav-item"><a class="nav-link btn btn-outline-light btn-sm ms-2 px-3" href="<?= url('register') ?>">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

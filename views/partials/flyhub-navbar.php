<header class="flyhub-header">
    <div class="container">
        <nav class="navbar navbar-expand-lg flyhub-navbar">
            <a class="flyhub-logo" href="<?= url('') ?>">
                <span class="flyhub-logo-icon"><i class="fas fa-plane"></i></span>
                <span class="flyhub-logo-text">
                    <span class="flyhub-logo-name">FLYHUB</span>
                    <span class="flyhub-logo-tagline">Fly Easy, Book Smart</span>
                </span>
            </a>
            <button class="navbar-toggler flyhub-navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#flyhubNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="flyhubNav">
                <ul class="navbar-nav flyhub-nav-menu">
                    <li class="nav-item"><a class="nav-link active" href="<?= url('') ?>">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= url('flights/search') ?>">Flights</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Hotels</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Deals</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= url('about') ?>">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= url('contact') ?>">Contact</a></li>
                </ul>
                <div class="flyhub-nav-actions d-lg-none mt-3 px-3 pb-2">
                    <?php if (Session::isLoggedIn()): ?>
                        <a href="<?= url('user/dashboard') ?>" class="btn flyhub-btn-login w-100 mb-2">Dashboard</a>
                        <a href="<?= url('logout') ?>" class="btn flyhub-btn-signup w-100">Logout</a>
                    <?php else: ?>
                        <a href="<?= url('login') ?>" class="btn flyhub-btn-login w-100 mb-2">Login</a>
                        <a href="<?= url('register') ?>" class="btn flyhub-btn-signup w-100">Sign Up</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="flyhub-nav-actions d-none d-lg-flex align-items-center">
                <?php if (Session::isLoggedIn()): ?>
                    <a href="<?= url('user/dashboard') ?>" class="btn flyhub-btn-login">Dashboard</a>
                    <a href="<?= url('logout') ?>" class="btn flyhub-btn-signup">Logout</a>
                <?php else: ?>
                    <a href="<?= url('login') ?>" class="btn flyhub-btn-login">Login</a>
                    <a href="<?= url('register') ?>" class="btn flyhub-btn-signup">Sign Up</a>
                <?php endif; ?>
            </div>
        </nav>
    </div>
</header>

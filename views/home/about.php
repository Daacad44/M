<?php $pageTitle = 'About Us'; ?>
<section class="py-5">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-lg-6">
                <h1 class="fw-bold mb-4">About <?= e(config('app.name')) ?></h1>
                <p class="lead text-muted">We are a leading online flight booking platform dedicated to making air travel accessible, affordable, and enjoyable for everyone.</p>
                <p>Founded with a vision to simplify the flight booking experience, <?= e(config('app.name')) ?> connects travelers with hundreds of airlines worldwide. Our platform offers advanced search tools, competitive pricing, and a seamless booking process.</p>
            </div>
            <div class="col-lg-6 text-center">
                <div class="about-img bg-primary bg-opacity-10 rounded-4 p-5">
                    <i class="fas fa-globe-americas fa-5x text-primary"></i>
                </div>
            </div>
        </div>
        <div class="row g-4 text-center">
            <div class="col-md-3"><h2 class="fw-bold text-primary">1M+</h2><p class="text-muted">Happy Travelers</p></div>
            <div class="col-md-3"><h2 class="fw-bold text-primary">50+</h2><p class="text-muted">Airline Partners</p></div>
            <div class="col-md-3"><h2 class="fw-bold text-primary">100+</h2><p class="text-muted">Destinations</p></div>
            <div class="col-md-3"><h2 class="fw-bold text-primary">24/7</h2><p class="text-muted">Customer Support</p></div>
        </div>
    </div>
</section>

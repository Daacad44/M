<?php $pageTitle = 'Home'; ?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-overlay"></div>
    <div class="container position-relative">
        <div class="row min-vh-75 align-items-center">
            <div class="col-lg-7 text-white mb-4 mb-lg-0">
                <h1 class="display-4 fw-bold mb-3">Discover the World with <?= e(config('app.name')) ?></h1>
                <p class="lead mb-4">Book flights to 100+ destinations. Best prices, flexible options, and 24/7 support.</p>
                <div class="d-flex gap-4 hero-stats">
                    <div><h3 class="fw-bold mb-0">500+</h3><small>Daily Flights</small></div>
                    <div><h3 class="fw-bold mb-0">50+</h3><small>Airlines</small></div>
                    <div><h3 class="fw-bold mb-0"><?= $avgRating ?: '4.8' ?></h3><small>Rating</small></div>
                </div>
            </div>
        </div>
        <div class="search-box-card">
            <?php $filters = []; partial('flight-search-form', compact('airports', 'filters')); ?>
        </div>
    </div>
</section>

<!-- Popular Destinations -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Popular Destinations</h2>
            <p class="text-muted">Explore our most booked destinations</p>
        </div>
        <div class="row g-4">
            <?php
            $destImages = ['london', 'dubai', 'tokyo', 'sydney', 'paris', 'singapore'];
            foreach ($destinations as $i => $dest):
            ?>
            <div class="col-lg-4 col-md-6">
                <div class="destination-card">
                    <div class="destination-img bg-primary d-flex align-items-center justify-content-center" style="height:200px;background:linear-gradient(135deg,#0d6efd,#0dcaf0)!important;">
                        <div class="text-center text-white">
                            <h2 class="fw-bold mb-0"><?= e($dest['code']) ?></h2>
                            <p class="mb-0"><?= e($dest['city']) ?></p>
                        </div>
                    </div>
                    <div class="destination-body p-3">
                        <h5 class="mb-1"><?= e($dest['city']) ?>, <?= e($dest['country']) ?></h5>
                        <p class="text-muted small mb-2"><?= e($dest['name']) ?></p>
                        <a href="<?= url('flights/search?to=' . $dest['id']) ?>" class="btn btn-sm btn-outline-primary">Explore Flights</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Airline Partners -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Our Airline Partners</h2>
            <p class="text-muted">Fly with the world's leading airlines</p>
        </div>
        <div class="row g-4 justify-content-center">
            <?php foreach ($airlines as $airline): ?>
            <div class="col-lg-2 col-md-3 col-4 text-center">
                <div class="airline-card p-3 bg-white rounded shadow-sm">
                    <i class="fas fa-plane fa-2x text-primary mb-2"></i>
                    <h6 class="mb-0 small"><?= e($airline['name']) ?></h6>
                    <small class="text-muted"><?= e($airline['code']) ?></small>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Why Choose <?= e(config('app.name')) ?>?</h2>
        </div>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6 text-center">
                <div class="feature-icon bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:80px;height:80px;">
                    <i class="fas fa-tags fa-2x text-primary"></i>
                </div>
                <h5>Best Prices</h5>
                <p class="text-muted">Compare prices across airlines and get the best deals guaranteed.</p>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="feature-icon bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:80px;height:80px;">
                    <i class="fas fa-shield-alt fa-2x text-success"></i>
                </div>
                <h5>Secure Booking</h5>
                <p class="text-muted">Your data and payments are protected with enterprise-grade security.</p>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="feature-icon bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:80px;height:80px;">
                    <i class="fas fa-headset fa-2x text-info"></i>
                </div>
                <h5>24/7 Support</h5>
                <p class="text-muted">Our dedicated support team is always ready to assist you.</p>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="feature-icon bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:80px;height:80px;">
                    <i class="fas fa-ticket-alt fa-2x text-warning"></i>
                </div>
                <h5>E-Tickets</h5>
                <p class="text-muted">Instant e-ticket delivery with QR codes for easy check-in.</p>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">What Our Customers Say</h2>
        </div>
        <div class="row g-4">
            <?php
            $testimonials = [
                ['name' => 'Sarah Johnson', 'text' => 'Amazing experience! Booked my family vacation in minutes. Great prices and smooth process.', 'rating' => 5],
                ['name' => 'Michael Chen', 'text' => 'The best flight booking platform I have used. Customer support was incredibly helpful.', 'rating' => 5],
                ['name' => 'Emma Williams', 'text' => 'Love the seat selection feature and instant e-tickets. Will definitely book again!', 'rating' => 4],
            ];
            foreach ($testimonials as $t):
            ?>
            <div class="col-lg-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="text-warning mb-2">
                            <?php for ($i = 0; $i < $t['rating']; $i++): ?><i class="fas fa-star"></i><?php endfor; ?>
                        </div>
                        <p class="text-muted">"<?= e($t['text']) ?>"</p>
                        <h6 class="mb-0 fw-bold"><?= e($t['name']) ?></h6>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- FAQ -->
<section class="py-5" id="faq">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Frequently Asked Questions</h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion" id="faqAccordion">
                    <?php foreach ($faqs as $i => $faq): ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button <?= $i > 0 ? 'collapsed' : '' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#faq<?= $i ?>">
                                <?= e($faq['question']) ?>
                            </button>
                        </h2>
                        <div id="faq<?= $i ?>" class="accordion-collapse collapse <?= $i === 0 ? 'show' : '' ?>" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted"><?= e($faq['answer']) ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact CTA -->
<section class="py-5 bg-primary text-white">
    <div class="container text-center">
        <h2 class="fw-bold mb-3">Ready to Start Your Journey?</h2>
        <p class="lead mb-4">Book your next adventure today and experience world-class service.</p>
        <a href="<?= url('flights/search') ?>" class="btn btn-light btn-lg px-5 me-2">Search Flights</a>
        <a href="<?= url('contact') ?>" class="btn btn-outline-light btn-lg px-5">Contact Us</a>
    </div>
</section>

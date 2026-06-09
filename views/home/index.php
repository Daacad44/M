<?php $pageTitle = 'Home'; ?>

<?php
$featuredDestinations = [
    [
        'city' => 'New York',
        'country' => 'USA',
        'price' => 350,
        'image' => 'https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?w=400&h=300&fit=crop',
        'code' => 'JFK',
    ],
    [
        'city' => 'London',
        'country' => 'UK',
        'price' => 420,
        'image' => 'https://images.unsplash.com/photo-1513635269975-59663e0ac1ad?w=400&h=300&fit=crop',
        'code' => 'LHR',
    ],
    [
        'city' => 'Paris',
        'country' => 'France',
        'price' => 380,
        'image' => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=400&h=300&fit=crop',
        'code' => 'CDG',
    ],
    [
        'city' => 'Dubai',
        'country' => 'UAE',
        'price' => 290,
        'image' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=400&h=300&fit=crop',
        'code' => 'DXB',
    ],
];

foreach ($featuredDestinations as &$fd) {
    foreach ($destinations as $dest) {
        if (strtoupper($fd['code']) === strtoupper($dest['code'])) {
            $fd['airport_id'] = $dest['id'];
            break;
        }
    }
}
unset($fd);
?>

<!-- Hero Section -->
<section class="flyhub-hero">
    <div class="flyhub-hero-bg"></div>
    <div class="flyhub-hero-overlay"></div>
    <div class="container position-relative">
        <div class="flyhub-hero-content">
            <div class="flyhub-hero-badge">
                <i class="fas fa-plane"></i>
                BEST WAY TO FLY
            </div>
            <h1 class="flyhub-hero-title">
                Book Flights to<br>
                <span class="flyhub-hero-accent">Anywhere in the World</span>
            </h1>
            <p class="flyhub-hero-subtitle">
                Find the best deals on flights, hotels, and car rentals. Compare prices from hundreds of airlines and travel sites.
            </p>
        </div>
    </div>

    <div class="container flyhub-search-container">
        <?php $filters = ['trip_type' => 'round_trip']; partial('flyhub-search-form', compact('airports', 'filters')); ?>
    </div>
</section>

<!-- Features Bar -->
<section class="flyhub-features-section">
    <div class="container">
        <div class="flyhub-features-bar">
            <div class="flyhub-feature-item">
                <div class="flyhub-feature-icon">
                    <i class="fas fa-tag"></i>
                </div>
                <div class="flyhub-feature-text">
                    <strong>Best Price Guarantee</strong>
                    <span>Find the best deals</span>
                </div>
            </div>
            <div class="flyhub-feature-item">
                <div class="flyhub-feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div class="flyhub-feature-text">
                    <strong>Secure Booking</strong>
                    <span>100% secure payment</span>
                </div>
            </div>
            <div class="flyhub-feature-item">
                <div class="flyhub-feature-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <div class="flyhub-feature-text">
                    <strong>24/7 Customer Support</strong>
                    <span>We're here to help</span>
                </div>
            </div>
            <div class="flyhub-feature-item">
                <div class="flyhub-feature-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="flyhub-feature-text">
                    <strong>Easy Booking</strong>
                    <span>Book in minutes</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Popular Destinations -->
<section class="flyhub-destinations-section">
    <div class="container">
        <div class="flyhub-section-header">
            <h2 class="flyhub-section-title">Popular Destinations</h2>
            <a href="<?= url('flights/search') ?>" class="flyhub-section-link">View All Destinations &rarr;</a>
        </div>
        <div class="row g-4">
            <?php foreach ($featuredDestinations as $dest): ?>
            <div class="col-lg-3 col-md-6">
                <a href="<?= url('flights/search' . (!empty($dest['airport_id']) ? '?to=' . $dest['airport_id'] : '')) ?>" class="flyhub-dest-card">
                    <div class="flyhub-dest-image">
                        <img src="<?= e($dest['image']) ?>" alt="<?= e($dest['city']) ?>" loading="lazy">
                    </div>
                    <div class="flyhub-dest-info">
                        <h3 class="flyhub-dest-city"><?= e($dest['city']) ?></h3>
                        <p class="flyhub-dest-country"><?= e($dest['country']) ?></p>
                        <div class="flyhub-dest-price-wrap">
                            <span class="flyhub-dest-from">From</span>
                            <span class="flyhub-dest-price">$<?= number_format($dest['price']) ?></span>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Statistics Bar -->
<section class="flyhub-stats-section">
    <div class="container">
        <div class="flyhub-stats-bar">
            <div class="flyhub-stat-item">
                <div class="flyhub-stat-icon">
                    <i class="fas fa-plane"></i>
                </div>
                <div class="flyhub-stat-text">
                    <strong>500+</strong>
                    <span>Airlines</span>
                </div>
            </div>
            <div class="flyhub-stat-item">
                <div class="flyhub-stat-icon">
                    <i class="fas fa-globe-americas"></i>
                </div>
                <div class="flyhub-stat-text">
                    <strong>2000+</strong>
                    <span>Destinations</span>
                </div>
            </div>
            <div class="flyhub-stat-item">
                <div class="flyhub-stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="flyhub-stat-text">
                    <strong>10M+</strong>
                    <span>Happy Customers</span>
                </div>
            </div>
            <div class="flyhub-stat-item">
                <div class="flyhub-stat-icon">
                    <i class="fas fa-ticket-alt"></i>
                </div>
                <div class="flyhub-stat-text">
                    <strong>24/7</strong>
                    <span>Support</span>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="footer bg-dark text-light pt-5 pb-3 mt-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <h5 class="fw-bold"><i class="fas fa-plane-departure me-2"></i><?= e(config('app.name')) ?></h5>
                <p class="text-muted">Your trusted partner for seamless flight bookings worldwide. Experience premium service at competitive prices.</p>
                <div class="social-links">
                    <a href="#" class="text-light me-3"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-light me-3"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-light me-3"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-light"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-md-4">
                <h6 class="fw-bold mb-3">Quick Links</h6>
                <ul class="list-unstyled">
                    <li><a href="<?= url('flights/search') ?>" class="text-muted text-decoration-none">Search Flights</a></li>
                    <li><a href="<?= url('about') ?>" class="text-muted text-decoration-none">About Us</a></li>
                    <li><a href="<?= url('contact') ?>" class="text-muted text-decoration-none">Contact</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-md-4">
                <h6 class="fw-bold mb-3">Support</h6>
                <ul class="list-unstyled">
                    <li><a href="<?= url('contact') ?>" class="text-muted text-decoration-none">Help Center</a></li>
                    <li><a href="<?= url('contact') ?>" class="text-muted text-decoration-none">FAQs</a></li>
                    <li><a href="<?= url('contact') ?>" class="text-muted text-decoration-none">Terms of Service</a></li>
                </ul>
            </div>
            <div class="col-lg-4 col-md-4">
                <h6 class="fw-bold mb-3">Newsletter</h6>
                <p class="text-muted small">Subscribe for exclusive deals and travel tips.</p>
                <form action="<?= url('newsletter') ?>" method="POST" class="newsletter-form">
                    <?= Security::csrfField() ?>
                    <div class="input-group">
                        <input type="email" name="email" class="form-control" placeholder="Your email" required>
                        <button class="btn btn-primary" type="submit"><i class="fas fa-paper-plane"></i></button>
                    </div>
                </form>
            </div>
        </div>
        <hr class="border-secondary my-4">
        <div class="text-center text-muted small">
            &copy; <?= date('Y') ?> <?= e(config('app.name')) ?>. All rights reserved.
        </div>
    </div>
</footer>

<?php $pageTitle = 'Contact Us'; ?>
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="fw-bold">Contact Us</h1>
            <p class="text-muted lead">We're here to help. Reach out anytime.</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100 text-center p-4">
                    <i class="fas fa-envelope fa-3x text-primary mb-3"></i>
                    <h5>Email</h5>
                    <p class="text-muted">support@skywings.com</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100 text-center p-4">
                    <i class="fas fa-phone fa-3x text-primary mb-3"></i>
                    <h5>Phone</h5>
                    <p class="text-muted">+1-800-SKY-WING</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100 text-center p-4">
                    <i class="fas fa-clock fa-3x text-primary mb-3"></i>
                    <h5>Hours</h5>
                    <p class="text-muted">24/7 Customer Support</p>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white fw-bold">Send a Message</div>
                    <div class="card-body p-4">
                        <form method="POST" action="<?= url('contact') ?>">
                            <?= Security::csrfField() ?>
                            <div class="mb-3">
                                <label class="form-label">Name *</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email *</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Subject *</label>
                                <input type="text" name="subject" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Message *</label>
                                <textarea name="message" class="form-control" rows="5" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white fw-bold">FAQs</div>
                    <div class="card-body">
                        <div class="accordion" id="contactFaq">
                            <?php foreach ($faqs as $i => $faq): ?>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#cf<?= $i ?>">
                                        <?= e($faq['question']) ?>
                                    </button>
                                </h2>
                                <div id="cf<?= $i ?>" class="accordion-collapse collapse" data-bs-parent="#contactFaq">
                                    <div class="accordion-body small text-muted"><?= e($faq['answer']) ?></div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

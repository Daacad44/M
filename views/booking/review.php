<?php $pageTitle = 'Review Booking'; ?>
<section class="py-4">
    <div class="container">
        <h3 class="fw-bold mb-4">Review Your Booking</h3>
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white fw-bold">Flight Details</div>
                    <div class="card-body">
                        <?php foreach ($flights as $flight): ?>
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                            <div>
                                <h6 class="mb-1"><?= e($flight['airline_name']) ?> · <?= e($flight['flight_number']) ?></h6>
                                <p class="text-muted small mb-0"><?= e($flight['departure_code']) ?> → <?= e($flight['arrival_code']) ?> · <?= formatDateTime($flight['departure_time']) ?></p>
                            </div>
                            <span class="fw-bold"><?= formatMoney($flight['price']) ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white fw-bold">Passengers (<?= count($passengers) ?>)</div>
                    <div class="card-body">
                        <?php foreach ($passengers as $p): ?>
                        <div class="d-flex justify-content-between mb-2">
                            <span><?= e($p['title']) ?> <?= e($p['first_name']) ?> <?= e($p['last_name']) ?> (<?= ucfirst($p['passenger_type']) ?>)</span>
                            <span class="text-muted"><?= e($p['seat_number'] ?? 'Auto') ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <form method="POST" action="<?= url('booking/confirm/' . $booking['id']) ?>">
                    <?= Security::csrfField() ?>
                    <button type="submit" class="btn btn-primary btn-lg">Proceed to Payment</button>
                    <a href="<?= url('user/bookings') ?>" class="btn btn-outline-secondary btn-lg ms-2">Cancel</a>
                </form>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white fw-bold">Price Summary</div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2"><span>Subtotal</span><span><?= formatMoney($booking['total_amount']) ?></span></div>
                        <?php if ($booking['discount_amount'] > 0): ?>
                        <div class="d-flex justify-content-between mb-2 text-success"><span>Discount</span><span>-<?= formatMoney($booking['discount_amount']) ?></span></div>
                        <?php endif; ?>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold fs-5"><span>Total</span><span class="text-primary"><?= formatMoney($booking['final_amount']) ?></span></div>
                        <p class="text-muted small mt-2 mb-0">Ref: <?= e($booking['booking_reference']) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

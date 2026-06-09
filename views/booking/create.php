<?php $pageTitle = 'Book Flight'; ?>
<section class="py-4">
    <div class="container">
        <h3 class="fw-bold mb-4">Passenger Details</h3>
        <div class="row">
            <div class="col-lg-8">
                <form method="POST" action="<?= url('booking/store') ?>" id="bookingForm">
                    <?= Security::csrfField() ?>
                    <input type="hidden" name="flight_id" value="<?= $flight['id'] ?>">
                    <input type="hidden" name="return_flight_id" value="<?= $returnFlight['id'] ?? '' ?>">
                    <input type="hidden" name="cabin_class" value="<?= e($cabinClass) ?>">
                    <input type="hidden" name="trip_type" value="<?= e($tripType) ?>">

                    <?php for ($i = 0; $i < $passengers; $i++): ?>
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-header bg-white fw-bold">Passenger <?= $i + 1 ?></div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-2">
                                    <label class="form-label">Type</label>
                                    <select name="passengers[<?= $i ?>][type]" class="form-select">
                                        <option value="adult">Adult</option>
                                        <option value="child">Child</option>
                                        <option value="infant">Infant</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Title</label>
                                    <select name="passengers[<?= $i ?>][title]" class="form-select">
                                        <option value="Mr">Mr</option>
                                        <option value="Mrs">Mrs</option>
                                        <option value="Ms">Ms</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">First Name *</label>
                                    <input type="text" name="passengers[<?= $i ?>][first_name]" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Last Name *</label>
                                    <input type="text" name="passengers[<?= $i ?>][last_name]" class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Gender</label>
                                    <select name="passengers[<?= $i ?>][gender]" class="form-select">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Date of Birth</label>
                                    <input type="date" name="passengers[<?= $i ?>][date_of_birth]" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Nationality</label>
                                    <input type="text" name="passengers[<?= $i ?>][nationality]" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Passport No.</label>
                                    <input type="text" name="passengers[<?= $i ?>][passport_number]" class="form-control">
                                </div>
                                <?php if (!empty($seatMap)): ?>
                                <div class="col-md-4">
                                    <label class="form-label">Select Seat</label>
                                    <select name="seat_ids[<?= $i ?>]" class="form-select">
                                        <option value="">Auto Assign</option>
                                        <?php foreach ($seatMap as $class => $seats): ?>
                                            <?php if ($class === $cabinClass): ?>
                                                <?php foreach ($seats as $seat): ?>
                                                    <?php if ($seat['status'] === 'available'): ?>
                                                    <option value="<?= $seat['id'] ?>"><?= e($seat['seat_number']) ?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endfor; ?>

                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-header bg-white fw-bold">Promo Code</div>
                        <div class="card-body">
                            <div class="input-group">
                                <input type="text" name="coupon_code" id="couponCode" class="form-control" placeholder="Enter promo code">
                                <button type="button" class="btn btn-outline-primary" id="applyCoupon">Apply</button>
                            </div>
                            <div id="couponMessage" class="mt-2"></div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg">Continue to Review</button>
                </form>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm sticky-top" style="top:80px;">
                    <div class="card-header bg-primary text-white fw-bold">Booking Summary</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h6><?= e($flight['airline_name']) ?> · <?= e($flight['flight_number']) ?></h6>
                            <p class="small text-muted mb-0"><?= e($flight['departure_code']) ?> → <?= e($flight['arrival_code']) ?></p>
                            <p class="small text-muted"><?= formatDateTime($flight['departure_time']) ?></p>
                        </div>
                        <?php if ($returnFlight): ?>
                        <div class="mb-3">
                            <h6><?= e($returnFlight['airline_name']) ?> · <?= e($returnFlight['flight_number']) ?></h6>
                            <p class="small text-muted mb-0"><?= e($returnFlight['departure_code']) ?> → <?= e($returnFlight['arrival_code']) ?></p>
                        </div>
                        <?php endif; ?>
                        <hr>
                        <div class="d-flex justify-content-between"><span>Class</span><span><?= cabinClassLabel($cabinClass) ?></span></div>
                        <div class="d-flex justify-content-between"><span>Passengers</span><span><?= $passengers ?></span></div>
                        <div class="d-flex justify-content-between"><span>Price/person</span><span><?= formatMoney($price) ?></span></div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold"><span>Total</span><span class="text-primary" id="totalAmount"><?= formatMoney($totalPrice) ?></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

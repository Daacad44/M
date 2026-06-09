<?php $pageTitle = 'Booking ' . e($booking['booking_reference']); ?>
<div class="p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Booking <?= e($booking['booking_reference']) ?></h3>
        <?= bookingStatusBadge($booking['status']) ?>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white fw-bold">Flights</div>
                <div class="card-body">
                    <?php foreach ($flights as $f): ?>
                    <div class="mb-3 pb-3 border-bottom">
                        <h6><?= e($f['airline_name']) ?> · <?= e($f['flight_number']) ?></h6>
                        <p class="mb-1"><?= e($f['departure_code']) ?> → <?= e($f['arrival_code']) ?></p>
                        <small class="text-muted"><?= formatDateTime($f['departure_time']) ?> - <?= formatDateTime($f['arrival_time']) ?></small>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white fw-bold">Passengers</div>
                <div class="card-body">
                    <table class="table table-sm">
                        <thead><tr><th>Name</th><th>Type</th><th>Passport</th><th>Seat</th></tr></thead>
                        <tbody>
                            <?php foreach ($passengers as $p): ?>
                            <tr>
                                <td><?= e($p['first_name'] . ' ' . $p['last_name']) ?></td>
                                <td><?= ucfirst($p['passenger_type']) ?></td>
                                <td><?= e($p['passport_number'] ?? '-') ?></td>
                                <td><?= e($p['seat_number'] ?? 'Auto') ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php if (!empty($tickets) && $booking['status'] === 'confirmed'): ?>
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold">E-Tickets</div>
                <div class="card-body">
                    <?php foreach ($tickets as $t): ?>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span><?= e($t['first_name'] . ' ' . $t['last_name']) ?> - <?= e($t['ticket_number']) ?></span>
                        <a href="<?= url('user/ticket/download/' . $t['id']) ?>" class="btn btn-sm btn-primary"><i class="fas fa-download me-1"></i>Download PDF</a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white fw-bold">Payment</div>
                <div class="card-body">
                    <?php if ($payment): ?>
                        <p class="mb-1"><strong>Method:</strong> <?= ucfirst(str_replace('_', ' ', $payment['payment_method'])) ?></p>
                        <p class="mb-1"><strong>Amount:</strong> <?= formatMoney($payment['amount']) ?></p>
                        <p class="mb-0"><?= paymentStatusBadge($payment['status']) ?></p>
                    <?php else: ?>
                        <p class="text-muted">No payment yet</p>
                        <?php if ($booking['status'] === 'pending'): ?>
                        <a href="<?= url('payment/' . $booking['id']) ?>" class="btn btn-primary w-100">Pay Now</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold">Actions</div>
                <div class="card-body">
                    <p class="mb-1"><strong>Total:</strong> <?= formatMoney($booking['final_amount']) ?></p>
                    <?php if (in_array($booking['status'], ['pending', 'confirmed'])): ?>
                    <form method="POST" action="<?= url('booking/cancel/' . $booking['id']) ?>" onsubmit="return confirm('Cancel this booking?')">
                        <?= Security::csrfField() ?>
                        <button type="submit" class="btn btn-outline-danger w-100 mt-2">Cancel Booking</button>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

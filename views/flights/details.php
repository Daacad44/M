<?php $pageTitle = 'Flight Details - ' . e($flight['flight_number']); ?>
<section class="py-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= url('flights/search') ?>">Search</a></li>
                <li class="breadcrumb-item active"><?= e($flight['flight_number']) ?></li>
            </ol>
        </nav>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h3 class="fw-bold"><?= e($flight['airline_name']) ?> · <?= e($flight['flight_number']) ?></h3>
                        <p class="text-muted mb-0"><?= e($flight['aircraft_type']) ?> · <?= cabinClassLabel($cabinClass) ?></p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <h2 class="text-primary fw-bold mb-0"><?= formatMoney($price) ?></h2>
                        <small class="text-muted">per person</small>
                    </div>
                </div>
                <hr>
                <div class="row text-center py-3">
                    <div class="col-md-4">
                        <h2 class="fw-bold"><?= date('H:i', strtotime($flight['departure_time'])) ?></h2>
                        <p class="mb-0"><?= e($flight['departure_airport']) ?></p>
                        <small class="text-muted"><?= e($flight['departure_code']) ?> · <?= formatDate($flight['departure_time']) ?></small>
                    </div>
                    <div class="col-md-4">
                        <p class="mb-1"><i class="fas fa-clock me-1"></i><?= formatDuration($flight['duration_minutes']) ?></p>
                        <div class="route-line my-2"><i class="fas fa-plane text-primary"></i></div>
                        <small class="text-muted"><?= $flight['stops'] == 0 ? 'Non-stop' : $flight['stops'] . ' stop(s)' ?></small>
                    </div>
                    <div class="col-md-4">
                        <h2 class="fw-bold"><?= date('H:i', strtotime($flight['arrival_time'])) ?></h2>
                        <p class="mb-0"><?= e($flight['arrival_airport']) ?></p>
                        <small class="text-muted"><?= e($flight['arrival_code']) ?> · <?= formatDate($flight['arrival_time']) ?></small>
                    </div>
                </div>
                <?php if (Session::isLoggedIn()): ?>
                <div class="text-center mt-3">
                    <a href="<?= url('booking/create?flight_id=' . $flight['id'] . '&cabin_class=' . $cabinClass) ?>" class="btn btn-primary btn-lg px-5">Book This Flight</a>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if (!empty($seatMap)): ?>
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white fw-bold">Seat Map</div>
            <div class="card-body">
                <?php foreach ($seatMap as $class => $seats): ?>
                <h6 class="text-muted mb-2"><?= cabinClassLabel($class) ?></h6>
                <div class="seat-map mb-4">
                    <?php foreach ($seats as $seat): ?>
                    <span class="seat <?= $seat['status'] ?>" title="<?= e($seat['seat_number']) ?> - <?= e($seat['status']) ?>"><?= e($seat['seat_number']) ?></span>
                    <?php endforeach; ?>
                </div>
                <?php endforeach; ?>
                <div class="d-flex gap-3 small">
                    <span><span class="seat available d-inline-block"></span> Available</span>
                    <span><span class="seat reserved d-inline-block"></span> Reserved</span>
                    <span><span class="seat booked d-inline-block"></span> Booked</span>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if (!empty($reviews)): ?>
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold">Reviews (<?= $avgRating ?>/5)</div>
            <div class="card-body">
                <?php foreach ($reviews as $review): ?>
                <div class="mb-3 pb-3 border-bottom">
                    <div class="text-warning mb-1">
                        <?php for ($i = 0; $i < $review['rating']; $i++): ?><i class="fas fa-star"></i><?php endfor; ?>
                    </div>
                    <h6><?= e($review['title']) ?></h6>
                    <p class="text-muted mb-1"><?= e($review['comment']) ?></p>
                    <small class="text-muted">— <?= e($review['user_name']) ?></small>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

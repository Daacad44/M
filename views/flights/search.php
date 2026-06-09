<?php $pageTitle = 'Search Flights'; ?>
<section class="py-4 bg-light">
    <div class="container">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <?php partial('flight-search-form', compact('airports', 'filters')); ?>
            </div>
        </div>
    </div>
</section>

<section class="py-4">
    <div class="container">
        <div class="row">
            <!-- Filters Sidebar -->
            <div class="col-lg-3 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white fw-bold"><i class="fas fa-filter me-2"></i>Filters</div>
                    <div class="card-body">
                        <form method="GET" action="<?= url('flights/search') ?>" id="filterForm">
                            <input type="hidden" name="from" value="<?= e($filters['from'] ?? '') ?>">
                            <input type="hidden" name="to" value="<?= e($filters['to'] ?? '') ?>">
                            <input type="hidden" name="departure_date" value="<?= e($filters['departure_date'] ?? '') ?>">
                            <input type="hidden" name="return_date" value="<?= e($filters['return_date'] ?? '') ?>">
                            <input type="hidden" name="trip_type" value="<?= e($filters['trip_type'] ?? 'one_way') ?>">
                            <input type="hidden" name="passengers" value="<?= e($filters['passengers'] ?? 1) ?>">
                            <input type="hidden" name="cabin_class" value="<?= e($filters['cabin_class'] ?? 'economy') ?>">

                            <div class="mb-3">
                                <label class="form-label small fw-bold">Airline</label>
                                <select name="airline" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <option value="">All Airlines</option>
                                    <?php foreach ($airlines as $al): ?>
                                    <option value="<?= $al['id'] ?>" <?= ($filters['airline'] ?? '') == $al['id'] ? 'selected' : '' ?>><?= e($al['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Stops</label>
                                <select name="stops" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <option value="">Any</option>
                                    <option value="0" <?= ($filters['stops'] ?? '') === '0' ? 'selected' : '' ?>>Non-stop</option>
                                    <option value="1" <?= ($filters['stops'] ?? '') === '1' ? 'selected' : '' ?>>1 Stop</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Departure Time</label>
                                <select name="departure_time" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <option value="">Any Time</option>
                                    <option value="morning" <?= ($filters['departure_time'] ?? '') === 'morning' ? 'selected' : '' ?>>Morning (5am-12pm)</option>
                                    <option value="afternoon" <?= ($filters['departure_time'] ?? '') === 'afternoon' ? 'selected' : '' ?>>Afternoon (12pm-5pm)</option>
                                    <option value="evening" <?= ($filters['departure_time'] ?? '') === 'evening' ? 'selected' : '' ?>>Evening (5pm-9pm)</option>
                                    <option value="night" <?= ($filters['departure_time'] ?? '') === 'night' ? 'selected' : '' ?>>Night (9pm-5am)</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Sort By</label>
                                <select name="sort" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <option value="price_asc" <?= ($filters['sort'] ?? '') === 'price_asc' ? 'selected' : '' ?>>Price: Low to High</option>
                                    <option value="price_desc" <?= ($filters['sort'] ?? '') === 'price_desc' ? 'selected' : '' ?>>Price: High to Low</option>
                                    <option value="duration_asc" <?= ($filters['sort'] ?? '') === 'duration_asc' ? 'selected' : '' ?>>Duration: Shortest</option>
                                    <option value="departure_asc" <?= ($filters['sort'] ?? '') === 'departure_asc' ? 'selected' : '' ?>>Departure: Earliest</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Results -->
            <div class="col-lg-9">
                <?php if (empty($filters['from']) || empty($filters['to'])): ?>
                    <div class="text-center py-5">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h4>Search for Flights</h4>
                        <p class="text-muted">Enter your travel details above to find available flights.</p>
                    </div>
                <?php elseif (empty($flights)): ?>
                    <div class="text-center py-5">
                        <i class="fas fa-plane-slash fa-3x text-muted mb-3"></i>
                        <h4>No Flights Found</h4>
                        <p class="text-muted">Try adjusting your search criteria or dates.</p>
                    </div>
                <?php else: ?>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0"><?= count($flights) ?> flight(s) found</h5>
                        <span class="text-muted"><?= cabinClassLabel($filters['cabin_class']) ?> · <?= $filters['passengers'] ?> passenger(s)</span>
                    </div>

                    <?php foreach ($flights as $flight): ?>
                    <div class="card flight-card mb-3 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                <div class="col-md-2 text-center mb-3 mb-md-0">
                                    <i class="fas fa-plane text-primary fa-2x mb-1"></i>
                                    <h6 class="mb-0"><?= e($flight['airline_name']) ?></h6>
                                    <small class="text-muted"><?= e($flight['flight_number']) ?></small>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="text-center">
                                            <h4 class="mb-0 fw-bold"><?= date('H:i', strtotime($flight['departure_time'])) ?></h4>
                                            <small class="text-muted"><?= e($flight['departure_code']) ?></small>
                                        </div>
                                        <div class="flight-route flex-grow-1 mx-3 text-center">
                                            <small class="text-muted"><?= formatDuration($flight['duration_minutes']) ?></small>
                                            <div class="route-line"><i class="fas fa-plane text-primary"></i></div>
                                            <small class="text-muted"><?= $flight['stops'] == 0 ? 'Non-stop' : $flight['stops'] . ' stop(s)' ?></small>
                                        </div>
                                        <div class="text-center">
                                            <h4 class="mb-0 fw-bold"><?= date('H:i', strtotime($flight['arrival_time'])) ?></h4>
                                            <small class="text-muted"><?= e($flight['arrival_code']) ?></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 text-center mb-3 mb-md-0">
                                    <h4 class="text-primary fw-bold mb-0"><?= formatMoney($flight['price']) ?></h4>
                                    <small class="text-muted">per person</small>
                                </div>
                                <div class="col-md-2 text-center">
                                    <a href="<?= url('flights/' . $flight['id'] . '?cabin_class=' . $filters['cabin_class']) ?>" class="btn btn-outline-primary btn-sm mb-1 w-100">Details</a>
                                    <?php if (Session::isLoggedIn()): ?>
                                    <a href="<?= url('booking/create?flight_id=' . $flight['id'] . '&cabin_class=' . $filters['cabin_class'] . '&passengers=' . $filters['passengers'] . '&trip_type=' . $filters['trip_type']) ?>" class="btn btn-primary btn-sm w-100">Book Now</a>
                                    <?php else: ?>
                                    <a href="<?= url('login') ?>" class="btn btn-primary btn-sm w-100">Login to Book</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>

                    <?php if (!empty($returnFlights)): ?>
                    <h5 class="mt-4 mb-3"><i class="fas fa-undo me-2"></i>Return Flights</h5>
                    <?php foreach ($returnFlights as $flight): ?>
                    <div class="card flight-card mb-3 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                <div class="col-md-2 text-center">
                                    <h6 class="mb-0"><?= e($flight['airline_name']) ?></h6>
                                    <small class="text-muted"><?= e($flight['flight_number']) ?></small>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="text-center">
                                            <h5 class="mb-0"><?= date('H:i', strtotime($flight['departure_time'])) ?></h5>
                                            <small><?= e($flight['departure_code']) ?></small>
                                        </div>
                                        <div class="text-center flex-grow-1 mx-3">
                                            <small><?= formatDuration($flight['duration_minutes']) ?></small>
                                        </div>
                                        <div class="text-center">
                                            <h5 class="mb-0"><?= date('H:i', strtotime($flight['arrival_time'])) ?></h5>
                                            <small><?= e($flight['arrival_code']) ?></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 text-center">
                                    <h5 class="text-primary mb-0"><?= formatMoney($flight['price']) ?></h5>
                                </div>
                                <div class="col-md-2 text-center">
                                    <a href="<?= url('booking/create?flight_id=' . ($filters['from'] ? $flights[0]['id'] ?? '' : '') . '&return_flight_id=' . $flight['id'] . '&cabin_class=' . $filters['cabin_class'] . '&passengers=' . $filters['passengers'] . '&trip_type=round_trip') ?>" class="btn btn-primary btn-sm w-100">Select</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

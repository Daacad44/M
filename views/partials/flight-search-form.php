<form action="<?= url('flights/search') ?>" method="GET" class="flight-search-form" id="flightSearchForm">
    <div class="trip-type mb-3">
        <div class="btn-group" role="group">
            <input type="radio" class="btn-check" name="trip_type" id="oneWay" value="one_way" <?= ($filters['trip_type'] ?? 'one_way') === 'one_way' ? 'checked' : '' ?>>
            <label class="btn btn-outline-primary" for="oneWay">One Way</label>
            <input type="radio" class="btn-check" name="trip_type" id="roundTrip" value="round_trip" <?= ($filters['trip_type'] ?? '') === 'round_trip' ? 'checked' : '' ?>>
            <label class="btn btn-outline-primary" for="roundTrip">Round Trip</label>
            <input type="radio" class="btn-check" name="trip_type" id="multiCity" value="multi_city" <?= ($filters['trip_type'] ?? '') === 'multi_city' ? 'checked' : '' ?>>
            <label class="btn btn-outline-primary" for="multiCity">Multi City</label>
        </div>
    </div>
    <div class="row g-3">
        <div class="col-md-3">
            <label class="form-label"><i class="fas fa-plane-departure me-1"></i>From</label>
            <select name="from" class="form-select airport-select" required>
                <option value="">Select Airport</option>
                <?php foreach ($airports as $ap): ?>
                <option value="<?= $ap['id'] ?>" <?= ($filters['from'] ?? '') == $ap['id'] ? 'selected' : '' ?>>
                    <?= e($ap['city']) ?> (<?= e($ap['code']) ?>)
                </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label"><i class="fas fa-plane-arrival me-1"></i>To</label>
            <select name="to" class="form-select airport-select" required>
                <option value="">Select Airport</option>
                <?php foreach ($airports as $ap): ?>
                <option value="<?= $ap['id'] ?>" <?= ($filters['to'] ?? '') == $ap['id'] ? 'selected' : '' ?>>
                    <?= e($ap['city']) ?> (<?= e($ap['code']) ?>)
                </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label"><i class="fas fa-calendar me-1"></i>Departure</label>
            <input type="date" name="departure_date" class="form-control" value="<?= e($filters['departure_date'] ?? date('Y-m-d')) ?>" min="<?= date('Y-m-d') ?>" required>
        </div>
        <div class="col-md-2 return-date-field" style="<?= ($filters['trip_type'] ?? 'one_way') !== 'round_trip' ? 'display:none' : '' ?>">
            <label class="form-label"><i class="fas fa-calendar-check me-1"></i>Return</label>
            <input type="date" name="return_date" class="form-control" value="<?= e($filters['return_date'] ?? '') ?>" min="<?= date('Y-m-d') ?>">
        </div>
        <div class="col-md-1">
            <label class="form-label"><i class="fas fa-users me-1"></i>Pax</label>
            <select name="passengers" class="form-select">
                <?php for ($i = 1; $i <= 9; $i++): ?>
                <option value="<?= $i ?>" <?= ($filters['passengers'] ?? 1) == $i ? 'selected' : '' ?>><?= $i ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label"><i class="fas fa-chair me-1"></i>Class</label>
            <select name="cabin_class" class="form-select">
                <option value="economy" <?= ($filters['cabin_class'] ?? '') === 'economy' ? 'selected' : '' ?>>Economy</option>
                <option value="premium_economy" <?= ($filters['cabin_class'] ?? '') === 'premium_economy' ? 'selected' : '' ?>>Premium Economy</option>
                <option value="business" <?= ($filters['cabin_class'] ?? '') === 'business' ? 'selected' : '' ?>>Business</option>
                <option value="first_class" <?= ($filters['cabin_class'] ?? '') === 'first_class' ? 'selected' : '' ?>>First Class</option>
            </select>
        </div>
        <div class="col-12 text-center mt-2">
            <button type="submit" class="btn btn-primary btn-lg px-5"><i class="fas fa-search me-2"></i>Search Flights</button>
        </div>
    </div>
</form>

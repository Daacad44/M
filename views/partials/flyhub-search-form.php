<form action="<?= url('flights/search') ?>" method="GET" class="flyhub-search-form" id="flyhubSearchForm">
    <div class="flyhub-search-tabs">
        <button type="button" class="flyhub-tab active" data-tab="flights">
            <i class="fas fa-plane"></i> Flights
        </button>
        <button type="button" class="flyhub-tab" data-tab="hotels">
            <i class="fas fa-hotel"></i> Hotels
        </button>
        <button type="button" class="flyhub-tab" data-tab="cars">
            <i class="fas fa-car"></i> Car Rentals
        </button>
    </div>

    <div class="flyhub-search-body">
        <div class="flyhub-trip-types">
            <label class="flyhub-radio">
                <input type="radio" name="trip_type" value="round_trip" <?= ($filters['trip_type'] ?? 'round_trip') === 'round_trip' ? 'checked' : '' ?>>
                <span class="flyhub-radio-mark"></span>
                Round Trip
            </label>
            <label class="flyhub-radio">
                <input type="radio" name="trip_type" value="one_way" <?= ($filters['trip_type'] ?? '') === 'one_way' ? 'checked' : '' ?>>
                <span class="flyhub-radio-mark"></span>
                One Way
            </label>
            <label class="flyhub-radio">
                <input type="radio" name="trip_type" value="multi_city" <?= ($filters['trip_type'] ?? '') === 'multi_city' ? 'checked' : '' ?>>
                <span class="flyhub-radio-mark"></span>
                Multi City
            </label>
        </div>

        <div class="flyhub-search-fields">
            <div class="flyhub-field-group flyhub-field-from">
                <label class="flyhub-field-label">FROM</label>
                <div class="flyhub-field-input">
                    <i class="fas fa-map-marker-alt flyhub-field-icon"></i>
                    <select name="from" class="flyhub-select" required>
                        <option value="">Select City</option>
                        <?php foreach ($airports as $ap): ?>
                        <option value="<?= $ap['id'] ?>" <?= ($filters['from'] ?? '') == $ap['id'] ? 'selected' : '' ?>>
                            <?= e($ap['city']) ?> (<?= e($ap['code']) ?>)
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <button type="button" class="flyhub-swap-btn" id="flyhubSwapBtn" aria-label="Swap airports">
                <i class="fas fa-exchange-alt"></i>
            </button>

            <div class="flyhub-field-group flyhub-field-to">
                <label class="flyhub-field-label">TO</label>
                <div class="flyhub-field-input">
                    <i class="fas fa-map-marker-alt flyhub-field-icon"></i>
                    <select name="to" class="flyhub-select" required>
                        <option value="">Select City</option>
                        <?php foreach ($airports as $ap): ?>
                        <option value="<?= $ap['id'] ?>" <?= ($filters['to'] ?? '') == $ap['id'] ? 'selected' : '' ?>>
                            <?= e($ap['city']) ?> (<?= e($ap['code']) ?>)
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="flyhub-field-group">
                <label class="flyhub-field-label">DEPART</label>
                <div class="flyhub-field-input">
                    <i class="fas fa-calendar-alt flyhub-field-icon"></i>
                    <input type="date" name="departure_date" class="flyhub-input" value="<?= e($filters['departure_date'] ?? date('Y-m-d')) ?>" min="<?= date('Y-m-d') ?>" required>
                </div>
            </div>

            <div class="flyhub-field-group flyhub-return-field">
                <label class="flyhub-field-label">RETURN</label>
                <div class="flyhub-field-input">
                    <i class="fas fa-calendar-alt flyhub-field-icon"></i>
                    <input type="date" name="return_date" class="flyhub-input" value="<?= e($filters['return_date'] ?? date('Y-m-d', strtotime('+7 days'))) ?>" min="<?= date('Y-m-d') ?>">
                </div>
            </div>

            <div class="flyhub-field-group">
                <label class="flyhub-field-label">PASSENGERS</label>
                <div class="flyhub-field-input">
                    <i class="fas fa-user flyhub-field-icon"></i>
                    <select name="passengers" class="flyhub-select">
                        <?php for ($i = 1; $i <= 9; $i++): ?>
                        <option value="<?= $i ?>" <?= ($filters['passengers'] ?? 1) == $i ? 'selected' : '' ?>><?= $i ?> Passenger<?= $i > 1 ? 's' : '' ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>

            <div class="flyhub-field-group">
                <label class="flyhub-field-label">CLASS</label>
                <div class="flyhub-field-input">
                    <select name="cabin_class" class="flyhub-select flyhub-select-no-icon">
                        <option value="economy" <?= ($filters['cabin_class'] ?? 'economy') === 'economy' ? 'selected' : '' ?>>Economy</option>
                        <option value="premium_economy" <?= ($filters['cabin_class'] ?? '') === 'premium_economy' ? 'selected' : '' ?>>Premium Economy</option>
                        <option value="business" <?= ($filters['cabin_class'] ?? '') === 'business' ? 'selected' : '' ?>>Business</option>
                        <option value="first_class" <?= ($filters['cabin_class'] ?? '') === 'first_class' ? 'selected' : '' ?>>First Class</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="flyhub-search-btn">
                <i class="fas fa-search"></i>
                Search Flights
            </button>
        </div>
    </div>
</form>

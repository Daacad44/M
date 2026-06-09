<?php $pageTitle = 'Add Flight'; ?>
<h4 class="fw-bold mb-4">Add New Flight</h4>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="POST" action="<?= url('admin/flights/store') ?>">
            <?= Security::csrfField() ?>
            <div class="row g-3">
                <div class="col-md-4"><label class="form-label">Flight Number</label><input type="text" name="flight_number" class="form-control" required></div>
                <div class="col-md-4"><label class="form-label">Airline</label><select name="airline_id" class="form-select" required><?php foreach ($airlines as $a): ?><option value="<?= $a['id'] ?>"><?= e($a['name']) ?></option><?php endforeach; ?></select></div>
                <div class="col-md-4"><label class="form-label">Aircraft Type</label><input type="text" name="aircraft_type" class="form-control"></div>
                <div class="col-md-4"><label class="form-label">From</label><select name="departure_airport_id" class="form-select" required><?php foreach ($airports as $a): ?><option value="<?= $a['id'] ?>"><?= e($a['city']) ?> (<?= e($a['code']) ?>)</option><?php endforeach; ?></select></div>
                <div class="col-md-4"><label class="form-label">To</label><select name="arrival_airport_id" class="form-select" required><?php foreach ($airports as $a): ?><option value="<?= $a['id'] ?>"><?= e($a['city']) ?> (<?= e($a['code']) ?>)</option><?php endforeach; ?></select></div>
                <div class="col-md-4"><label class="form-label">Stops</label><input type="number" name="stops" class="form-control" value="0" min="0"></div>
                <div class="col-md-6"><label class="form-label">Departure Time</label><input type="datetime-local" name="departure_time" class="form-control" required></div>
                <div class="col-md-6"><label class="form-label">Arrival Time</label><input type="datetime-local" name="arrival_time" class="form-control" required></div>
                <div class="col-md-3"><label class="form-label">Economy Price</label><input type="number" step="0.01" name="economy_price" class="form-control" required></div>
                <div class="col-md-3"><label class="form-label">Premium Economy</label><input type="number" step="0.01" name="premium_economy_price" class="form-control"></div>
                <div class="col-md-3"><label class="form-label">Business</label><input type="number" step="0.01" name="business_price" class="form-control"></div>
                <div class="col-md-3"><label class="form-label">First Class</label><input type="number" step="0.01" name="first_class_price" class="form-control"></div>
                <div class="col-md-3"><label class="form-label">Economy Seats</label><input type="number" name="economy_seats" class="form-control" value="150"></div>
                <div class="col-md-3"><label class="form-label">Premium Seats</label><input type="number" name="premium_economy_seats" class="form-control" value="30"></div>
                <div class="col-md-3"><label class="form-label">Business Seats</label><input type="number" name="business_seats" class="form-control" value="20"></div>
                <div class="col-md-3"><label class="form-label">First Class Seats</label><input type="number" name="first_class_seats" class="form-control" value="8"></div>
                <div class="col-md-4"><label class="form-label">Status</label><select name="status" class="form-select"><option value="scheduled">Scheduled</option><option value="delayed">Delayed</option><option value="cancelled">Cancelled</option></select></div>
            </div>
            <button type="submit" class="btn btn-primary mt-4">Create Flight</button>
            <a href="<?= url('admin/flights') ?>" class="btn btn-outline-secondary mt-4">Cancel</a>
        </form>
    </div>
</div>

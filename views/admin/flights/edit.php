<?php $pageTitle = 'Edit Flight'; ?>
<h4 class="fw-bold mb-4">Edit Flight <?= e($flight['flight_number']) ?></h4>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="POST" action="<?= url('admin/flights/update/' . $flight['id']) ?>">
            <?= Security::csrfField() ?>
            <div class="row g-3">
                <div class="col-md-4"><label class="form-label">Flight Number</label><input type="text" name="flight_number" class="form-control" value="<?= e($flight['flight_number']) ?>" required></div>
                <div class="col-md-4"><label class="form-label">Airline</label><select name="airline_id" class="form-select" required><?php foreach ($airlines as $a): ?><option value="<?= $a['id'] ?>" <?= $flight['airline_id'] == $a['id'] ? 'selected' : '' ?>><?= e($a['name']) ?></option><?php endforeach; ?></select></div>
                <div class="col-md-4"><label class="form-label">Aircraft</label><input type="text" name="aircraft_type" class="form-control" value="<?= e($flight['aircraft_type']) ?>"></div>
                <div class="col-md-4"><label class="form-label">From</label><select name="departure_airport_id" class="form-select" required><?php foreach ($airports as $a): ?><option value="<?= $a['id'] ?>" <?= $flight['departure_airport_id'] == $a['id'] ? 'selected' : '' ?>><?= e($a['city']) ?> (<?= e($a['code']) ?>)</option><?php endforeach; ?></select></div>
                <div class="col-md-4"><label class="form-label">To</label><select name="arrival_airport_id" class="form-select" required><?php foreach ($airports as $a): ?><option value="<?= $a['id'] ?>" <?= $flight['arrival_airport_id'] == $a['id'] ? 'selected' : '' ?>><?= e($a['city']) ?> (<?= e($a['code']) ?>)</option><?php endforeach; ?></select></div>
                <div class="col-md-4"><label class="form-label">Stops</label><input type="number" name="stops" class="form-control" value="<?= $flight['stops'] ?>"></div>
                <div class="col-md-6"><label class="form-label">Departure</label><input type="datetime-local" name="departure_time" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($flight['departure_time'])) ?>" required></div>
                <div class="col-md-6"><label class="form-label">Arrival</label><input type="datetime-local" name="arrival_time" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($flight['arrival_time'])) ?>" required></div>
                <div class="col-md-3"><label class="form-label">Economy</label><input type="number" step="0.01" name="economy_price" class="form-control" value="<?= $flight['economy_price'] ?>"></div>
                <div class="col-md-3"><label class="form-label">Premium</label><input type="number" step="0.01" name="premium_economy_price" class="form-control" value="<?= $flight['premium_economy_price'] ?>"></div>
                <div class="col-md-3"><label class="form-label">Business</label><input type="number" step="0.01" name="business_price" class="form-control" value="<?= $flight['business_price'] ?>"></div>
                <div class="col-md-3"><label class="form-label">First</label><input type="number" step="0.01" name="first_class_price" class="form-control" value="<?= $flight['first_class_price'] ?>"></div>
                <div class="col-md-4"><label class="form-label">Status</label><select name="status" class="form-select"><?php foreach (['scheduled','delayed','cancelled','completed'] as $s): ?><option value="<?= $s ?>" <?= $flight['status'] === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option><?php endforeach; ?></select></div>
            </div>
            <button type="submit" class="btn btn-primary mt-4">Update</button>
        </form>
    </div>
</div>

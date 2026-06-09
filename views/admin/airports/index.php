<?php $pageTitle = 'Airports'; ?>
<div class="d-flex justify-content-between mb-4">
    <h4 class="fw-bold mb-0">Airports</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAirportModal"><i class="fas fa-plus me-1"></i>Add Airport</button>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <table class="table table-hover data-table">
            <thead><tr><th>Code</th><th>Name</th><th>City</th><th>Country</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
                <?php foreach ($airports as $a): ?>
                <tr>
                    <td><strong><?= e($a['code']) ?></strong></td>
                    <td><?= e($a['name']) ?></td>
                    <td><?= e($a['city']) ?></td>
                    <td><?= e($a['country']) ?></td>
                    <td><span class="badge bg-<?= $a['status'] === 'active' ? 'success' : 'secondary' ?>"><?= ucfirst($a['status']) ?></span></td>
                    <td>
                        <form method="POST" action="<?= url('admin/airports/delete/' . $a['id']) ?>" class="d-inline" onsubmit="return confirm('Delete?')"><?= Security::csrfField() ?><button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button></form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="addAirportModal" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content">
        <form method="POST" action="<?= url('admin/airports/store') ?>">
            <?= Security::csrfField() ?>
            <div class="modal-header"><h5 class="modal-title">Add Airport</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <div class="mb-3"><label class="form-label">Name</label><input type="text" name="name" class="form-control" required></div>
                <div class="row"><div class="col-6 mb-3"><label class="form-label">Code</label><input type="text" name="code" class="form-control" maxlength="10" required></div>
                <div class="col-6 mb-3"><label class="form-label">Timezone</label><input type="text" name="timezone" class="form-control" value="UTC"></div></div>
                <div class="row"><div class="col-6 mb-3"><label class="form-label">City</label><input type="text" name="city" class="form-control" required></div>
                <div class="col-6 mb-3"><label class="form-label">Country</label><input type="text" name="country" class="form-control" required></div></div>
            </div>
            <div class="modal-footer"><button type="submit" class="btn btn-primary">Save</button></div>
        </form>
    </div></div>
</div>

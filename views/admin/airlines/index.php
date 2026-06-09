<?php $pageTitle = 'Airlines'; ?>
<div class="d-flex justify-content-between mb-4">
    <h4 class="fw-bold mb-0">Airlines</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAirlineModal"><i class="fas fa-plus me-1"></i>Add Airline</button>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <table class="table table-hover data-table">
            <thead><tr><th>Name</th><th>Code</th><th>Contact</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
                <?php foreach ($airlines as $a): ?>
                <tr>
                    <td><strong><?= e($a['name']) ?></strong></td>
                    <td><?= e($a['code']) ?></td>
                    <td><?= e($a['contact_email'] ?? '-') ?></td>
                    <td><span class="badge bg-<?= $a['status'] === 'active' ? 'success' : 'secondary' ?>"><?= ucfirst($a['status']) ?></span></td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editAirline<?= $a['id'] ?>"><i class="fas fa-edit"></i></button>
                        <form method="POST" action="<?= url('admin/airlines/delete/' . $a['id']) ?>" class="d-inline" onsubmit="return confirm('Delete?')"><?= Security::csrfField() ?><button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button></form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="addAirlineModal" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content">
        <form method="POST" action="<?= url('admin/airlines/store') ?>" enctype="multipart/form-data">
            <?= Security::csrfField() ?>
            <div class="modal-header"><h5 class="modal-title">Add Airline</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <div class="mb-3"><label class="form-label">Name</label><input type="text" name="name" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Code</label><input type="text" name="code" class="form-control" maxlength="10" required></div>
                <div class="mb-3"><label class="form-label">Email</label><input type="email" name="contact_email" class="form-control"></div>
                <div class="mb-3"><label class="form-label">Phone</label><input type="text" name="contact_phone" class="form-control"></div>
                <div class="mb-3"><label class="form-label">Logo</label><input type="file" name="logo" class="form-control" accept="image/*"></div>
            </div>
            <div class="modal-footer"><button type="submit" class="btn btn-primary">Save</button></div>
        </form>
    </div></div>
</div>

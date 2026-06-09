<?php $pageTitle = 'FAQs'; ?>
<div class="d-flex justify-content-between mb-4">
    <h4 class="fw-bold mb-0">FAQs</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFaqModal"><i class="fas fa-plus me-1"></i>Add FAQ</button>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <table class="table data-table">
            <thead><tr><th>#</th><th>Question</th><th>Category</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
                <?php foreach ($faqs as $f): ?>
                <tr>
                    <td><?= $f['sort_order'] ?></td>
                    <td><?= e($f['question']) ?></td>
                    <td><?= e($f['category']) ?></td>
                    <td><span class="badge bg-<?= $f['status'] === 'active' ? 'success' : 'secondary' ?>"><?= ucfirst($f['status']) ?></span></td>
                    <td><form method="POST" action="<?= url('admin/faqs/delete/' . $f['id']) ?>" class="d-inline" onsubmit="return confirm('Delete?')"><?= Security::csrfField() ?><button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button></form></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="addFaqModal" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content">
        <form method="POST" action="<?= url('admin/faqs/store') ?>">
            <?= Security::csrfField() ?>
            <div class="modal-header"><h5 class="modal-title">Add FAQ</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <div class="mb-3"><label class="form-label">Question</label><input type="text" name="question" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Answer</label><textarea name="answer" class="form-control" rows="3" required></textarea></div>
                <div class="row"><div class="col-6 mb-3"><label class="form-label">Category</label><input type="text" name="category" class="form-control" value="General"></div>
                <div class="col-6 mb-3"><label class="form-label">Sort Order</label><input type="number" name="sort_order" class="form-control" value="0"></div></div>
            </div>
            <div class="modal-footer"><button type="submit" class="btn btn-primary">Save</button></div>
        </form>
    </div></div>
</div>

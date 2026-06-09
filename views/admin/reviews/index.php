<?php $pageTitle = 'Reviews'; ?>
<h4 class="fw-bold mb-4">Reviews</h4>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <table class="table table-hover data-table">
            <thead><tr><th>User</th><th>Airline</th><th>Rating</th><th>Title</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
                <?php foreach ($reviews as $r): ?>
                <tr>
                    <td><?= e($r['user_name']) ?></td>
                    <td><?= e($r['airline_name'] ?? '-') ?></td>
                    <td><?php for ($i = 0; $i < $r['rating']; $i++): ?><i class="fas fa-star text-warning"></i><?php endfor; ?></td>
                    <td><?= e($r['title'] ?? '-') ?></td>
                    <td><span class="badge bg-<?= $r['status'] === 'approved' ? 'success' : 'warning' ?>"><?= ucfirst($r['status']) ?></span></td>
                    <td>
                        <form method="POST" action="<?= url('admin/reviews/update/' . $r['id']) ?>" class="d-inline"><?= Security::csrfField() ?>
                            <select name="status" class="form-select form-select-sm d-inline-block w-auto" onchange="this.form.submit()">
                                <?php foreach (['pending','approved','rejected'] as $s): ?><option value="<?= $s ?>" <?= $r['status'] === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option><?php endforeach; ?>
                            </select>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

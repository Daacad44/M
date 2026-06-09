<?php $pageTitle = 'Users'; ?>
<h4 class="fw-bold mb-4">Users</h4>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <table class="table table-hover data-table">
            <thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th>Joined</th><th>Actions</th></tr></thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                <tr>
                    <td><?= e($u['full_name']) ?></td>
                    <td><?= e($u['email']) ?></td>
                    <td><span class="badge bg-<?= $u['role'] === 'admin' ? 'danger' : 'primary' ?>"><?= ucfirst($u['role']) ?></span></td>
                    <td><span class="badge bg-<?= $u['status'] === 'active' ? 'success' : 'secondary' ?>"><?= ucfirst($u['status']) ?></span></td>
                    <td><?= formatDate($u['created_at']) ?></td>
                    <td>
                        <form method="POST" action="<?= url('admin/users/status/' . $u['id']) ?>" class="d-inline"><?= Security::csrfField() ?>
                            <select name="status" class="form-select form-select-sm d-inline-block w-auto" onchange="this.form.submit()">
                                <?php foreach (['active','inactive','banned'] as $s): ?><option value="<?= $s ?>" <?= $u['status'] === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option><?php endforeach; ?>
                            </select>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

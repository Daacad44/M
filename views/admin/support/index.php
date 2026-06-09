<?php $pageTitle = 'Support Tickets'; ?>
<h4 class="fw-bold mb-4">Support Tickets</h4>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <?php foreach ($tickets as $t): ?>
        <div class="border rounded p-3 mb-3">
            <div class="d-flex justify-content-between mb-2">
                <strong><?= e($t['ticket_number']) ?> - <?= e($t['subject']) ?></strong>
                <span class="badge bg-<?= $t['status'] === 'resolved' ? 'success' : 'warning' ?>"><?= ucfirst($t['status']) ?></span>
            </div>
            <p class="text-muted small mb-1">From: <?= e($t['name']) ?> (<?= e($t['email']) ?>) · <?= formatDateTime($t['created_at']) ?></p>
            <p class="mb-2"><?= e($t['message']) ?></p>
            <?php if ($t['admin_reply']): ?><div class="bg-light p-2 rounded small"><strong>Reply:</strong> <?= e($t['admin_reply']) ?></div><?php endif; ?>
            <form method="POST" action="<?= url('admin/support/reply/' . $t['id']) ?>" class="mt-2">
                <?= Security::csrfField() ?>
                <div class="input-group input-group-sm">
                    <input type="text" name="admin_reply" class="form-control" placeholder="Reply...">
                    <select name="status" class="form-select" style="max-width:120px"><option value="in_progress">In Progress</option><option value="resolved">Resolved</option><option value="closed">Closed</option></select>
                    <button class="btn btn-primary">Send</button>
                </div>
            </form>
        </div>
        <?php endforeach; ?>
    </div>
</div>

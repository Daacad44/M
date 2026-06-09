<?php $pageTitle = 'Notifications'; ?>
<div class="p-4">
    <h3 class="fw-bold mb-4">Notifications</h3>
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <?php if (empty($notifications)): ?>
                <p class="text-muted text-center py-4">No notifications yet.</p>
            <?php else: ?>
                <?php foreach ($notifications as $n): ?>
                <div class="d-flex align-items-start mb-3 pb-3 border-bottom <?= $n['is_read'] ? '' : 'bg-light rounded p-2' ?>">
                    <div class="me-3">
                        <i class="fas fa-<?= $n['type'] === 'payment' ? 'credit-card' : ($n['type'] === 'booking' ? 'ticket-alt' : 'bell') ?> text-primary fa-lg"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-1"><?= e($n['title']) ?></h6>
                        <p class="text-muted small mb-1"><?= e($n['message']) ?></p>
                        <small class="text-muted"><?= formatDateTime($n['created_at']) ?></small>
                    </div>
                    <?php if ($n['link']): ?>
                    <a href="<?= e($n['link']) ?>" class="btn btn-sm btn-outline-primary">View</a>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

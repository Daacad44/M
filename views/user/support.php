<?php $pageTitle = 'Support'; ?>
<div class="p-4">
    <h3 class="fw-bold mb-4">Support Center</h3>
    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold">Create Ticket</div>
                <div class="card-body">
                    <form method="POST" action="<?= url('user/support') ?>">
                        <?= Security::csrfField() ?>
                        <div class="mb-3">
                            <label class="form-label">Subject</label>
                            <input type="text" name="subject" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Priority</label>
                            <select name="priority" class="form-select">
                                <option value="low">Low</option>
                                <option value="medium" selected>Medium</option>
                                <option value="high">High</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea name="message" class="form-control" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Ticket</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold">My Tickets</div>
                <div class="card-body">
                    <?php if (empty($tickets)): ?>
                        <p class="text-muted">No support tickets yet.</p>
                    <?php else: ?>
                        <table class="table table-sm">
                            <thead><tr><th>#</th><th>Subject</th><th>Status</th><th>Date</th></tr></thead>
                            <tbody>
                                <?php foreach ($tickets as $t): ?>
                                <tr>
                                    <td><?= e($t['ticket_number']) ?></td>
                                    <td><?= e($t['subject']) ?></td>
                                    <td><span class="badge bg-<?= $t['status'] === 'resolved' ? 'success' : 'warning' ?>"><?= ucfirst($t['status']) ?></span></td>
                                    <td><?= formatDate($t['created_at']) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

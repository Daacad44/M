<?php
$success = Session::flash('success');
$error = Session::flash('error');
$info = Session::flash('info');
?>
<?php if ($success): ?>
<div class="alert alert-success alert-dismissible fade show m-3" role="alert">
    <i class="fas fa-check-circle me-2"></i><?= e($success) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>
<?php if ($error): ?>
<div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
    <i class="fas fa-exclamation-circle me-2"></i><?= e($error) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>
<?php if ($info): ?>
<div class="alert alert-info alert-dismissible fade show m-3" role="alert">
    <i class="fas fa-info-circle me-2"></i><?= e($info) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'Admin') ?> - <?= e(config('app.name')) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="<?= asset('css/admin.css') ?>" rel="stylesheet">
</head>
<body>
    <div class="d-flex">
        <div class="admin-sidebar">
            <?php partial('admin-sidebar'); ?>
        </div>
        <div class="admin-content flex-grow-1">
            <div class="admin-topbar d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><?= e($pageTitle ?? 'Admin Dashboard') ?></h5>
                <div>
                    <span class="text-muted me-3"><?= e(Session::get('user_name')) ?></span>
                    <a href="<?= url('') ?>" class="btn btn-sm btn-outline-primary me-2"><i class="fas fa-home"></i></a>
                    <a href="<?= url('logout') ?>" class="btn btn-sm btn-outline-danger"><i class="fas fa-sign-out-alt"></i></a>
                </div>
            </div>
            <div class="p-4">
                <?php partial('alerts'); ?>
                <?= $content ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
    <script src="<?= asset('js/admin.js') ?>"></script>
</body>
</html>

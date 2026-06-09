<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'Authentication') ?> - <?= e(config('app.name')) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="<?= asset('css/style.css') ?>" rel="stylesheet">
</head>
<body class="auth-page">
    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="text-center mb-4">
                <a href="<?= url('') ?>" class="text-decoration-none">
                    <i class="fas fa-plane-departure fa-2x text-primary"></i>
                    <h3 class="mt-2 text-primary fw-bold"><?= e(config('app.name')) ?></h3>
                </a>
            </div>
            <?php partial('alerts'); ?>
            <?= $content ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>

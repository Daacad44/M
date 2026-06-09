<?php

function config(string $key, mixed $default = null): mixed
{
    static $configs = [];
    $parts = explode('.', $key);
    $file = $parts[0];

    if (!isset($configs[$file])) {
        $path = BASE_PATH . "/config/{$file}.php";
        $configs[$file] = file_exists($path) ? require $path : [];
    }

    $value = $configs[$file];
    for ($i = 1; $i < count($parts); $i++) {
        $value = $value[$parts[$i]] ?? $default;
    }
    return $value ?? $default;
}

function url(string $path = ''): string
{
    $base = rtrim(config('app.url'), '/');
    return $base . '/' . ltrim($path, '/');
}

function asset(string $path): string
{
    return url('assets/' . ltrim($path, '/'));
}

function redirect(string $path): void
{
    header('Location: ' . url($path));
    exit;
}

function old(string $key, string $default = ''): string
{
    return Security::escape(Session::get('_old')[$key] ?? $default);
}

function setOld(array $data): void
{
    Session::set('_old', $data);
}

function e(?string $value): string
{
    return Security::escape($value);
}

function formatMoney(float $amount, ?string $symbol = null): string
{
    $symbol = $symbol ?? config('app.currency_symbol', '$');
    return $symbol . number_format($amount, 2);
}

function formatDate(?string $date, string $format = 'M d, Y'): string
{
    if (!$date) return '';
    return date($format, strtotime($date));
}

function formatDateTime(?string $date, string $format = 'M d, Y H:i'): string
{
    if (!$date) return '';
    return date($format, strtotime($date));
}

function formatDuration(int $minutes): string
{
    $hours = intdiv($minutes, 60);
    $mins = $minutes % 60;
    return "{$hours}h {$mins}m";
}

function generateBookingReference(): string
{
    $prefix = config('app.booking.reference_prefix', 'SW');
    return $prefix . strtoupper(substr(uniqid(), -6)) . random_int(100, 999);
}

function generateTicketNumber(): string
{
    $prefix = config('app.booking.ticket_prefix', 'TKT');
    return $prefix . date('ymd') . random_int(100000, 999999);
}

function generateSupportTicketNumber(): string
{
    return 'SUP' . date('ymd') . random_int(1000, 9999);
}

function jsonResponse(array $data, int $code = 200): void
{
    http_response_code($code);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

function isPost(): bool
{
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

function isAjax(): bool
{
    return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

function post(string $key, mixed $default = null): mixed
{
    return $_POST[$key] ?? $default;
}

function get(string $key, mixed $default = null): mixed
{
    return $_GET[$key] ?? $default;
}

function uploadFile(array $file, string $directory, array $allowed = []): ?string
{
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!empty($allowed) && !in_array($ext, $allowed)) {
        return null;
    }
    if ($file['size'] > config('app.upload.max_size', 2097152)) {
        return null;
    }
    $filename = Security::generateToken(16) . '.' . $ext;
    $path = BASE_PATH . '/' . trim($directory, '/') . '/' . $filename;
    if (!is_dir(dirname($path))) {
        mkdir(dirname($path), 0755, true);
    }
    if (move_uploaded_file($file['tmp_name'], $path)) {
        return $filename;
    }
    return null;
}

function cabinClassLabel(string $class): string
{
    return match ($class) {
        'economy' => 'Economy',
        'premium_economy' => 'Premium Economy',
        'business' => 'Business',
        'first_class' => 'First Class',
        default => ucfirst($class),
    };
}

function bookingStatusBadge(string $status): string
{
    $classes = [
        'pending' => 'warning',
        'confirmed' => 'success',
        'cancelled' => 'danger',
        'completed' => 'info',
    ];
    $class = $classes[$status] ?? 'secondary';
    return '<span class="badge bg-' . $class . '">' . ucfirst($status) . '</span>';
}

function paymentStatusBadge(string $status): string
{
    $classes = [
        'pending' => 'warning',
        'paid' => 'success',
        'failed' => 'danger',
        'refunded' => 'info',
    ];
    $class = $classes[$status] ?? 'secondary';
    return '<span class="badge bg-' . $class . '">' . ucfirst($status) . '</span>';
}

function view(string $name, array $data = [], ?string $layout = 'main'): void
{
    extract($data);
    $viewFile = BASE_PATH . '/views/' . str_replace('.', '/', $name) . '.php';
    if (!file_exists($viewFile)) {
        throw new RuntimeException("View not found: {$name}");
    }
    ob_start();
    require $viewFile;
    $content = ob_get_clean();

    if ($layout) {
        $layoutFile = BASE_PATH . '/views/layouts/' . $layout . '.php';
        if (file_exists($layoutFile)) {
            require $layoutFile;
            return;
        }
    }
    echo $content;
}

function partial(string $name, array $data = []): void
{
    extract($data);
    require BASE_PATH . '/views/partials/' . $name . '.php';
}

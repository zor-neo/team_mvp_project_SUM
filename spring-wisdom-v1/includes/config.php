<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    $secureCookie = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => $secureCookie,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

define('APP_NAME', 'Spring Wisdom');
define('BASE_PATH', rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/'));

function app_env(): string
{
    return getenv('APP_ENV') ?: 'local';
}

function is_production(): bool
{
    return app_env() === 'production';
}

function url_for(string $path): string
{
    $path = ltrim($path, '/');
    return (BASE_PATH === '' ? '' : BASE_PATH) . '/' . $path;
}

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function is_post(): bool
{
    return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

function require_csrf(): void
{
    $token = $_POST['csrf_token'] ?? '';
    if (!is_string($token) || !hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        flash('Your form session expired. Please try again.', 'danger');
        redirect_to('home.php');
    }
}

function redirect_to(string $path): never
{
    header('Location: ' . url_for($path));
    exit;
}

function avatar_url(?array $user): string
{
    $path = $user['profile_pic_path'] ?? '';
    if ($path !== '') {
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }
        return url_for($path);
    }
    return url_for('assets/images/default-avatar.svg');
}

function flash(string $message, string $type = 'success'): void
{
    $_SESSION['flash'][] = ['message' => $message, 'type' => $type];
}

function consume_flash(): array
{
    $items = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $items;
}

function production_config_error(string $message): never
{
    http_response_code(500);
    echo '<!doctype html><html lang="en"><head><meta charset="utf-8"><title>Configuration Error</title></head><body style="font-family: system-ui; padding: 2rem;"><h1>Spring Wisdom configuration error</h1><p>' . e($message) . '</p></body></html>';
    exit;
}

function ensure_production_config(): void
{
    if (!is_production()) {
        return;
    }
    foreach (['SUPABASE_DB_DSN', 'SUPABASE_DB_USER', 'SUPABASE_DB_PASSWORD'] as $name) {
        if ((getenv($name) ?: '') === '') {
            production_config_error($name . ' is required when APP_ENV=production.');
        }
    }
}

ensure_production_config();

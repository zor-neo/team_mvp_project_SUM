<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('APP_NAME', 'Spring Wisdom');
define('BASE_PATH', rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/'));

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

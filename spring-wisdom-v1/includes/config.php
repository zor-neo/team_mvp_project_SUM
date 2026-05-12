<?php
declare(strict_types=1);

require_once __DIR__ . '/env.php';

load_local_env(dirname(__DIR__) . '/.env');

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

function render_article_body(?string $body): string
{
    $lines = preg_split('/\R/', (string) $body);
    if ($lines === false) {
        return nl2br(e($body));
    }

    $html = '';
    $plain = [];
    $count = count($lines);

    $flushPlain = function () use (&$html, &$plain): void {
        if (!$plain) {
            return;
        }
        $html .= nl2br(e(implode("\n", $plain))) . "\n";
        $plain = [];
    };

    for ($i = 0; $i < $count; $i++) {
        $line = $lines[$i];
        $next = $lines[$i + 1] ?? '';
        if (is_markdown_table_header($line, $next)) {
            $flushPlain();
            $rows = [$line];
            $separator = $next;
            $i += 2;
            while ($i < $count && trim($lines[$i]) !== '' && str_contains($lines[$i], '|')) {
                $rows[] = $lines[$i];
                $i++;
            }
            $i--;
            $html .= render_markdown_table($rows, $separator);
            continue;
        }
        $plain[] = $line;
    }

    $flushPlain();
    return $html;
}

function is_markdown_table_header(string $header, string $separator): bool
{
    return str_contains($header, '|') && is_markdown_table_separator($separator);
}

function is_markdown_table_separator(string $line): bool
{
    if (!str_contains($line, '|')) {
        return false;
    }

    $cells = markdown_table_cells($line);
    if (count($cells) < 2) {
        return false;
    }

    foreach ($cells as $cell) {
        if (!preg_match('/^:?-{3,}:?$/', str_replace(' ', '', $cell))) {
            return false;
        }
    }
    return true;
}

function markdown_table_cells(string $line): array
{
    $line = trim($line);
    $line = trim($line, '|');
    return array_map('trim', explode('|', $line));
}

function markdown_table_alignments(string $separator): array
{
    return array_map(function (string $cell): string {
        $cell = str_replace(' ', '', $cell);
        $starts = str_starts_with($cell, ':');
        $ends = str_ends_with($cell, ':');
        if ($starts && $ends) {
            return 'center';
        }
        if ($ends) {
            return 'end';
        }
        return 'start';
    }, markdown_table_cells($separator));
}

function render_markdown_table(array $rows, string $separator): string
{
    $header = markdown_table_cells((string) array_shift($rows));
    $alignments = markdown_table_alignments($separator);
    $html = '<div class="article-table-wrap"><table class="table table-sm article-table"><thead><tr>';
    foreach ($header as $index => $cell) {
        $align = $alignments[$index] ?? 'start';
        $html .= '<th scope="col" class="text-' . e($align) . '">' . render_markdown_inline($cell) . '</th>';
    }
    $html .= '</tr></thead><tbody>';

    foreach ($rows as $row) {
        $cells = markdown_table_cells((string) $row);
        $html .= '<tr>';
        for ($i = 0; $i < count($header); $i++) {
            $align = $alignments[$i] ?? 'start';
            $html .= '<td class="text-' . e($align) . '">' . render_markdown_inline($cells[$i] ?? '') . '</td>';
        }
        $html .= '</tr>';
    }

    return $html . '</tbody></table></div>';
}

function render_markdown_inline(string $value): string
{
    $escaped = e($value);
    $escaped = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $escaped) ?? $escaped;
    return preg_replace('/`([^`]+)`/', '<code>$1</code>', $escaped) ?? $escaped;
}

function friendly_time(?string $value): string
{
    if (!$value) {
        return 'recently';
    }

    $timestamp = strtotime($value);
    if (!$timestamp) {
        return $value;
    }

    $diff = time() - $timestamp;
    if ($diff < 60 && $diff >= 0) {
        return 'just now';
    }
    if ($diff < 3600 && $diff >= 0) {
        $minutes = max(1, (int) floor($diff / 60));
        return $minutes . ' min ago';
    }
    if ($diff < 86400 && $diff >= 0) {
        $hours = max(1, (int) floor($diff / 3600));
        return $hours . ' hr' . ($hours === 1 ? '' : 's') . ' ago';
    }
    if ($diff < 604800 && $diff >= 0) {
        $days = max(1, (int) floor($diff / 86400));
        return $days . ' day' . ($days === 1 ? '' : 's') . ' ago';
    }

    return date('M j, Y', $timestamp);
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
        if (str_starts_with(str_replace('\\', '/', $path), 'uploads/profiles/') && !empty($user['id'])) {
            return url_for('profile-photo.php?id=' . (int) $user['id']);
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

<?php
require_once __DIR__ . '/includes/auth.php';
require_login();

$requestedId = (int) ($_GET['id'] ?? 0);
$viewer = actual_user();
if (!$viewer || $requestedId <= 0) {
    http_response_code(404);
    exit;
}

if ((int) $viewer['id'] !== $requestedId && !is_admin_account()) {
    http_response_code(403);
    exit;
}

$profileUser = find_user_by_id($requestedId);
$relativePath = str_replace('\\', '/', (string) ($profileUser['profile_pic_path'] ?? ''));
if (!str_starts_with($relativePath, 'uploads/profiles/')) {
    http_response_code(404);
    exit;
}

$root = realpath(__DIR__ . '/uploads/profiles');
$file = $root === false ? false : realpath(__DIR__ . '/' . $relativePath);
$rootPrefix = $root === false ? '' : rtrim($root, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
if ($file === false || $rootPrefix === '' || !str_starts_with($file, $rootPrefix) || !is_file($file)) {
    http_response_code(404);
    exit;
}

$mime = 'application/octet-stream';
if (function_exists('finfo_open')) {
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $detected = finfo_file($finfo, $file);
    finfo_close($finfo);
    if (is_string($detected) && in_array($detected, ['image/jpeg', 'image/png', 'image/gif', 'image/webp'], true)) {
        $mime = $detected;
    }
}

header('Content-Type: ' . $mime);
header('Content-Length: ' . (string) filesize($file));
header('Cache-Control: private, max-age=300');
header('X-Content-Type-Options: nosniff');
readfile($file);

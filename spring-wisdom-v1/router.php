<?php
declare(strict_types=1);

if (PHP_SAPI !== 'cli-server') {
    require __DIR__ . '/index.php';
    return;
}

$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$requestPath = str_replace('\\', '/', rawurldecode($requestPath));
$segments = array_values(array_filter(explode('/', trim($requestPath, '/')), fn($segment) => $segment !== ''));
$basename = end($segments) ?: '';
$extension = strtolower(pathinfo($basename, PATHINFO_EXTENSION));

$blockedExtensions = ['env', 'sql', 'md', 'log', 'ini', 'conf', 'bak', 'dist', 'yml', 'yaml'];
$blockedDirectories = ['uploads'];
$blockedNames = [
    'composer.json',
    'composer.lock',
    'package.json',
    'package-lock.json',
    'yarn.lock',
    'pnpm-lock.yaml',
    'spring wisdom.code-workspace',
];

$hasDotSegment = false;
foreach ($segments as $segment) {
    if (str_starts_with($segment, '.')) {
        $hasDotSegment = true;
        break;
    }
}

if (
    $hasDotSegment ||
    array_intersect($segments, $blockedDirectories) ||
    in_array($extension, $blockedExtensions, true) ||
    in_array(strtolower($basename), $blockedNames, true)
) {
    http_response_code(404);
    header('Content-Type: text/plain; charset=UTF-8');
    echo 'Not found';
    return;
}

$file = realpath(__DIR__ . $requestPath);
$root = realpath(__DIR__);
$rootPrefix = $root === false ? '' : rtrim($root, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
if ($file !== false && $rootPrefix !== '' && str_starts_with($file, $rootPrefix) && is_file($file)) {
    return false;
}

require __DIR__ . '/index.php';

<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';

function storage_upload(array $file, int $contentId): ?string
{
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
        flash('The file could not be uploaded.', 'danger');
        return null;
    }
    if (($file['size'] ?? 0) > 5 * 1024 * 1024) {
        flash('Source file must be 5MB or smaller.', 'danger');
        return null;
    }

    $safeName = preg_replace('/[^A-Za-z0-9._-]/', '-', basename($file['name']));
    $ext = strtolower(pathinfo($safeName, PATHINFO_EXTENSION));
    $allowedExt = ['pdf', 'txt', 'docx'];
    $allowedMime = [
        'pdf' => ['application/pdf'],
        'txt' => ['text/plain'],
        'docx' => ['application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/zip'],
    ];
    if (!in_array($ext, $allowedExt, true)) {
        flash('Source file must be PDF, TXT, or DOCX.', 'danger');
        return null;
    }
    $mime = function_exists('finfo_open') ? null : ($file['type'] ?? '');
    if (function_exists('finfo_open')) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
    }
    if ($mime && !in_array($mime, $allowedMime[$ext], true)) {
        flash('Source file type does not match the selected file.', 'danger');
        return null;
    }
    $storagePath = 'contents/' . $contentId . '/' . $safeName;

    $url = rtrim(getenv('SUPABASE_URL') ?: '', '/');
    $key = getenv('SUPABASE_SERVICE_ROLE_KEY') ?: '';
    $bucket = getenv('SUPABASE_STORAGE_BUCKET') ?: 'content-files';

    if ($url !== '' && $key !== '' && function_exists('curl_init')) {
        $endpoint = $url . '/storage/v1/object/' . rawurlencode($bucket) . '/' . str_replace('%2F', '/', rawurlencode($storagePath));
        $ch = curl_init($endpoint);
        curl_setopt_array($ch, [
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => file_get_contents($file['tmp_name']),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $key,
                'apikey: ' . $key,
                'Content-Type: application/octet-stream',
                'x-upsert: true',
            ],
        ]);
        $response = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($status >= 200 && $status < 300) {
            return $storagePath;
        }

        flash('Supabase Storage upload failed. Demo path was saved instead.', 'warning');
        if (is_production()) {
            return null;
        }
    }

    if (is_production()) {
        flash('Supabase Storage is required in production.', 'danger');
        return null;
    }

    $localDir = dirname(__DIR__) . '/uploads/contents/' . $contentId;
    if (!is_dir($localDir)) {
        mkdir($localDir, 0777, true);
    }
    move_uploaded_file($file['tmp_name'], $localDir . '/' . $safeName);

    return $storagePath;
}

function storage_signed_url(string $storagePath, int $expiresIn = 300): ?string
{
    $storagePath = ltrim($storagePath, '/');
    if ($storagePath === '') {
        return null;
    }

    if (storage_local_path($storagePath) !== null) {
        return null;
    }

    $url = rtrim(getenv('SUPABASE_URL') ?: '', '/');
    $key = getenv('SUPABASE_SERVICE_ROLE_KEY') ?: '';
    $bucket = getenv('SUPABASE_STORAGE_BUCKET') ?: 'content-files';
    if ($url === '' || $key === '' || !function_exists('curl_init')) {
        return null;
    }

    $endpoint = $url . '/storage/v1/object/sign/' . rawurlencode($bucket) . '/' . str_replace('%2F', '/', rawurlencode($storagePath));
    $ch = curl_init($endpoint);
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode(['expiresIn' => $expiresIn]),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 15,
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer ' . $key,
            'apikey: ' . $key,
            'Content-Type: application/json',
        ],
    ]);
    $response = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($status < 200 || $status >= 300 || !is_string($response)) {
        return null;
    }

    $payload = json_decode($response, true);
    $signedUrl = is_array($payload) ? (string) ($payload['signedURL'] ?? $payload['signedUrl'] ?? '') : '';
    if ($signedUrl === '') {
        return null;
    }
    if (str_starts_with($signedUrl, 'http://') || str_starts_with($signedUrl, 'https://')) {
        return $signedUrl;
    }
    if (str_starts_with($signedUrl, '/storage/v1/')) {
        return $url . $signedUrl;
    }

    return $url . '/storage/v1/' . ltrim($signedUrl, '/');
}

function storage_local_path(string $storagePath): ?string
{
    $storagePath = ltrim(str_replace('\\', '/', $storagePath), '/');
    if ($storagePath === '' || str_contains($storagePath, '..')) {
        return null;
    }

    $root = realpath(dirname(__DIR__) . '/uploads');
    if ($root === false) {
        return null;
    }

    $path = realpath($root . '/' . $storagePath);
    $rootPrefix = rtrim($root, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    if ($path === false || !str_starts_with($path, $rootPrefix) || !is_file($path)) {
        return null;
    }

    return $path;
}

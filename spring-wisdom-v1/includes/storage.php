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

    $safeName = preg_replace('/[^A-Za-z0-9._-]/', '-', basename($file['name']));
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
    }

    $localDir = dirname(__DIR__) . '/uploads/contents/' . $contentId;
    if (!is_dir($localDir)) {
        mkdir($localDir, 0777, true);
    }
    move_uploaded_file($file['tmp_name'], $localDir . '/' . $safeName);

    return $storagePath;
}


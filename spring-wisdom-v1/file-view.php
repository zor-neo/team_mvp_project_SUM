<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/storage.php';
require_login();

function attachment_view_mime(string $filename, string $fallback = 'application/octet-stream'): string
{
    return match (strtolower(pathinfo($filename, PATHINFO_EXTENSION))) {
        'pdf' => 'application/pdf',
        'txt' => 'text/plain; charset=UTF-8',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        default => $fallback,
    };
}

function send_inline_attachment_headers(string $filename, string $mime, ?int $length = null): void
{
    header('Content-Type: ' . $mime);
    if ($length !== null) {
        header('Content-Length: ' . (string) $length);
    }
    header('Content-Disposition: inline; filename="' . str_replace('"', '', $filename) . '"');
    header('X-Content-Type-Options: nosniff');
}

$content = content_by_id((int) ($_GET['id'] ?? 0));
if (!$content || empty($content['file_path'])) {
    flash('Attached file was not found.', 'warning');
    redirect_to('browse.php');
}

$isOwner = (int) ($content['author_id'] ?? 0) === (int) (actual_user()['id'] ?? 0);
$canOpen = ($content['status'] ?? '') === 'published' || is_admin_account() || $isOwner;
if (!$canOpen) {
    flash('You do not have permission to open that file.', 'danger');
    redirect_to('content.php?id=' . (int) $content['id']);
}

$signedUrl = storage_signed_url((string) $content['file_path']);
$localPath = storage_local_path((string) $content['file_path']);
$filename = basename((string) $content['file_path']);
if ($localPath !== null) {
    $mime = 'application/octet-stream';
    if (function_exists('finfo_open')) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $detected = finfo_file($finfo, $localPath);
        finfo_close($finfo);
        if (is_string($detected) && $detected !== '') {
            $mime = $detected;
        }
    }
    $mime = attachment_view_mime($filename, $mime);

    $fileSize = filesize($localPath);
    send_inline_attachment_headers($filename, $mime, is_int($fileSize) ? $fileSize : null);
    readfile($localPath);
    exit;
}

if (!$signedUrl) {
    flash('The attached file exists in the archive record, but the storage link could not be created.', 'danger');
    redirect_to('content.php?id=' . (int) $content['id']);
}

if (!function_exists('curl_init')) {
    header('Location: ' . $signedUrl);
    exit;
}

$ch = curl_init($signedUrl);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_TIMEOUT => 30,
]);
$fileBody = curl_exec($ch);
$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$remoteMime = (string) curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
curl_close($ch);

if ($status < 200 || $status >= 300 || !is_string($fileBody)) {
    flash('The attached file could not be opened from storage.', 'danger');
    redirect_to('content.php?id=' . (int) $content['id']);
}

send_inline_attachment_headers($filename, attachment_view_mime($filename, $remoteMime ?: 'application/octet-stream'), strlen($fileBody));
echo $fileBody;
exit;

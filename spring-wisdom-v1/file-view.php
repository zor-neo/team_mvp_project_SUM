<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/storage.php';
require_login();

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
if ($localPath !== null) {
    $filename = basename((string) $content['file_path']);
    $mime = function_exists('finfo_open') ? 'application/octet-stream' : 'application/octet-stream';
    if (function_exists('finfo_open')) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $detected = finfo_file($finfo, $localPath);
        finfo_close($finfo);
        if (is_string($detected) && $detected !== '') {
            $mime = $detected;
        }
    }

    header('Content-Type: ' . $mime);
    header('Content-Length: ' . (string) filesize($localPath));
    header('Content-Disposition: inline; filename="' . str_replace('"', '', $filename) . '"');
    header('X-Content-Type-Options: nosniff');
    readfile($localPath);
    exit;
}

if (!$signedUrl) {
    flash('The attached file exists in the archive record, but the storage link could not be created.', 'danger');
    redirect_to('content.php?id=' . (int) $content['id']);
}

header('Location: ' . $signedUrl);
exit;

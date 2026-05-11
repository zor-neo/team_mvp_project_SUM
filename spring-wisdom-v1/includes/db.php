<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';

function db(): ?PDO
{
    static $pdo = null;
    static $checked = false;

    if ($checked) {
        return $pdo;
    }

    $checked = true;
    $dsn = getenv('SUPABASE_DB_DSN') ?: '';
    $user = getenv('SUPABASE_DB_USER') ?: '';
    $password = getenv('SUPABASE_DB_PASSWORD') ?: '';

    if ($dsn === '') {
        return null;
    }

    try {
        $pdo = new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        return $pdo;
    } catch (Throwable $error) {
        $_SESSION['db_notice'] = 'Supabase database is not connected, using demo data.';
        return null;
    }
}

function using_database(): bool
{
    return db() instanceof PDO;
}


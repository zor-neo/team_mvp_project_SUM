<?php
declare(strict_types=1);

require_once __DIR__ . '/data.php';

function actual_user(): ?array
{
    if (!isset($_SESSION['user_id'])) {
        return null;
    }
    return find_user_by_id((int) $_SESSION['user_id']);
}

function actual_role(): ?string
{
    return actual_user()['role'] ?? null;
}

function is_admin_account(): bool
{
    return actual_role() === 'admin';
}

function effective_role(): ?string
{
    $actual = actual_role();
    if ($actual === 'admin' && in_array($_SESSION['audit_role'] ?? '', ['author', 'user'], true)) {
        return $_SESSION['audit_role'];
    }
    return $actual;
}

function current_user(): ?array
{
    $user = actual_user();
    if (!$user) {
        return null;
    }
    $user['actual_role'] = $user['role'];
    $user['role'] = effective_role();
    return $user;
}

function login_user(array $user): void
{
    session_regenerate_id(true);
    $_SESSION['user_id'] = (int) $user['id'];
    unset($_SESSION['audit_role']);
    unset($_SESSION['csrf_token']);
}

function logout_user(): void
{
    unset($_SESSION['user_id']);
    unset($_SESSION['audit_role']);
    unset($_SESSION['csrf_token']);
    session_regenerate_id(true);
}

function attempt_login(string $email, string $password): bool
{
    $user = find_user_by_email($email);
    if (!$user || !password_verify($password, $user['password_hash'] ?? '')) {
        return false;
    }
    login_user($user);
    return true;
}

function require_login(): void
{
    if (!current_user()) {
        flash('Please sign in to continue.', 'warning');
        redirect_to('index.php');
    }
}

function require_role(array $roles): void
{
    require_login();
    if (in_array('admin', $roles, true) && is_admin_account()) {
        return;
    }
    $role = effective_role();
    if (!$role || !in_array($role, $roles, true)) {
        flash('You do not have permission to access that page.', 'danger');
        redirect_to('home.php');
    }
}

function after_login_path(array $user): string
{
    return match ($user['role']) {
        'admin' => 'admin-dashboard.php',
        'author' => 'author-dashboard.php',
        default => 'browse.php',
    };
}

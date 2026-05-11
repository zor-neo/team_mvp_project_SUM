<?php
require_once __DIR__ . '/includes/auth.php';

require_login();

if (!is_admin_account()) {
    flash('Only admin accounts can use role switch.', 'danger');
    redirect_to('home.php');
}

$role = $_GET['role'] ?? 'admin';

if ($role === 'admin') {
    unset($_SESSION['audit_role']);
    flash('Returned to admin mode.');
    redirect_to('admin-dashboard.php');
}

if ($role === 'author') {
    $_SESSION['audit_role'] = 'author';
    flash('Audit mode: viewing as Author.', 'info');
    redirect_to('author-dashboard.php');
}

if ($role === 'user') {
    $_SESSION['audit_role'] = 'user';
    flash('Audit mode: viewing as User.', 'info');
    redirect_to('browse.php');
}

flash('Unknown role switch target.', 'danger');
redirect_to('admin-dashboard.php');

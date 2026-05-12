<?php
require_once __DIR__ . '/auth.php';
$pageTitle = $pageTitle ?? APP_NAME;
$active = $active ?? '';
$user = current_user();
$isAdminAccount = is_admin_account();
$effectiveRole = $user['role'] ?? null;
$actualRole = $user['actual_role'] ?? null;
$isAuditing = $isAdminAccount && $effectiveRole !== 'admin';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle) ?> - Spring Wisdom</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Noto+Sans+Myanmar:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= e(url_for('assets/css/style.css')) ?>" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg sw-navbar sticky-top">
    <div class="container-lg">
        <a class="navbar-brand fw-bold" href="<?= e(url_for('home.php')) ?>">Spring Wisdom</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php if ($user): ?>
                    <li class="nav-item"><a class="nav-link <?= $active === 'home' ? 'active' : '' ?>" href="<?= e(url_for('home.php')) ?>">Home</a></li>
                    <?php if ($effectiveRole !== 'admin'): ?>
                        <li class="nav-item"><a class="nav-link <?= $active === 'browse' ? 'active' : '' ?>" href="<?= e(url_for('browse.php')) ?>">Browse</a></li>
                    <?php endif; ?>
                    <?php if ($effectiveRole === 'admin'): ?>
                        <li class="nav-item"><a class="nav-link <?= str_starts_with($active, 'admin') ? 'active' : '' ?>" href="<?= e(url_for('admin-dashboard.php')) ?>">Dashboard</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a class="nav-link <?= $active === 'feed' ? 'active' : '' ?>" href="<?= e(url_for('admin-feed.php')) ?>">Updates</a></li>
                    <?php if ($effectiveRole !== 'admin'): ?>
                        <li class="nav-item"><a class="nav-link <?= $active === 'messages' ? 'active' : '' ?>" href="<?= e(url_for('messages.php')) ?>">Messages</a></li>
                    <?php endif; ?>
                    <?php if ($effectiveRole === 'user' && !$isAdminAccount): ?>
                        <li class="nav-item"><a class="nav-link <?= $active === 'author-request' ? 'active' : '' ?>" href="<?= e(url_for('author-request.php')) ?>">Author Request</a></li>
                    <?php endif; ?>
                    <?php if ($effectiveRole === 'author'): ?>
                        <li class="nav-item"><a class="nav-link <?= $active === 'my-space' ? 'active' : '' ?>" href="<?= e(url_for('author-dashboard.php')) ?>">My Space</a></li>
                        <li class="nav-item"><a class="nav-link <?= $active === 'author-analytics' ? 'active' : '' ?>" href="<?= e(url_for('author-analytics.php')) ?>">Analytics</a></li>
                    <?php endif; ?>
                    <?php if ($isAdminAccount && $effectiveRole !== 'admin'): ?>
                        <li class="nav-item">
                            <form method="post" action="<?= e(url_for('role-switch.php')) ?>">
                                <?= csrf_field() ?>
                                <input type="hidden" name="role" value="admin">
                                <button class="nav-link border-0 bg-transparent" type="submit">Admin</button>
                            </form>
                        </li>
                    <?php endif; ?>
                    <?php if ($isAdminAccount): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle <?= $active === 'role-switch' ? 'active' : '' ?>" href="#" role="button" data-bs-toggle="dropdown">Role Switch</a>
                            <ul class="dropdown-menu">
                                <?php foreach (['admin' => 'Sign in as Admin', 'author' => 'Sign in as Author', 'user' => 'Sign in as User'] as $roleValue => $roleLabel): ?>
                                    <li>
                                        <form method="post" action="<?= e(url_for('role-switch.php')) ?>">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="role" value="<?= e($roleValue) ?>">
                                            <button class="dropdown-item" type="submit"><?= e($roleLabel) ?></button>
                                        </form>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link <?= $active === 'home' ? 'active' : '' ?>" href="<?= e(url_for('home.php')) ?>">Home</a></li>
                <?php endif; ?>
            </ul>
            <div class="d-flex align-items-center gap-3">
                <?php if ($user): ?>
                    <?php if ($isAuditing): ?>
                        <span class="badge rounded-pill text-bg-warning border">Auditing: <?= e(ucfirst($effectiveRole)) ?></span>
                    <?php else: ?>
                        <span class="badge rounded-pill text-bg-light border text-secondary"><?= e(ucfirst($effectiveRole)) ?></span>
                    <?php endif; ?>
                    <div class="dropdown">
                        <button class="btn btn-icon" data-bs-toggle="dropdown" aria-label="Account menu">
                            <img class="sw-avatar" src="<?= e(avatar_url($user)) ?>" alt="<?= e($user['name']) ?> profile picture">
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li class="dropdown-header">
                                <strong><?= e($user['name']) ?></strong>
                                <div class="small"><?= e($user['email']) ?></div>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?= e(url_for('account.php')) ?>"><i class="bi bi-person me-2"></i>Account Information</a></li>
                            <li><a class="dropdown-item" href="<?= e(url_for('change-password.php')) ?>"><i class="bi bi-lock me-2"></i>Change Password</a></li>
                            <?php if ($user['role'] !== 'admin'): ?>
                                <li><a class="dropdown-item" href="<?= e(url_for('messages.php')) ?>"><i class="bi bi-envelope me-2"></i>Messages</a></li>
                            <?php endif; ?>
                            <?php if ($user['role'] === 'user'): ?>
                                <li><a class="dropdown-item" href="<?= e(url_for('author-request.php')) ?>"><i class="bi bi-pencil-square me-2"></i>Author Request</a></li>
                            <?php endif; ?>
                            <li><a class="dropdown-item" href="<?= e(url_for('settings.php')) ?>"><i class="bi bi-gear me-2"></i>Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="<?= e(url_for('logout.php')) ?>"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a class="btn btn-sw-primary btn-sm" href="<?= e(url_for('index.php')) ?>">Access Portal</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
<main>
    <?php foreach (consume_flash() as $item): ?>
        <div class="container-lg mt-3">
            <div class="alert alert-<?= e($item['type']) ?> alert-dismissible fade show" role="alert">
                <?= e($item['message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endforeach; ?>

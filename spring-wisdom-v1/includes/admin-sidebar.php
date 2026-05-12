<?php
require_once __DIR__ . '/config.php';
$adminItems = [
    ['key' => 'admin', 'label' => 'Overview', 'icon' => 'speedometer2', 'href' => 'admin-dashboard.php'],
    ['key' => 'admin-users', 'label' => 'User Accounts', 'icon' => 'people', 'href' => 'admin-users.php'],
    ['key' => 'admin-authors', 'label' => 'Author Accounts', 'icon' => 'person-badge', 'href' => 'admin-authors.php'],
    ['key' => 'admin-resources', 'label' => 'Resource Management', 'icon' => 'collection', 'href' => 'admin-resource-management.php'],
    ['key' => 'admin-reports', 'label' => 'Reports', 'icon' => 'flag', 'href' => 'admin-reports.php'],
    ['key' => 'admin-messages', 'label' => 'Messages', 'icon' => 'envelope', 'href' => 'admin-messages.php'],
    ['key' => 'admin-requests', 'label' => 'Author Requests', 'icon' => 'person-plus', 'href' => 'admin-author-requests.php'],
    ['key' => 'admin-feed-create', 'label' => 'Create Admin Feed', 'icon' => 'rss', 'href' => 'admin-create-feed.php'],
];
?>
<div class="admin-shell container-lg">
    <button class="btn btn-outline-sw mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#adminSidebar" aria-expanded="true" aria-controls="adminSidebar">
        <i class="bi bi-layout-sidebar me-2"></i>Admin Menu
    </button>
    <div class="row g-4 align-items-start">
        <aside class="col-lg-3 collapse show" id="adminSidebar">
            <div class="admin-sidebar-card">
                <div class="mb-3 px-2">
                    <strong class="d-block">Admin Portal</strong>
                    <span class="small sw-muted">Spring Wisdom Management</span>
                </div>
                <nav class="nav flex-column gap-1">
                    <?php foreach ($adminItems as $item): ?>
                        <a class="nav-link <?= $active === $item['key'] ? 'active' : '' ?>" href="<?= e(url_for($item['href'])) ?>">
                            <i class="bi bi-<?= e($item['icon']) ?> me-2"></i><?= e($item['label']) ?>
                        </a>
                    <?php endforeach; ?>
                </nav>
            </div>
        </aside>
        <div class="col-lg-9 admin-content">

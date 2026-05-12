<?php
require_once __DIR__ . '/includes/auth.php';
require_role(['admin']);
if (is_post()) {
    require_csrf();
    $role = $_POST['role'] ?? '';
    if (in_array($role, ['user', 'author'], true)) {
        set_user_role((int) $_POST['user_id'], $role);
        flash('User role updated.');
    } else {
        flash('Invalid role update.', 'danger');
    }
    redirect_to('admin-users.php');
}
$currentPage = max(1, (int) ($_GET['page'] ?? 1));
$perPage = 20;
$totalUsers = count_users();
$totalPages = max(1, (int) ceil($totalUsers / $perPage));
$currentPage = min($currentPage, $totalPages);
$users = all_users(null, $perPage, ($currentPage - 1) * $perPage);
$pageTitle = 'User Accounts';
$active = 'admin-users';
require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/admin-sidebar.php';
?>
<section class="container-lg py-5">
    <h1 class="display-6 fw-bold mb-4">User Accounts</h1>
    <p class="small sw-muted"><?= e((string) $totalUsers) ?> total account<?= $totalUsers === 1 ? '' : 's' ?></p>
    <div class="sw-panel table-responsive">
        <table class="table align-middle">
            <thead><tr><th>Name</th><th>Email</th><th>Role</th><th class="text-end">Action</th></tr></thead>
            <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= e($user['name']) ?></td><td><?= e($user['email']) ?></td><td><span class="badge sw-badge"><?= e($user['role']) ?></span></td>
                    <td class="text-end">
                        <?php if ($user['role'] !== 'admin'): ?>
                            <form method="post" class="d-inline">
                                <?= csrf_field() ?>
                                <input type="hidden" name="user_id" value="<?= e((string)$user['id']) ?>">
                                <input type="hidden" name="role" value="<?= $user['role'] === 'author' ? 'user' : 'author' ?>">
                                <button class="btn btn-sm btn-outline-sw"><?= $user['role'] === 'author' ? 'Demote to User' : 'Promote to Author' ?></button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php if ($totalPages > 1): ?>
        <nav class="mt-4" aria-label="User pagination">
            <ul class="pagination justify-content-center">
                <li class="page-item <?= $currentPage === 1 ? 'disabled' : '' ?>"><a class="page-link" href="<?= e(url_for('admin-users.php?page=' . max(1, $currentPage - 1))) ?>">Previous</a></li>
                <?php for ($page = 1; $page <= $totalPages; $page++): ?>
                    <li class="page-item <?= $page === $currentPage ? 'active' : '' ?>"><a class="page-link" href="<?= e(url_for('admin-users.php?page=' . $page)) ?>"><?= e((string) $page) ?></a></li>
                <?php endfor; ?>
                <li class="page-item <?= $currentPage === $totalPages ? 'disabled' : '' ?>"><a class="page-link" href="<?= e(url_for('admin-users.php?page=' . min($totalPages, $currentPage + 1))) ?>">Next</a></li>
            </ul>
        </nav>
    <?php endif; ?>
</section>
<?php require __DIR__ . '/includes/admin-sidebar-end.php'; ?>
<?php require __DIR__ . '/includes/footer.php'; ?>

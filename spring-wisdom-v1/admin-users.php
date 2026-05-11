<?php
require_once __DIR__ . '/includes/auth.php';
require_role(['admin']);
if (is_post()) {
    set_user_role((int) $_POST['user_id'], $_POST['role']);
    flash('User role updated.');
    redirect_to('admin-users.php');
}
$users = all_users();
$pageTitle = 'User Accounts';
$active = 'admin-users';
require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/admin-sidebar.php';
?>
<section class="container-lg py-5">
    <h1 class="display-6 fw-bold mb-4">User Accounts</h1>
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
</section>
<?php require __DIR__ . '/includes/admin-sidebar-end.php'; ?>
<?php require __DIR__ . '/includes/footer.php'; ?>

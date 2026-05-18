<?php
require_once __DIR__ . '/includes/auth.php';
require_role(['admin']);
if (is_post()) {
    require_csrf();
    $action = $_POST['action'] ?? 'role';
    $userId = (int) ($_POST['user_id'] ?? 0);
    if ($action === 'message') {
        $recipient = find_user_by_id($userId);
        $subject = trim($_POST['subject'] ?? '');
        $body = trim($_POST['body'] ?? '');
        if (!$recipient || ($recipient['role'] ?? '') === 'admin') {
            flash('Choose a user or author account to message.', 'danger');
        } elseif ($subject === '' || $body === '') {
            flash('Message subject and body are required.', 'danger');
        } else {
            create_message((int) current_user()['id'], $userId, $subject, $body);
            flash('Message sent to ' . ($recipient['name'] ?? 'user') . '.');
        }
        redirect_to('admin-users.php?user_id=' . $userId . '#user-' . $userId);
    } else {
        $role = $_POST['role'] ?? '';
        if (in_array($role, ['user', 'author'], true)) {
            set_user_role($userId, $role);
            flash('User role updated.');
        } else {
            flash('Invalid role update.', 'danger');
        }
        redirect_to('admin-users.php?user_id=' . $userId . '#user-' . $userId);
    }
}
$currentPage = max(1, (int) ($_GET['page'] ?? 1));
$perPage = 20;
$totalUsers = count_users();
$totalPages = max(1, (int) ceil($totalUsers / $perPage));
$targetUserId = max(0, (int) ($_GET['user_id'] ?? 0));
if ($targetUserId > 0) {
    $allUsersForTarget = all_users();
    foreach ($allUsersForTarget as $index => $candidate) {
        if ((int) $candidate['id'] === $targetUserId) {
            $currentPage = (int) floor($index / $perPage) + 1;
            break;
        }
    }
}
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
        <table class="table align-middle sw-admin-users-table">
            <thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Action</th><th>Message</th></tr></thead>
            <tbody>
            <?php foreach ($users as $user): ?>
                <?php $isTarget = $targetUserId > 0 && (int) $user['id'] === $targetUserId; ?>
                <tr id="user-<?= e((string) $user['id']) ?>" class="<?= $isTarget ? 'sw-highlight-row' : '' ?>">
                    <td><?= e($user['name']) ?></td><td><?= e($user['email']) ?></td><td><span class="badge sw-badge sw-role-badge"><?= e($user['role']) ?></span></td>
                    <td>
                        <?php if ($user['role'] !== 'admin'): ?>
                            <form method="post" class="d-inline">
                                <?= csrf_field() ?>
                                <input type="hidden" name="action" value="role">
                                <input type="hidden" name="user_id" value="<?= e((string)$user['id']) ?>">
                                <input type="hidden" name="role" value="<?= $user['role'] === 'author' ? 'user' : 'author' ?>">
                                <button class="btn btn-sm btn-outline-sw sw-table-action-btn"><?= $user['role'] === 'author' ? 'Demote to User' : 'Promote to Author' ?></button>
                            </form>
                        <?php else: ?>
                            <span class="sw-table-placeholder">Protected</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($user['role'] !== 'admin'): ?>
                            <button class="btn btn-sm btn-outline-sw sw-message-icon-btn" data-bs-toggle="modal" data-bs-target="#messageUser<?= e((string) $user['id']) ?>" type="button" aria-label="Message <?= e($user['name']) ?>">
                                <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                    <path d="M4.75 6.75A2.75 2.75 0 0 1 7.5 4h9A2.75 2.75 0 0 1 19.25 6.75v7.5A2.75 2.75 0 0 1 16.5 17H9.1l-3.18 2.36a.72.72 0 0 1-1.17-.58V6.75Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                                    <path d="M7.6 8.4h8.8M7.6 11.15h6.3" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                </svg>
                            </button>
                        <?php else: ?>
                            <span class="sw-table-placeholder">Admin</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php foreach ($users as $user): ?>
        <?php if ($user['role'] !== 'admin'): ?>
            <div class="modal fade" id="messageUser<?= e((string) $user['id']) ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="post" class="modal-content needs-validation" novalidate>
                        <?= csrf_field() ?>
                        <input type="hidden" name="action" value="message">
                        <input type="hidden" name="user_id" value="<?= e((string) $user['id']) ?>">
                        <div class="modal-header">
                            <h5 class="modal-title">Message <?= e($user['name']) ?> (<?= e($user['role']) ?>)</h5>
                            <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
                        </div>
                        <div class="modal-body">
                            <label class="form-label">Subject</label>
                            <input class="form-control mb-3" name="subject" maxlength="160" required placeholder="Short message subject">
                            <label class="form-label">Message</label>
                            <textarea class="form-control" name="body" rows="5" required placeholder="Write a direct admin message."></textarea>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-outline-sw" type="button" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-sw-primary">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
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

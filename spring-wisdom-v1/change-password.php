<?php
require_once __DIR__ . '/includes/auth.php';
require_login();
$user = current_user();

if (is_post()) {
    require_csrf();
    $current = $_POST['current_password'] ?? '';
    $new = $_POST['new_password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';
    $validComplexity = strlen($new) >= 8 && preg_match('/[A-Z]/', $new) && preg_match('/[a-z]/', $new) && preg_match('/[0-9]/', $new);

    if (!password_verify($current, $user['password_hash'] ?? '')) {
        flash('Current password is incorrect.', 'danger');
    } elseif ($new !== $confirm) {
        flash('New password and confirmation do not match.', 'danger');
    } elseif (!$validComplexity) {
        flash('New password must be at least 8 characters and include uppercase, lowercase, and a number.', 'danger');
    } else {
        change_user_password((int) $user['id'], $new);
        flash('Password changed successfully.');
        redirect_to('change-password.php');
    }
}

$pageTitle = 'Change Password';
$active = 'account';
require __DIR__ . '/includes/header.php';
?>
<section class="container-lg py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="sw-panel">
                <h1 class="h3 fw-bold mb-3">Change Password</h1>
                <p class="sw-muted">Use a strong password and confirm it before saving.</p>
                <form method="post" class="needs-validation" novalidate>
                    <?= csrf_field() ?>
                    <div class="mb-3"><label class="form-label">Current Password</label><input class="form-control" type="password" name="current_password" required></div>
                    <div class="mb-3"><label class="form-label">New Password</label><input class="form-control" type="password" name="new_password" minlength="8" required><div class="form-text">Minimum 8 characters with uppercase, lowercase, and a number.</div></div>
                    <div class="mb-4"><label class="form-label">Confirm New Password</label><input class="form-control" type="password" name="confirm_password" minlength="8" required></div>
                    <button class="btn btn-sw-primary">Update Password</button>
                </form>
            </div>
        </div>
    </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>

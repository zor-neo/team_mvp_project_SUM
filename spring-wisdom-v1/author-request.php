<?php
require_once __DIR__ . '/includes/auth.php';
require_login();
$user = current_user();

if (is_post()) {
    require_csrf();
    $reason = trim($_POST['reason_text'] ?? '');
    if ($user['role'] !== 'user') {
        flash('Your account already has elevated access.', 'warning');
    } elseif ($reason === '') {
        flash('Please explain why you want author access.', 'danger');
    } else {
        submit_author_request((int) $user['id'], $reason);
        flash('Your author request is now visible to admin for assessment.');
        redirect_to('author-request.php');
    }
}

$myRequests = array_values(array_filter(all_author_requests(), fn($request) => (int) $request['user_id'] === (int) $user['id']));
$pageTitle = 'Author Request';
$active = 'author-request';
require __DIR__ . '/includes/header.php';
?>
<section class="container-lg py-5">
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="sw-panel">
                <h1 class="h3 fw-bold mb-3">Request Author Status</h1>
                <p class="sw-muted">Author status permits upload, modification, and deletion of your learning contents after admin approval.</p>
                <?php if ($user['role'] === 'user'): ?>
                    <form method="post" class="needs-validation" novalidate>
                        <?= csrf_field() ?>
                        <label class="form-label">Reason for author access</label>
                        <textarea class="form-control" name="reason_text" rows="6" required placeholder="Describe what type of learning resources you want to contribute."></textarea>
                        <button class="btn btn-sw-primary mt-3">Submit Request</button>
                    </form>
                <?php else: ?>
                    <div class="alert alert-info mb-0">Your current role is <?= e($user['role']) ?>, so author request is not required.</div>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="sw-panel">
                <h2 class="h5 fw-bold mb-3">My Request History</h2>
                <?php if (!$myRequests): ?>
                    <p class="sw-muted mb-0">No author requests yet.</p>
                <?php endif; ?>
                <?php foreach ($myRequests as $request): ?>
                    <div class="border-bottom pb-3 mb-3">
                        <span class="badge <?= $request['status'] === 'pending' ? 'text-bg-warning' : 'text-bg-light border' ?>"><?= e($request['status']) ?></span>
                        <p class="small sw-muted mt-2 mb-0"><?= e($request['reason_text']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>

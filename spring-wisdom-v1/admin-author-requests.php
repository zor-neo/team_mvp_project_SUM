<?php
require_once __DIR__ . '/includes/auth.php';
require_role(['admin']);
if (is_post()) {
    review_author_request((int) $_POST['request_id'], $_POST['status'], (int) current_user()['id']);
    flash('Author request reviewed.');
    redirect_to('admin-author-requests.php');
}
$requests = all_author_requests();
$pageTitle = 'Author Requests';
$active = 'admin-requests';
require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/admin-sidebar.php';
?>
<section class="container-lg py-5">
    <h1 class="display-6 fw-bold mb-4">Author Request Assessment</h1>
    <div class="row g-4">
        <?php foreach ($requests as $request): ?>
            <div class="col-md-6">
                <div class="sw-panel h-100">
                    <span class="badge <?= $request['status'] === 'pending' ? 'text-bg-warning' : 'text-bg-light border' ?> mb-3"><?= e($request['status']) ?></span>
                    <h2 class="h5"><?= e($request['user_name']) ?></h2>
                    <p class="sw-muted"><?= e($request['reason_text']) ?></p>
                    <?php if ($request['status'] === 'pending'): ?>
                        <form method="post" class="d-flex gap-2">
                            <input type="hidden" name="request_id" value="<?= e((string)$request['id']) ?>">
                            <button class="btn btn-sw-primary btn-sm" name="status" value="approved">Approve / Promote</button>
                            <button class="btn btn-outline-danger btn-sm" name="status" value="rejected">Reject</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php require __DIR__ . '/includes/admin-sidebar-end.php'; ?>
<?php require __DIR__ . '/includes/footer.php'; ?>

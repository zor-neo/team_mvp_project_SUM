<?php
require_once __DIR__ . '/includes/auth.php';
require_role(['admin']);
if (is_post()) {
    require_csrf();
    $status = $_POST['status'] ?? '';
    if (in_array($status, ['approved', 'rejected'], true)) {
        review_author_request((int) $_POST['request_id'], $status, (int) current_user()['id']);
        flash('Author request reviewed.');
    } else {
        flash('Invalid request action.', 'danger');
    }
    redirect_to('admin-author-requests.php');
}
$currentPage = max(1, (int) ($_GET['page'] ?? 1));
$perPage = 10;
$totalRequests = count_author_requests();
$totalPages = max(1, (int) ceil($totalRequests / $perPage));
$currentPage = min($currentPage, $totalPages);
$requests = all_author_requests(null, $perPage, ($currentPage - 1) * $perPage);
$pageTitle = 'Author Requests';
$active = 'admin-requests';
require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/admin-sidebar.php';
?>
<section class="container-lg py-5">
    <h1 class="display-6 fw-bold mb-4">Author Request Assessment</h1>
    <p class="small sw-muted"><?= e((string) $totalRequests) ?> total request<?= $totalRequests === 1 ? '' : 's' ?></p>
    <div class="row g-4">
        <?php foreach ($requests as $request): ?>
            <div class="col-md-6">
                <div class="sw-panel h-100">
                    <span class="badge <?= $request['status'] === 'pending' ? 'text-bg-warning' : 'text-bg-light border' ?> mb-3"><?= e($request['status']) ?></span>
                    <h2 class="h5"><?= e($request['user_name']) ?></h2>
                    <p class="sw-muted"><?= e($request['reason_text']) ?></p>
                    <?php if ($request['status'] === 'pending'): ?>
                        <form method="post" class="d-flex gap-2">
                            <?= csrf_field() ?>
                            <input type="hidden" name="request_id" value="<?= e((string)$request['id']) ?>">
                            <button class="btn btn-sw-primary btn-sm" name="status" value="approved">Approve / Promote</button>
                            <button class="btn btn-outline-danger btn-sm" name="status" value="rejected">Reject</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php if ($totalPages > 1): ?>
        <nav class="mt-5" aria-label="Author request pagination">
            <ul class="pagination justify-content-center">
                <li class="page-item <?= $currentPage === 1 ? 'disabled' : '' ?>"><a class="page-link" href="<?= e(url_for('admin-author-requests.php?page=' . max(1, $currentPage - 1))) ?>">Previous</a></li>
                <?php for ($page = 1; $page <= $totalPages; $page++): ?>
                    <li class="page-item <?= $page === $currentPage ? 'active' : '' ?>"><a class="page-link" href="<?= e(url_for('admin-author-requests.php?page=' . $page)) ?>"><?= e((string) $page) ?></a></li>
                <?php endfor; ?>
                <li class="page-item <?= $currentPage === $totalPages ? 'disabled' : '' ?>"><a class="page-link" href="<?= e(url_for('admin-author-requests.php?page=' . min($totalPages, $currentPage + 1))) ?>">Next</a></li>
            </ul>
        </nav>
    <?php endif; ?>
</section>
<?php require __DIR__ . '/includes/admin-sidebar-end.php'; ?>
<?php require __DIR__ . '/includes/footer.php'; ?>

<?php
require_once __DIR__ . '/includes/auth.php';
require_role(['admin']);
if (is_post()) {
    $action = $_POST['action'] ?? '';
    if ($action === 'hide') {
        set_content_status((int) $_POST['content_id'], 'hidden');
        set_report_status((int) $_POST['report_id'], 'actioned');
        flash('Content hidden and report marked actioned.', 'warning');
    }
    if ($action === 'dismiss') {
        set_report_status((int) $_POST['report_id'], 'dismissed');
        flash('Report dismissed.');
    }
    redirect_to('admin-reports.php');
}
$reports = all_reports();
$pageTitle = 'Reports';
$active = 'admin-reports';
require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/admin-sidebar.php';
?>
<section class="container-lg py-5">
    <h1 class="display-6 fw-bold mb-4">Reports & Flags</h1>
    <div class="row g-4">
        <?php foreach ($reports as $report): ?>
            <div class="col-lg-6">
                <div class="sw-panel h-100">
                    <span class="badge text-bg-warning mb-3"><?= e($report['status']) ?></span>
                    <h2 class="h5"><?= e($report['content_title']) ?></h2>
                    <p class="small sw-muted">Reported by <?= e($report['reporter_name']) ?> - <?= e($report['created_at']) ?></p>
                    <p><strong>Category:</strong> <?= e($report['reason_category']) ?></p>
                    <p class="sw-muted"><?= e($report['reason_text']) ?></p>
                    <div class="d-flex flex-wrap gap-2">
                        <a class="btn btn-sm btn-outline-sw" href="<?= e(url_for('content.php?id=' . $report['content_id'] . '&review=report')) ?>">View Content</a>
                        <button class="btn btn-sm btn-outline-sw">Message Author</button>
                        <form method="post" class="d-inline">
                            <input type="hidden" name="action" value="dismiss">
                            <input type="hidden" name="report_id" value="<?= e((string)$report['id']) ?>">
                            <button class="btn btn-sm btn-outline-sw">Dismiss</button>
                        </form>
                        <form method="post" class="d-inline">
                            <input type="hidden" name="action" value="hide">
                            <input type="hidden" name="report_id" value="<?= e((string)$report['id']) ?>">
                            <input type="hidden" name="content_id" value="<?= e((string)$report['content_id']) ?>">
                            <button class="btn btn-sm btn-danger">Hide Article</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php require __DIR__ . '/includes/admin-sidebar-end.php'; ?>
<?php require __DIR__ . '/includes/footer.php'; ?>

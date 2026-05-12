<?php
require_once __DIR__ . '/includes/auth.php';
require_login();

$content = content_by_id((int) ($_GET['id'] ?? 0));
if (!$content || $content['status'] !== 'published') {
    flash('Content was not found.', 'warning');
    redirect_to('browse.php');
}

$isReportReview = is_admin_account() && ($_GET['review'] ?? '') === 'report';
$from = $_GET['from'] ?? 'browse';
$returnPath = $_GET['return'] ?? '';
$backPath = 'browse.php';
$backLabel = 'Back to Browse';
if ($from === 'archives') {
    $backPath = str_starts_with($returnPath, 'archives.php') ? $returnPath : 'archives.php';
    $backLabel = 'Back to Archives';
} elseif ($from === 'browse') {
    $backPath = str_starts_with($returnPath, 'browse.php') ? $returnPath : 'browse.php';
}

if (is_post() && ($_POST['action'] ?? '') === 'report') {
    require_csrf();
    if ($isReportReview || effective_role() === 'admin') {
        flash('Admin review mode cannot submit reports.', 'warning');
        redirect_to('content.php?id=' . $content['id'] . '&review=report');
    }
    $category = trim($_POST['reason_category'] ?? '');
    $text = trim($_POST['reason_text'] ?? '');
    if ($category !== '' && $text !== '') {
        submit_report((int) $content['id'], (int) current_user()['id'], $category, $text);
        flash('Report submitted. Admin will review your reason.');
        redirect_to('content.php?id=' . $content['id']);
    }
    flash('Please choose a report category and type a reason.', 'danger');
}

$pageTitle = $content['title'];
$active = $isReportReview ? 'admin-reports' : 'browse';
$hasAttachment = !empty($content['file_path']);
require __DIR__ . '/includes/header.php';
?>
<section class="container-lg py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="sw-panel">
                <span class="badge sw-badge"><?= e($content['category']) ?></span>
                <h1 class="display-6 fw-bold mt-3"><?= e($content['title']) ?></h1>
                <p class="sw-muted">By <?= e($content['author_name']) ?> - Uploaded <?= e(friendly_time((string) $content['created_at'])) ?></p>
                <hr>
                <p class="lead"><?= e($content['summary']) ?></p>
                <?php if ($hasAttachment): ?>
                    <div class="border rounded-3 p-3 mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                        <div>
                            <p class="fw-semibold mb-1"><i class="bi bi-paperclip me-2"></i>Attached learning file</p>
                            <p class="small sw-muted mb-0"><?= e(basename((string) $content['file_path'])) ?> - available for readers of this published content</p>
                        </div>
                        <a class="btn btn-outline-sw btn-sm" href="<?= e(url_for('file-view.php?id=' . (int) $content['id'])) ?>" target="_blank" rel="noopener">
                            Open file <i class="bi bi-box-arrow-up-right ms-1"></i>
                        </a>
                    </div>
                <?php endif; ?>
                <div class="article-body mt-4"><?= render_article_body($content['body']) ?></div>
                <div class="d-flex flex-wrap gap-2 mt-5">
                    <?php if ($isReportReview): ?>
                        <a class="btn btn-outline-sw" href="<?= e(url_for('admin-reports.php')) ?>"><i class="bi bi-arrow-left"></i> Back to Reports</a>
                    <?php else: ?>
                        <a class="btn btn-outline-sw" href="<?= e(url_for($backPath)) ?>"><i class="bi bi-arrow-left"></i> <?= e($backLabel) ?></a>
                        <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#reportModal"><i class="bi bi-flag"></i> Report Content</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php if (!$isReportReview): ?>
<div class="modal fade" id="reportModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" class="modal-content needs-validation" novalidate>
            <?= csrf_field() ?>
            <input type="hidden" name="action" value="report">
            <div class="modal-header"><h5 class="modal-title">Report Content</h5><button class="btn-close" data-bs-dismiss="modal" type="button"></button></div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Reason category</label>
                    <select class="form-select" name="reason_category" required>
                        <option value="">Choose one...</option>
                        <option>Misleading information</option>
                        <option>Plagiarism</option>
                        <option>Inappropriate content</option>
                        <option>Broken or incomplete content</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Explain the issue</label>
                    <textarea class="form-control" name="reason_text" rows="4" required></textarea>
                    <div class="form-text">A written reason is required before admin can review the flag.</div>
                </div>
            </div>
            <div class="modal-footer"><button class="btn btn-danger">Submit Report</button></div>
        </form>
    </div>
</div>
<?php endif; ?>
<?php require __DIR__ . '/includes/footer.php'; ?>

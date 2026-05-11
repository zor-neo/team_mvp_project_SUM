<?php
require_once __DIR__ . '/includes/auth.php';
require_role(['admin']);
if (is_post()) {
    require_csrf();
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
    if ($action === 'message_author') {
        $reportId = (int) ($_POST['report_id'] ?? 0);
        $contentId = (int) ($_POST['content_id'] ?? 0);
        $authorId = (int) ($_POST['author_id'] ?? 0);
        $subject = trim($_POST['subject'] ?? '');
        $body = trim($_POST['body'] ?? '');
        if ($authorId > 0 && $subject !== '' && $body !== '') {
            create_message((int) current_user()['id'], $authorId, $subject, $body, $reportId, $contentId);
            flash('Message sent to author.');
        } else {
            flash('Message subject and body are required.', 'danger');
        }
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
                        <button class="btn btn-sm btn-outline-sw" data-bs-toggle="modal" data-bs-target="#messageAuthor<?= e((string) $report['id']) ?>">Message Author</button>
                        <form method="post" class="d-inline">
                            <?= csrf_field() ?>
                            <input type="hidden" name="action" value="dismiss">
                            <input type="hidden" name="report_id" value="<?= e((string)$report['id']) ?>">
                            <button class="btn btn-sm btn-outline-sw">Dismiss</button>
                        </form>
                        <form method="post" class="d-inline">
                            <?= csrf_field() ?>
                            <input type="hidden" name="action" value="hide">
                            <input type="hidden" name="report_id" value="<?= e((string)$report['id']) ?>">
                            <input type="hidden" name="content_id" value="<?= e((string)$report['content_id']) ?>">
                            <button class="btn btn-sm btn-danger">Hide Article</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="messageAuthor<?= e((string) $report['id']) ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="post" class="modal-content">
                        <?= csrf_field() ?>
                        <input type="hidden" name="action" value="message_author">
                        <input type="hidden" name="report_id" value="<?= e((string) $report['id']) ?>">
                        <input type="hidden" name="content_id" value="<?= e((string) $report['content_id']) ?>">
                        <input type="hidden" name="author_id" value="<?= e((string) ($report['author_id'] ?? 0)) ?>">
                        <div class="modal-header">
                            <h5 class="modal-title">Message <?= e($report['author_name'] ?? 'Author') ?></h5>
                            <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
                        </div>
                        <div class="modal-body">
                            <label class="form-label">Subject</label>
                            <input class="form-control mb-3" name="subject" value="Report review: <?= e($report['content_title']) ?>" maxlength="160" required>
                            <label class="form-label">Message</label>
                            <textarea class="form-control" name="body" rows="5" required>Please review the report for "<?= e($report['content_title']) ?>". Admin noted: <?= e($report['reason_category']) ?>.</textarea>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-outline-sw" type="button" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-sw-primary">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php require __DIR__ . '/includes/admin-sidebar-end.php'; ?>
<?php require __DIR__ . '/includes/footer.php'; ?>

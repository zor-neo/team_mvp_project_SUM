<?php
require_once __DIR__ . '/includes/auth.php';
require_role(['admin']);

if (is_post()) {
    require_csrf();
    $action = $_POST['action'] ?? '';
    $messageId = (int) ($_POST['message_id'] ?? 0);
    if ($action === 'mark_read') {
        update_message_status($messageId, 'read');
        flash('Message marked as read.');
    } elseif ($action === 'resolve') {
        update_message_status($messageId, 'resolved');
        flash('Message resolved.');
    } elseif ($action === 'reply') {
        $reply = trim($_POST['reply_text'] ?? '');
        if ($reply !== '') {
            reply_to_message($messageId, $reply);
            flash('Reply saved and message resolved.');
        } else {
            flash('Reply text is required.', 'danger');
        }
    }
    redirect_to('admin-messages.php');
}

$messages = all_messages();
$pageTitle = 'Messages';
$active = 'admin-messages';
require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/admin-sidebar.php';
?>
<section class="container-lg py-5">
    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 align-items-md-end mb-4">
        <div>
            <h1 class="display-6 fw-bold mb-1">Reports and Messages</h1>
            <p class="sw-muted mb-0">Review user/admin messages, save replies, and resolve moderation communication.</p>
        </div>
        <span class="badge sw-badge"><?= e((string) count($messages)) ?> total</span>
    </div>
    <div class="sw-panel">
        <?php if (!$messages): ?>
            <p class="sw-muted mb-0">No messages yet.</p>
        <?php endif; ?>
        <?php foreach ($messages as $message): ?>
            <div class="sw-message-card <?= $message['status'] === 'new' ? 'has-ribbon' : '' ?> mb-3">
                <?php if ($message['status'] === 'new'): ?>
                    <span class="sw-message-ribbon">New message</span>
                <?php endif; ?>
                <div class="d-flex flex-column gap-2">
                    <div class="pe-md-5">
                        <h2 class="h6 fw-bold mb-1"><?= e($message['subject']) ?></h2>
                        <p class="small sw-muted mb-1">From <?= e($message['sender_name']) ?> to <?= e($message['receiver_name'] ?? 'Admin') ?> - <?= e(friendly_time((string) $message['created_at'])) ?></p>
                        <?php if (!empty($message['content_title'])): ?>
                            <p class="small sw-muted mb-0"><?= e($message['content_title']) ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="text-end">
                        <button class="btn btn-sm btn-sw-primary sw-message-view" data-bs-toggle="modal" data-bs-target="#message<?= e((string) $message['id']) ?>">
                            View <i class="bi bi-arrow-right-short"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="message<?= e((string) $message['id']) ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><?= e($message['subject']) ?></h5>
                            <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
                        </div>
                        <div class="modal-body">
                            <p class="small sw-muted mb-2">Status: <?= e($message['status']) ?></p>
                            <div class="border rounded p-3 mb-3">
                                <strong>Original message</strong>
                                <p class="mb-0 mt-2"><?= nl2br(e($message['body'])) ?></p>
                            </div>
                            <?php if (!empty($message['reply_text'])): ?>
                                <div class="border rounded p-3 mb-3">
                                    <strong>Saved reply</strong>
                                    <p class="mb-0 mt-2"><?= nl2br(e($message['reply_text'])) ?></p>
                                </div>
                            <?php endif; ?>
                            <form id="replyForm<?= e((string) $message['id']) ?>" method="post">
                                <?= csrf_field() ?>
                                <input type="hidden" name="action" value="reply">
                                <input type="hidden" name="message_id" value="<?= e((string) $message['id']) ?>">
                                <label class="form-label">Reply / resolution note</label>
                                <textarea class="form-control" name="reply_text" rows="4" required></textarea>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <form method="post" class="me-auto d-flex gap-2">
                                <?= csrf_field() ?>
                                <input type="hidden" name="message_id" value="<?= e((string) $message['id']) ?>">
                                <button class="btn btn-outline-sw" name="action" value="mark_read">Mark Read</button>
                                <button class="btn btn-outline-sw" name="action" value="resolve">Resolve</button>
                            </form>
                            <button class="btn btn-sw-primary" form="replyForm<?= e((string) $message['id']) ?>">Save Reply</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php require __DIR__ . '/includes/admin-sidebar-end.php'; ?>
<?php require __DIR__ . '/includes/footer.php'; ?>

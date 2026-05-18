<?php
require_once __DIR__ . '/includes/auth.php';
require_role(['admin']);

function admin_message_participant_link(array $message, string $side): string
{
    $label = message_participant_label($message, $side);
    $id = (int) ($message[$side . '_id'] ?? 0);
    if ($id <= 0 || $label === 'Admin') {
        return e($label);
    }
    $href = url_for('admin-users.php?user_id=' . $id . '#user-' . $id);
    return '<a class="sw-underlined-link" href="' . e($href) . '">' . e($label) . '</a>';
}

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

$currentPage = max(1, (int) ($_GET['page'] ?? 1));
$perPage = 10;
$totalMessages = count_messages();
$totalPages = max(1, (int) ceil($totalMessages / $perPage));
$currentPage = min($currentPage, $totalPages);
$messages = all_messages($perPage, ($currentPage - 1) * $perPage);
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
        <span class="badge sw-badge"><?= e((string) $totalMessages) ?> total</span>
    </div>
    <div class="sw-panel">
        <?php if (!$messages): ?>
            <p class="sw-muted mb-0">No messages yet.</p>
        <?php endif; ?>
        <?php foreach ($messages as $message): ?>
            <?php
                $senderLabel = admin_message_participant_link($message, 'sender');
                $receiverLabel = admin_message_participant_link($message, 'receiver');
                $canAdminReply = empty($message['reply_text']) && message_participant_label($message, 'receiver') === 'Admin';
            ?>
            <div class="sw-message-card <?= $message['status'] === 'new' ? 'has-ribbon' : '' ?> mb-3">
                <div class="d-flex flex-column flex-md-row justify-content-between gap-2 align-items-md-center">
                    <div class="pe-md-3">
                        <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                            <?php if ($message['status'] === 'new'): ?>
                                <span class="sw-message-ribbon">New</span>
                            <?php endif; ?>
                            <h2 class="h6 fw-bold mb-0"><?= e($message['subject']) ?></h2>
                        </div>
                        <p class="small sw-muted mb-1"><?= $senderLabel ?> sent a message to <?= $receiverLabel ?> - <?= e(friendly_time((string) $message['created_at'])) ?></p>
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
                            <?php elseif ($canAdminReply): ?>
                                <form id="replyForm<?= e((string) $message['id']) ?>" method="post">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="action" value="reply">
                                    <input type="hidden" name="message_id" value="<?= e((string) $message['id']) ?>">
                                    <label class="form-label">Reply / resolution note</label>
                                    <textarea class="form-control" name="reply_text" rows="4" required></textarea>
                                </form>
                            <?php else: ?>
                                <p class="small sw-muted mb-0">Waiting for the recipient to reply.</p>
                            <?php endif; ?>
                        </div>
                        <div class="modal-footer">
                            <form method="post" class="me-auto d-flex gap-2">
                                <?= csrf_field() ?>
                                <input type="hidden" name="message_id" value="<?= e((string) $message['id']) ?>">
                                <button class="btn btn-outline-sw" name="action" value="mark_read">Mark Read</button>
                                <button class="btn btn-outline-sw" name="action" value="resolve">Resolve</button>
                            </form>
                            <?php if ($canAdminReply): ?>
                                <button class="btn btn-sw-primary" form="replyForm<?= e((string) $message['id']) ?>">Save Reply</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php if ($totalPages > 1): ?>
        <nav class="mt-4" aria-label="Message pagination">
            <ul class="pagination justify-content-center">
                <li class="page-item <?= $currentPage === 1 ? 'disabled' : '' ?>"><a class="page-link" href="<?= e(url_for('admin-messages.php?page=' . max(1, $currentPage - 1))) ?>">Previous</a></li>
                <?php for ($page = 1; $page <= $totalPages; $page++): ?>
                    <li class="page-item <?= $page === $currentPage ? 'active' : '' ?>"><a class="page-link" href="<?= e(url_for('admin-messages.php?page=' . $page)) ?>"><?= e((string) $page) ?></a></li>
                <?php endfor; ?>
                <li class="page-item <?= $currentPage === $totalPages ? 'disabled' : '' ?>"><a class="page-link" href="<?= e(url_for('admin-messages.php?page=' . min($totalPages, $currentPage + 1))) ?>">Next</a></li>
            </ul>
        </nav>
    <?php endif; ?>
</section>
<?php require __DIR__ . '/includes/admin-sidebar-end.php'; ?>
<?php require __DIR__ . '/includes/footer.php'; ?>

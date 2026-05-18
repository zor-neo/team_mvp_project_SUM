<?php
require_once __DIR__ . '/includes/auth.php';
require_login();

$user = actual_user();
if (!$user) {
    redirect_to('index.php');
}

if (is_post()) {
    require_csrf();
    $action = $_POST['action'] ?? 'send';
    if ($action === 'reply') {
        $messageId = (int) ($_POST['message_id'] ?? 0);
        $reply = trim($_POST['reply_text'] ?? '');
        if ($reply === '') {
            flash('Reply text is required.', 'danger');
        } elseif (reply_to_received_message($messageId, (int) $user['id'], $reply)) {
            flash('Reply saved on the original message.');
        } else {
            flash('That message could not be replied to.', 'danger');
        }
    } else {
        $subject = trim($_POST['subject'] ?? '');
        $body = trim($_POST['body'] ?? '');
        $admin = first_admin_user();
        if (!$admin) {
            flash('No admin account is available to receive messages.', 'danger');
        } elseif ($subject === '' || $body === '') {
            flash('Subject and message are required.', 'danger');
        } else {
            create_message((int) $user['id'], (int) $admin['id'], $subject, $body);
            flash('Message sent to admin.');
        }
    }
    redirect_to('messages.php');
}

$messages = messages_for_user((int) $user['id']);
$inbox = array_values(array_filter($messages, fn($message) => (int) ($message['receiver_id'] ?? 0) === (int) $user['id']));
$sent = array_values(array_filter($messages, fn($message) => (int) $message['sender_id'] === (int) $user['id']));
$userId = (int) $user['id'];

$pageTitle = 'Messages';
$active = 'messages';
require __DIR__ . '/includes/header.php';
?>
<section class="sw-section">
    <div class="container-lg">
        <div class="d-flex flex-column flex-lg-row justify-content-between gap-3 align-items-lg-end mb-4">
            <div>
                <span class="badge sw-badge mb-3">Message Channel</span>
                <h1 class="h2 fw-bold mb-2">Messages</h1>
                <p class="sw-muted mb-0">Contact admin and review moderation replies in one place.</p>
            </div>
            <span class="badge rounded-pill text-bg-light border text-secondary"><?= e((string) count($messages)) ?> total</span>
        </div>

        <?php if (is_admin_account() && effective_role() !== 'admin'): ?>
            <div class="alert alert-warning border">
                You are viewing this page in audit mode. Messages are still connected to the real admin account.
            </div>
        <?php endif; ?>

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="sw-panel h-100">
                    <h2 class="h4 fw-bold mb-3">Contact Admin</h2>
                    <form method="post" class="needs-validation" novalidate>
                        <?= csrf_field() ?>
                        <input type="hidden" name="action" value="send">
                        <div class="mb-3">
                            <label class="form-label">Subject</label>
                            <input class="form-control" name="subject" maxlength="160" required placeholder="Short message subject">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea class="form-control" name="body" rows="7" required placeholder="Write your question or request clearly."></textarea>
                        </div>
                        <button class="btn btn-sw-primary w-100">Send Message</button>
                    </form>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="sw-panel mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="h4 fw-bold mb-0">Inbox</h2>
                        <span class="small sw-muted"><?= e((string) count($inbox)) ?> received</span>
                    </div>
                    <?php if (!$inbox): ?>
                        <p class="sw-muted mb-0">No received messages yet.</p>
                    <?php endif; ?>
                    <?php foreach ($inbox as $message): ?>
                        <?php
                            $senderLabel = message_participant_label($message, 'sender', $userId);
                            $receiverLabel = message_participant_label($message, 'receiver', $userId);
                        ?>
                        <article class="sw-message-card <?= $message['status'] === 'new' ? 'has-ribbon' : '' ?> mb-3">
                            <div class="d-flex flex-column gap-1">
                                <div>
                                    <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                                        <?php if ($message['status'] === 'new'): ?>
                                            <span class="sw-message-ribbon">New</span>
                                        <?php endif; ?>
                                        <h3 class="h6 fw-bold mb-0"><?= e($message['subject']) ?></h3>
                                    </div>
                                    <p class="small sw-muted mb-2"><?= e($senderLabel) ?> sent a message to <?= e($receiverLabel) ?> - <?= e(friendly_time((string) $message['created_at'])) ?></p>
                                </div>
                            </div>
                            <p class="small mb-0"><?= nl2br(e($message['body'])) ?></p>
                            <?php if (!empty($message['reply_text'])): ?>
                                <div class="border rounded-3 p-2 mt-2 bg-white">
                                    <strong>Your reply</strong>
                                    <p class="small mb-0 mt-1"><?= nl2br(e($message['reply_text'])) ?></p>
                                </div>
                            <?php else: ?>
                                <form method="post" class="border rounded-3 p-2 mt-3 bg-white needs-validation" novalidate>
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="action" value="reply">
                                    <input type="hidden" name="message_id" value="<?= e((string) $message['id']) ?>">
                                    <label class="form-label small fw-semibold">Reply to this message</label>
                                    <textarea class="form-control form-control-sm" name="reply_text" rows="3" required placeholder="Write a short reply."></textarea>
                                    <div class="text-end mt-2">
                                        <button class="btn btn-sm btn-sw-primary">Send Reply</button>
                                    </div>
                                </form>
                            <?php endif; ?>
                        </article>
                    <?php endforeach; ?>
                </div>

                <div class="sw-panel">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="h4 fw-bold mb-0">Sent</h2>
                        <span class="small sw-muted"><?= e((string) count($sent)) ?> sent</span>
                    </div>
                    <?php if (!$sent): ?>
                        <p class="sw-muted mb-0">No sent messages yet.</p>
                    <?php endif; ?>
                    <?php foreach ($sent as $message): ?>
                        <?php
                            $senderLabel = message_participant_label($message, 'sender', $userId);
                            $receiverLabel = message_participant_label($message, 'receiver', $userId);
                        ?>
                        <article class="sw-message-card mb-3">
                            <div class="d-flex flex-column gap-1">
                                <div>
                                    <h3 class="h6 fw-bold mb-1"><?= e($message['subject']) ?></h3>
                                    <p class="small sw-muted mb-2"><?= e($senderLabel) ?> sent a message to <?= e($receiverLabel) ?> - <?= e(friendly_time((string) $message['created_at'])) ?></p>
                                </div>
                            </div>
                            <p class="small mb-2"><?= nl2br(e($message['body'])) ?></p>
                            <?php if (!empty($message['reply_text'])): ?>
                                <div class="border rounded-3 p-2 bg-white">
                                    <strong>Admin reply / resolution</strong>
                                    <p class="small mb-0 mt-1"><?= nl2br(e($message['reply_text'])) ?></p>
                                </div>
                            <?php endif; ?>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>

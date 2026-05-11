<?php
require_once __DIR__ . '/includes/auth.php';
require_role(['admin']);
$messages = all_messages();
$pageTitle = 'Messages';
$active = 'admin-messages';
require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/admin-sidebar.php';
?>
<section class="container-lg py-5">
    <h1 class="display-6 fw-bold mb-4">Reports and Messages</h1>
    <div class="sw-panel">
        <?php foreach ($messages as $message): ?>
            <div class="border-bottom py-3">
                <div class="d-flex justify-content-between gap-3">
                    <div>
                        <h2 class="h5 mb-1"><?= e($message['subject']) ?></h2>
                        <p class="small sw-muted mb-0">From <?= e($message['sender_name']) ?> · <?= e($message['created_at']) ?></p>
                    </div>
                    <button class="btn btn-sm btn-outline-sw" data-bs-toggle="modal" data-bs-target="#message<?= e((string)$message['id']) ?>">View</button>
                </div>
            </div>
            <div class="modal fade" id="message<?= e((string)$message['id']) ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title"><?= e($message['subject']) ?></h5><button class="btn-close" data-bs-dismiss="modal" type="button"></button></div><div class="modal-body"><p><?= e($message['body']) ?></p><textarea class="form-control" rows="3" placeholder="Type a short reply..."></textarea></div><div class="modal-footer"><button class="btn btn-sw-primary" data-bs-dismiss="modal">Mark Reply Drafted</button></div></div></div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php require __DIR__ . '/includes/admin-sidebar-end.php'; ?>
<?php require __DIR__ . '/includes/footer.php'; ?>

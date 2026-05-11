<?php
require_once __DIR__ . '/includes/auth.php';
require_role(['admin']);
if (is_post()) {
    require_csrf();
    create_feed((int) current_user()['id'], [
        'title' => trim($_POST['title'] ?? ''),
        'summary' => trim($_POST['summary'] ?? ''),
        'body' => trim($_POST['body'] ?? ''),
    ]);
    flash('Admin feed post created.');
    redirect_to('admin-feed.php');
}
$pageTitle = 'Create Admin Feed';
$active = 'admin-feed-create';
require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/admin-sidebar.php';
?>
<section class="container-lg py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="sw-panel">
                <h1 class="display-6 fw-bold mb-4">Create Admin Feed</h1>
                <form method="post" class="needs-validation" novalidate>
                    <?= csrf_field() ?>
                    <div class="mb-3"><label class="form-label">Title</label><input class="form-control" name="title" required></div>
                    <div class="mb-3"><label class="form-label">Summary</label><input class="form-control" name="summary" required></div>
                    <div class="mb-3"><label class="form-label">Body</label><textarea class="form-control" name="body" rows="7" required></textarea></div>
                    <button class="btn btn-sw-primary">Publish Feed</button>
                </form>
            </div>
        </div>
    </div>
</section>
<?php require __DIR__ . '/includes/admin-sidebar-end.php'; ?>
<?php require __DIR__ . '/includes/footer.php'; ?>

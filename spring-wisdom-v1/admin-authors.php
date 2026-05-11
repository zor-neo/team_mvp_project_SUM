<?php
require_once __DIR__ . '/includes/auth.php';
require_role(['admin']);
if (is_post()) {
    require_csrf();
    set_user_role((int) $_POST['user_id'], 'user');
    flash('Author demoted to normal user.', 'warning');
    redirect_to('admin-authors.php');
}
$authors = all_users('author');
$contents = all_contents(true);
$pageTitle = 'Author Accounts';
$active = 'admin-authors';
require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/admin-sidebar.php';
?>
<section class="container-lg py-5">
    <h1 class="display-6 fw-bold mb-4">Author Accounts</h1>
    <div class="row g-4">
        <?php foreach ($authors as $author): ?>
            <?php $count = count(array_filter($contents, fn($c) => (int)$c['author_id'] === (int)$author['id'])); ?>
            <div class="col-md-6 col-lg-4">
                <div class="sw-panel h-100">
                    <h2 class="h5"><?= e($author['name']) ?></h2>
                    <p class="sw-muted"><?= e($author['email']) ?></p>
                    <p><span class="badge sw-badge"><?= $count ?> contents</span></p>
                    <form method="post"><?= csrf_field() ?><input type="hidden" name="user_id" value="<?= e((string)$author['id']) ?>"><button class="btn btn-outline-danger btn-sm">Demote Author</button></form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php require __DIR__ . '/includes/admin-sidebar-end.php'; ?>
<?php require __DIR__ . '/includes/footer.php'; ?>

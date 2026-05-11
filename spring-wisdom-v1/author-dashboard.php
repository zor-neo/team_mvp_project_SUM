<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/storage.php';
require_role(['author']);

$user = current_user();

if (is_post()) {
    require_csrf();
    $action = $_POST['action'] ?? '';
    if ($action === 'create') {
        $data = [
            'title' => trim($_POST['title'] ?? ''),
            'category' => trim($_POST['category'] ?? ''),
            'summary' => trim($_POST['summary'] ?? ''),
            'body' => trim($_POST['body'] ?? ''),
        ];
        $id = create_content((int) $user['id'], $data);
        $filePath = storage_upload($_FILES['source_file'] ?? [], $id);
        if ($filePath) {
            update_content($id, ['title' => $data['title'], 'category' => $data['category'], 'summary' => $data['summary'], 'body' => $data['body'], 'file_path' => $filePath]);
        }
        flash('Content created.');
    }
    if ($action === 'update') {
        $content = content_by_id((int) $_POST['content_id']);
        if ($content && (int) $content['author_id'] === (int) actual_user()['id']) {
            update_content((int) $_POST['content_id'], [
                'title' => trim($_POST['title'] ?? ''),
                'category' => trim($_POST['category'] ?? ''),
                'summary' => trim($_POST['summary'] ?? ''),
                'body' => trim($_POST['body'] ?? ''),
            ]);
            flash('Content updated.');
        } else {
            flash('You can only edit your own content.', 'danger');
        }
    }
    if ($action === 'delete') {
        $content = content_by_id((int) $_POST['content_id']);
        if ($content && (int) $content['author_id'] === (int) actual_user()['id']) {
            delete_content((int) $_POST['content_id']);
            flash('Content deleted.', 'warning');
        } else {
            flash('You can only delete your own content.', 'danger');
        }
    }
    redirect_to('author-dashboard.php');
}

$myContents = array_values(array_filter(all_contents(true), fn($c) => (int) $c['author_id'] === (int) $user['id'] || $user['role'] === 'admin'));
$pageTitle = 'My Space';
$active = 'my-space';
require __DIR__ . '/includes/header.php';
?>
<section class="container-lg py-5">
    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 align-items-md-end mb-4">
        <div>
            <h1 class="display-6 fw-bold">My Space</h1>
            <p class="sw-muted mb-0">Upload, modify, and delete reading hub contents.</p>
        </div>
        <img src="<?= e(url_for('assets/images/book.svg')) ?>" alt="Book illustration" class="rounded-circle border" style="width:72px;height:72px;object-fit:cover;">
    </div>

    <div class="sw-panel mb-5">
        <div class="d-flex align-items-center gap-3 mb-4">
            <i class="bi bi-upload fs-2 text-primary"></i>
            <h2 class="h3 mb-0">Upload New Content</h2>
        </div>
        <form method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
            <?= csrf_field() ?>
            <input type="hidden" name="action" value="create">
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Content Title</label><input class="form-control" name="title" required></div>
                <div class="col-md-6">
                    <label class="form-label">Category</label>
                    <select class="form-select" name="category" required>
                        <option>Historical Archives</option><option>Philosophy</option><option>Logic & Reason</option><option>Scientific Method</option><option>Literature Collections</option>
                    </select>
                </div>
                <div class="col-12"><label class="form-label">Summary</label><input class="form-control" name="summary" required></div>
                <div class="col-12"><label class="form-label">Content Body</label><textarea class="form-control" name="body" rows="6" required></textarea></div>
                <div class="col-12"><label class="form-label">Optional Source File</label><input class="form-control" name="source_file" type="file" accept=".pdf,.txt,.docx"></div>
            </div>
            <div class="text-end mt-4"><button class="btn btn-sw-primary">Create Content</button></div>
        </form>
    </div>

    <h2 class="h3 fw-bold mb-4">My Collections</h2>
    <div class="row g-4">
        <?php foreach ($myContents as $content): ?>
            <div class="col-lg-4 col-md-6">
                <article class="card h-100">
                    <img src="<?= e(url_for('assets/images/library.svg')) ?>" class="card-img-top" alt="Library illustration">
                    <div class="card-body">
                        <span class="badge sw-badge"><?= e($content['category']) ?></span>
                        <h3 class="h5 mt-3"><?= e($content['title']) ?></h3>
                        <p class="sw-muted"><?= e($content['summary']) ?></p>
                    </div>
                    <div class="card-footer bg-white d-flex justify-content-between">
                        <button class="btn btn-sm btn-outline-sw" data-bs-toggle="modal" data-bs-target="#edit<?= e((string)$content['id']) ?>"><i class="bi bi-pencil"></i> Edit</button>
                        <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#delete<?= e((string)$content['id']) ?>"><i class="bi bi-trash"></i> Delete</button>
                    </div>
                </article>
            </div>

            <div class="modal fade" id="edit<?= e((string)$content['id']) ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <form method="post" class="modal-content needs-validation" novalidate>
                        <?= csrf_field() ?>
                        <input type="hidden" name="action" value="update"><input type="hidden" name="content_id" value="<?= e((string)$content['id']) ?>">
                        <div class="modal-header"><h5 class="modal-title">Edit Content</h5><button class="btn-close" type="button" data-bs-dismiss="modal"></button></div>
                        <div class="modal-body row g-3">
                            <div class="col-md-6"><label class="form-label">Title</label><input class="form-control" name="title" value="<?= e($content['title']) ?>" required></div>
                            <div class="col-md-6"><label class="form-label">Category</label><input class="form-control" name="category" value="<?= e($content['category']) ?>" required></div>
                            <div class="col-12"><label class="form-label">Summary</label><input class="form-control" name="summary" value="<?= e($content['summary']) ?>" required></div>
                            <div class="col-12"><label class="form-label">Body</label><textarea class="form-control" name="body" rows="6" required><?= e($content['body']) ?></textarea></div>
                        </div>
                        <div class="modal-footer"><button class="btn btn-sw-primary">Save Changes</button></div>
                    </form>
                </div>
            </div>
            <div class="modal fade" id="delete<?= e((string)$content['id']) ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="post" class="modal-content">
                        <?= csrf_field() ?>
                        <input type="hidden" name="action" value="delete"><input type="hidden" name="content_id" value="<?= e((string)$content['id']) ?>">
                        <div class="modal-header"><h5 class="modal-title">Delete Content</h5><button class="btn-close" type="button" data-bs-dismiss="modal"></button></div>
                        <div class="modal-body">Delete "<?= e($content['title']) ?>"?</div>
                        <div class="modal-footer"><button class="btn btn-outline-sw" type="button" data-bs-dismiss="modal">Cancel</button><button class="btn btn-danger">Delete</button></div>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>

<?php
require_once __DIR__ . '/includes/auth.php';
require_role(['admin']);

if (is_post()) {
    require_csrf();
    $action = $_POST['action'] ?? '';
    if ($action === 'create_category') {
        $created = create_content_category(trim($_POST['name'] ?? ''), trim($_POST['description'] ?? ''));
        flash($created ? 'Category added.' : 'Category name is required or already exists.', $created ? 'success' : 'danger');
    }
    if ($action === 'update_category') {
        $updated = update_content_category(
            (int) ($_POST['category_id'] ?? 0),
            trim($_POST['name'] ?? ''),
            trim($_POST['description'] ?? ''),
            isset($_POST['is_active'])
        );
        flash($updated ? 'Category updated.' : 'Category could not be updated. Check for duplicate names.', $updated ? 'success' : 'danger');
    }
    redirect_to('admin-resource-management.php');
}

$categories = all_content_categories(true);
$categoryCounts = content_analytics()['category_counts'];
$pageTitle = 'Resource Management';
$active = 'admin-resources';
require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/admin-sidebar.php';
?>
<section class="container-lg py-5">
    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 align-items-md-end mb-4">
        <div>
            <h1 class="display-6 fw-bold mb-1">Resource Management</h1>
            <p class="sw-muted mb-0">Manage content categories used by Browse, Archives, and author publishing workflows.</p>
        </div>
        <span class="badge sw-badge"><?= e((string) count($categories)) ?> categories</span>
    </div>

    <div class="sw-panel mb-4">
        <h2 class="h4 fw-bold mb-3"><i class="bi bi-plus-circle text-primary"></i> Add Category</h2>
        <form method="post" class="row g-3 align-items-end">
            <?= csrf_field() ?>
            <input type="hidden" name="action" value="create_category">
            <div class="col-md-4">
                <label class="form-label">Category name</label>
                <input class="form-control" name="name" maxlength="80" required placeholder="Example: Research Skills">
            </div>
            <div class="col-md-6">
                <label class="form-label">Description</label>
                <input class="form-control" name="description" maxlength="260" placeholder="Optional internal note for admins and authors">
            </div>
            <div class="col-md-2">
                <button class="btn btn-sw-primary w-100">Add</button>
            </div>
        </form>
    </div>

    <div class="sw-panel">
        <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
            <div>
                <h2 class="h4 fw-bold mb-1"><i class="bi bi-collection text-primary"></i> Current Categories</h2>
                <p class="small sw-muted mb-0">Renaming a category also updates existing content assigned to that category.</p>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Content</th>
                        <th>Status</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                        <?php $formId = 'categoryForm' . (int) $category['id']; ?>
                        <tr>
                            <td style="min-width: 220px;">
                                <form id="<?= e($formId) ?>" method="post">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="action" value="update_category">
                                    <input type="hidden" name="category_id" value="<?= e((string) $category['id']) ?>">
                                </form>
                                <input class="form-control" form="<?= e($formId) ?>" name="name" value="<?= e($category['name']) ?>" maxlength="80" required>
                            </td>
                            <td style="min-width: 260px;">
                                <input class="form-control" form="<?= e($formId) ?>" name="description" value="<?= e($category['description'] ?? '') ?>" maxlength="260">
                            </td>
                            <td>
                                <span class="badge rounded-pill text-bg-light border text-secondary"><?= e((string) ($categoryCounts[$category['name']] ?? 0)) ?></span>
                            </td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" form="<?= e($formId) ?>" type="checkbox" name="is_active" id="categoryActive<?= e((string) $category['id']) ?>" <?= !empty($category['is_active']) ? 'checked' : '' ?>>
                                    <label class="form-check-label small" for="categoryActive<?= e((string) $category['id']) ?>">Active</label>
                                </div>
                            </td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-outline-sw" form="<?= e($formId) ?>">Update</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<?php require __DIR__ . '/includes/admin-sidebar-end.php'; ?>
<?php require __DIR__ . '/includes/footer.php'; ?>

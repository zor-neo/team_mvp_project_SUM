<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/gemini_seed.php';
require_role(['admin']);

$devKey = getenv('DEV_AI_SEED_KEY') ?: '';
$providedKey = $_GET['key'] ?? $_POST['key'] ?? '';
$allowed = $devKey !== '' && hash_equals($devKey, (string) $providedKey);
$created = [];
$error = '';
$authors = all_users('author');
$categories = ai_seed_categories();
$selectedCategory = $_POST['category'] ?? $categories[0];
$selectedAuthor = (int) ($_POST['author_id'] ?? ($authors[0]['id'] ?? 0));

if (!$allowed) {
    http_response_code(403);
}

if ($allowed && is_post()) {
    require_csrf();
    $selectedCategory = in_array($selectedCategory, $categories, true) ? $selectedCategory : $categories[0];
    $authorIds = array_map(fn($author) => (int) $author['id'], $authors);
    if (!$authors || !in_array($selectedAuthor, $authorIds, true)) {
        $error = 'Create or promote an author account before seeding AI content.';
    } else {
        $result = gemini_seed_generate([
            'topic' => $_POST['topic'] ?? '',
            'category' => $selectedCategory,
            'tone' => $_POST['tone'] ?? '',
            'level' => $_POST['level'] ?? '',
            'count' => (int) ($_POST['count'] ?? 1),
            'length' => $_POST['length'] ?? 'medium',
        ]);

        if (!$result['ok']) {
            $error = $result['error'];
        } else {
            foreach ($result['items'] as $item) {
                $id = create_content($selectedAuthor, $item);
                $created[] = ['id' => $id, 'title' => $item['title']];
            }
            flash(count($created) . ' Gemini-generated archive item(s) published.');
        }
    }
}

$pageTitle = 'Dev AI Seed';
$active = 'admin';
require __DIR__ . '/includes/header.php';
?>
<section class="container-lg py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <?php if (!$allowed): ?>
                <div class="sw-panel">
                    <span class="badge text-bg-danger mb-3">Dev tool locked</span>
                    <h1 class="h3 fw-bold">AI archive seeding is not available.</h1>
                    <p class="sw-muted mb-0">Sign in as admin and open this page with the matching local <code>DEV_AI_SEED_KEY</code>.</p>
                </div>
            <?php else: ?>
                <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-4">
                    <div>
                        <span class="badge sw-badge mb-3">Hidden Dev Tool</span>
                        <h1 class="display-6 fw-bold mb-2">Gemini Archive Seeder</h1>
                        <p class="sw-muted mb-0">Generate archive-ready readings and publish them directly into Spring Wisdom.</p>
                    </div>
                    <a class="btn btn-outline-sw align-self-md-end" href="<?= e(url_for('archives.php')) ?>">View Archives</a>
                </div>

                <?php if ($error !== ''): ?>
                    <div class="alert alert-danger"><?= e($error) ?></div>
                <?php endif; ?>

                <?php if ($created): ?>
                    <div class="sw-panel mb-4">
                        <h2 class="h5 fw-bold">Published Items</h2>
                        <div class="list-group list-group-flush">
                            <?php foreach ($created as $item): ?>
                                <a class="list-group-item list-group-item-action bg-transparent" href="<?= e(url_for('content.php?id=' . $item['id'] . '&from=archives')) ?>">
                                    <?= e($item['title']) ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <form method="post" class="sw-panel">
                    <?= csrf_field() ?>
                    <input type="hidden" name="key" value="<?= e((string) $providedKey) ?>">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Topic or prompt</label>
                            <textarea class="form-control" name="topic" rows="3" required placeholder="Example: How students can evaluate historical sources online"><?= e($_POST['topic'] ?? '') ?></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Category</label>
                            <select class="form-select" name="category" required>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= e($category) ?>" <?= $selectedCategory === $category ? 'selected' : '' ?>><?= e($category) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Author account</label>
                            <select class="form-select" name="author_id" required>
                                <?php foreach ($authors as $author): ?>
                                    <option value="<?= e((string) $author['id']) ?>" <?= $selectedAuthor === (int) $author['id'] ? 'selected' : '' ?>><?= e($author['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tone</label>
                            <input class="form-control" name="tone" value="<?= e($_POST['tone'] ?? 'clear academic') ?>" maxlength="80">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Reading level</label>
                            <input class="form-control" name="level" value="<?= e($_POST['level'] ?? 'undergraduate students') ?>" maxlength="80">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Count</label>
                            <input class="form-control" name="count" type="number" min="1" max="5" value="<?= e($_POST['count'] ?? '1') ?>">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Length</label>
                            <select class="form-select" name="length">
                                <?php foreach (['short' => 'Short', 'medium' => 'Medium', 'long' => 'Long'] as $value => $label): ?>
                                    <option value="<?= e($value) ?>" <?= ($_POST['length'] ?? 'medium') === $value ? 'selected' : '' ?>><?= e($label) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mt-4">
                        <p class="small sw-muted mb-0">Requires server-side <code>GEMINI_API_KEY</code>. Publishes immediately.</p>
                        <button class="btn btn-sw-primary">Generate and Publish</button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>

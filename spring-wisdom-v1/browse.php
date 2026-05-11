<?php
require_once __DIR__ . '/includes/auth.php';
require_login();

$selectedCategory = trim($_GET['category'] ?? '');
$sort = ($_GET['sort'] ?? 'newest') === 'oldest' ? 'oldest' : 'newest';
$perPage = 6;
$contents = all_contents();
$categories = ['Philosophy', 'Logic & Reason', 'Scientific Method', 'Historical Archives', 'Daily Challenges'];
if ($selectedCategory !== '') {
    $contents = array_values(array_filter($contents, fn($content) => strcasecmp($content['category'], $selectedCategory) === 0));
}
usort($contents, function ($a, $b) use ($sort) {
    $aDate = strtotime((string) ($a['created_at'] ?? '')) ?: 0;
    $bDate = strtotime((string) ($b['created_at'] ?? '')) ?: 0;
    return $sort === 'oldest' ? $aDate <=> $bDate : $bDate <=> $aDate;
});
$featured = $contents[0] ?? null;
$curatedContents = $featured ? array_values(array_filter($contents, fn($content) => (int) $content['id'] !== (int) $featured['id'])) : $contents;
$pagedContents = array_slice($curatedContents, 0, $perPage);
$currentBrowseQuery = array_filter(['category' => $selectedCategory, 'sort' => $sort !== 'newest' ? $sort : ''], fn($value) => $value !== '' && $value !== null);
$browseReturn = 'browse.php' . ($currentBrowseQuery ? '?' . http_build_query($currentBrowseQuery) : '');
$pageTitle = 'Browse';
$active = 'browse';
require __DIR__ . '/includes/header.php';
?>
<section class="sw-hero">
    <div class="container-lg">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-start gap-4">
            <div>
                <h1 class="display-5 fw-bold mb-3">Cultivate Your Mind.</h1>
                <p class="lead sw-muted mb-0" style="max-width: 680px;">Discover featured readings, browse by topic, and move into the full archive when you need deeper filtering.</p>
            </div>
            <div class="sw-hub-controls">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                    <input data-content-search class="form-control" placeholder="Search archive...">
                </div>
                <form method="get">
                    <?php if ($selectedCategory !== ''): ?>
                        <input type="hidden" name="category" value="<?= e($selectedCategory) ?>">
                    <?php endif; ?>
                    <select class="form-select form-select-sm sw-sort-compact" name="sort" onchange="this.form.submit()" aria-label="Sort browse contents">
                        <option value="newest" <?= $sort === 'newest' ? 'selected' : '' ?>>Newest first</option>
                        <option value="oldest" <?= $sort === 'oldest' ? 'selected' : '' ?>>Oldest first</option>
                    </select>
                </form>
            </div>
        </div>
        <div class="sw-chip-row mt-4">
            <a class="sw-chip <?= $selectedCategory === '' ? 'active' : '' ?>" href="<?= e(url_for('browse.php' . ($sort !== 'newest' ? '?sort=' . urlencode($sort) : ''))) ?>">All</a>
            <?php foreach ($categories as $category): ?>
                <?php $chipQuery = array_filter(['category' => $category, 'sort' => $sort !== 'newest' ? $sort : ''], fn($value) => $value !== ''); ?>
                <a class="sw-chip <?= strcasecmp($selectedCategory, $category) === 0 ? 'active' : '' ?>" href="<?= e(url_for('browse.php?' . http_build_query($chipQuery))) ?>"><?= e($category) ?></a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<section class="container-lg pb-5">
    <?php if ($featured): ?>
        <article class="card mb-5 overflow-hidden">
            <div class="row g-0">
                <div class="col-md-5"><img class="h-100 w-100 object-fit-cover" src="<?= e(url_for('assets/images/book.svg')) ?>" alt="Open book illustration"></div>
                <div class="col-md-7">
                    <div class="card-body p-4 p-lg-5">
                        <span class="badge sw-badge"><?= e($featured['category']) ?></span>
                        <h2 class="h3 fw-bold mt-3"><?= e($featured['title']) ?></h2>
                        <p class="sw-muted"><?= e($featured['summary']) ?></p>
                        <a class="btn btn-sw-primary" href="<?= e(url_for('content.php?' . http_build_query(['id' => $featured['id'], 'from' => 'browse', 'return' => $browseReturn]))) ?>">Read Full Archive</a>
                    </div>
                </div>
            </div>
        </article>
    <?php endif; ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 fw-bold mb-1">Curated Selections</h2>
            <p class="small sw-muted mb-0">Showing selected highlights from <?= e((string) count($contents)) ?> matching resource<?= count($contents) === 1 ? '' : 's' ?></p>
        </div>
        <a class="sw-underlined-link fw-semibold" href="<?= e(url_for('archives.php')) ?>">View all archives</a>
    </div>
    <div class="row g-4">
        <?php foreach ($pagedContents as $content): ?>
            <div class="col-md-6 col-lg-4" data-content-card>
                <article class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between gap-3">
                            <span class="badge sw-badge"><?= e($content['category']) ?></span>
                            <button class="btn btn-sm btn-outline-sw" type="button" data-bookmark><i class="bi bi-bookmark"></i></button>
                        </div>
                        <h3 class="h5 mt-3"><?= e($content['title']) ?></h3>
                        <p class="sw-muted"><?= e($content['summary']) ?></p>
                    </div>
                    <div class="card-footer bg-white border-0 pt-0">
                        <a href="<?= e(url_for('content.php?' . http_build_query(['id' => $content['id'], 'from' => 'browse', 'return' => $browseReturn]))) ?>" class="fw-semibold">Open reading <i class="bi bi-arrow-right"></i></a>
                    </div>
                </article>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>

<?php
require_once __DIR__ . '/includes/auth.php';
require_login();

$category = trim($_GET['category'] ?? '');
$authorId = (int) ($_GET['author_id'] ?? 0);
$sort = ($_GET['sort'] ?? 'newest') === 'oldest' ? 'oldest' : 'newest';
$currentPage = max(1, (int) ($_GET['page'] ?? 1));
$perPage = 12;

$allContents = all_contents();
$categories = array_values(array_unique(array_map(fn($content) => $content['category'], $allContents)));
sort($categories);
$authors = all_users('author');

$filteredContents = array_values(array_filter($allContents, function ($content) use ($category, $authorId) {
    if ($category !== '' && strcasecmp((string) $content['category'], $category) !== 0) {
        return false;
    }
    if ($authorId > 0 && (int) $content['author_id'] !== $authorId) {
        return false;
    }
    return true;
}));
usort($filteredContents, function ($a, $b) use ($sort) {
    $aDate = strtotime((string) ($a['created_at'] ?? '')) ?: 0;
    $bDate = strtotime((string) ($b['created_at'] ?? '')) ?: 0;
    return $sort === 'oldest' ? $aDate <=> $bDate : $bDate <=> $aDate;
});
$totalPages = max(1, (int) ceil(count($filteredContents) / $perPage));
$currentPage = min($currentPage, $totalPages);
$pageOffset = ($currentPage - 1) * $perPage;
$pagedContents = array_slice($filteredContents, $pageOffset, $perPage);
$filterQuery = array_filter(['category' => $category, 'author_id' => $authorId > 0 ? $authorId : '', 'sort' => $sort !== 'newest' ? $sort : ''], fn($value) => $value !== '' && $value !== null);
$pageQuerySuffix = $filterQuery ? '&' . http_build_query($filterQuery) : '';
$archiveReturnQuery = array_filter(['category' => $category, 'author_id' => $authorId > 0 ? $authorId : '', 'sort' => $sort !== 'newest' ? $sort : '', 'page' => $currentPage > 1 ? $currentPage : ''], fn($value) => $value !== '' && $value !== null);
$archiveReturn = 'archives.php' . ($archiveReturnQuery ? '?' . http_build_query($archiveReturnQuery) : '');

$pageTitle = 'All Archives';
$active = 'browse';
require __DIR__ . '/includes/header.php';
?>
<section class="sw-section">
    <div class="container-lg">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3 mb-4">
            <div>
                <span class="badge sw-badge mb-3">Reading Archive</span>
                <h1 class="h2 fw-bold mb-2">All Archives</h1>
                <p class="sw-muted mb-0">Use the complete archive when you need the full collection with deeper category, author, and sorting controls.</p>
            </div>
            <a class="sw-underlined-link fw-semibold" href="<?= e(url_for('browse.php')) ?>">Back to curated browse</a>
        </div>

        <form method="get" class="sw-panel mb-4">
            <div class="row g-3 align-items-end">
                <div class="col-md-6 col-lg-3">
                    <label class="form-label">Category</label>
                    <select class="form-select" name="category">
                        <option value="">All categories</option>
                        <?php foreach ($categories as $item): ?>
                            <option value="<?= e($item) ?>" <?= strcasecmp($category, $item) === 0 ? 'selected' : '' ?>><?= e($item) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 col-lg-3">
                    <label class="form-label">Author</label>
                    <select class="form-select" name="author_id">
                        <option value="0">All authors</option>
                        <?php foreach ($authors as $author): ?>
                            <option value="<?= e((string) $author['id']) ?>" <?= $authorId === (int) $author['id'] ? 'selected' : '' ?>><?= e($author['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 col-lg-3">
                    <label class="form-label">Sort</label>
                    <select class="form-select" name="sort">
                        <option value="newest" <?= $sort === 'newest' ? 'selected' : '' ?>>Newest first</option>
                        <option value="oldest" <?= $sort === 'oldest' ? 'selected' : '' ?>>Oldest first</option>
                    </select>
                </div>
                <div class="col-lg-3 d-flex gap-2">
                    <button class="btn btn-sw-primary flex-fill" type="submit">Filter</button>
                    <a class="btn btn-outline-sw" href="<?= e(url_for('archives.php')) ?>" aria-label="Reset filters"><i class="bi bi-arrow-clockwise"></i></a>
                </div>
            </div>
        </form>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h5 fw-bold mb-0"><?= e((string) count($filteredContents)) ?> archive item<?= count($filteredContents) === 1 ? '' : 's' ?></h2>
            <?php if ($category !== '' || $authorId > 0 || $sort !== 'newest'): ?>
                <span class="small sw-muted"><?= $sort === 'oldest' ? 'Oldest first' : 'Filtered results' ?></span>
            <?php endif; ?>
        </div>

        <?php if ($pagedContents): ?>
            <div class="row g-4">
                <?php foreach ($pagedContents as $content): ?>
                    <div class="col-md-6 col-lg-4" data-content-card>
                        <article class="card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between gap-3 align-items-start mb-3">
                                    <span class="badge sw-badge"><?= e($content['category']) ?></span>
                                    <span class="small sw-muted"><?= e(substr((string) $content['created_at'], 0, 10)) ?></span>
                                </div>
                                <h3 class="h5 fw-bold"><?= e($content['title']) ?></h3>
                                <p class="small sw-muted mb-2">By <?= e($content['author_name'] ?? 'Author') ?></p>
                                <p class="sw-muted"><?= e($content['summary']) ?></p>
                            </div>
                            <div class="card-footer bg-white border-0 pt-0">
                                <a href="<?= e(url_for('content.php?' . http_build_query(['id' => $content['id'], 'from' => 'archives', 'return' => $archiveReturn]))) ?>" class="fw-semibold">Open reading <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php if ($totalPages > 1): ?>
                <nav class="mt-5" aria-label="Archive pagination">
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?= $currentPage === 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="<?= e(url_for('archives.php?page=' . max(1, $currentPage - 1) . $pageQuerySuffix)) ?>">Previous</a>
                        </li>
                        <?php for ($page = 1; $page <= $totalPages; $page++): ?>
                            <li class="page-item <?= $page === $currentPage ? 'active' : '' ?>">
                                <a class="page-link" href="<?= e(url_for('archives.php?page=' . $page . $pageQuerySuffix)) ?>"><?= e((string) $page) ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?= $currentPage === $totalPages ? 'disabled' : '' ?>">
                            <a class="page-link" href="<?= e(url_for('archives.php?page=' . min($totalPages, $currentPage + 1) . $pageQuerySuffix)) ?>">Next</a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
        <?php else: ?>
            <div class="sw-panel text-center py-5">
                <i class="bi bi-journal-x fs-1 text-primary"></i>
                <h2 class="h4 fw-bold mt-3">No archives found</h2>
                <p class="sw-muted mb-0">Try clearing a filter or choosing a different category or author.</p>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>

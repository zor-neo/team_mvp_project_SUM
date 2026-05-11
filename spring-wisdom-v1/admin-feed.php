<?php
require_once __DIR__ . '/includes/auth.php';
$feeds = all_feeds();
$featured = $feeds[0] ?? null;
$pageTitle = 'Updates';
$active = 'feed';
require __DIR__ . '/includes/header.php';
?>
<section class="container-lg py-5">
    <header class="mb-5 border-bottom pb-4">
        <span class="badge sw-badge mb-3">Spring Wisdom Updates</span>
        <h1 class="display-5 fw-bold">Latest Updates</h1>
        <p class="lead sw-muted">Insights, platform notices, and administrative decisions shaping the reading hub.</p>
    </header>
    <?php if ($featured): ?>
        <article class="card mb-5 overflow-hidden">
            <div class="row g-0">
                <div class="col-md-5"><img class="h-100 w-100 object-fit-cover" src="<?= e(url_for('assets/images/dashboard.svg')) ?>" alt="Dashboard illustration"></div>
                <div class="col-md-7"><div class="card-body p-4 p-lg-5"><time class="small text-muted"><?= e($featured['created_at']) ?></time><h2 class="h3 fw-bold mt-3"><?= e($featured['title']) ?></h2><p class="sw-muted"><?= e($featured['body']) ?></p></div></div>
            </div>
        </article>
    <?php endif; ?>
    <div class="row g-4">
        <?php foreach (array_slice($feeds, 1) as $feed): ?>
            <div class="col-md-6">
                <article class="sw-panel h-100">
                    <time class="small text-muted"><?= e($feed['created_at']) ?></time>
                    <h2 class="h5 mt-2"><?= e($feed['title']) ?></h2>
                    <p class="sw-muted"><?= e($feed['summary']) ?></p>
                </article>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>


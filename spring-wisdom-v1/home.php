<?php
require_once __DIR__ . '/includes/auth.php';
$feeds = all_feeds(3);
$pageTitle = 'Home';
$active = 'home';
require __DIR__ . '/includes/header.php';
?>
<section class="sw-section">
    <div class="container-lg">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <h1 class="display-5 fw-bold mb-4">Nurturing Hope, Unlocking Potential in Every Learner.</h1>
                <p class="lead sw-muted"><span class="d-inline-block fst-italic fs-4 fw-semibold text-dark border-start border-3 ps-3">
  “Breakthroughs are rarely easy; they are often born in struggle,”
</span>much like the sun breaking through a dense morning fog. <span class="text-primary fw-bold"> Spring Wisdom </span> is a unique student-built environment that preserves and clarifies knowledge to ease that path. We offer a space to build foundations and explore new frontiers, providing the fresh hope of a spring morning for a dedicated, continuous learning journey.</p>
                <a class="btn btn-sw-primary mt-3" href="<?= e(url_for(current_user() ? 'browse.php' : 'index.php')) ?>">Browse Contents</a>
            </div>
            <div class="col-lg-6">
                <div class="sw-visual"><img src="<?= e(url_for('assets/images/featured_img.png')) ?>" alt="Illustration of children learning in war-torn scenario in Myanmar"></div>
            </div>
        </div>
    </div>
</section>
<section class="sw-section sw-soft border-top border-bottom">
    <div class="container-lg">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="badge sw-badge mb-2">Admin Feed</span>
                <h2 class="h3 fw-bold mb-0">Administrative Updates</h2>
            </div>
            <a href="<?= e(url_for('admin-feed.php')) ?>" class="fw-semibold">Read all updates <i class="bi bi-arrow-right"></i></a>
        </div>
        <div class="row g-4">
            <?php foreach ($feeds as $feed): ?>
                <div class="col-md-4">
                    <article class="card h-100">
                        <div class="card-body">
                            <time class="small text-muted"><?= e($feed['created_at']) ?></time>
                            <h3 class="h5 mt-3"><?= e($feed['title']) ?></h3>
                            <p class="sw-muted"><?= e($feed['summary']) ?></p>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>

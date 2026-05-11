<?php
require_once __DIR__ . '/includes/auth.php';
require_role(['author']);

$user = current_user();
$contents = contents_for_author((int) $user['id'], true);
$categoryCounts = content_count_by_category($contents);
$dateCounts = content_count_by_date($contents);
$totalContents = count($contents);
$totalCategories = count($categoryCounts);
$latestDate = latest_content_date($contents);

$pageTitle = 'Author Analytics';
$active = 'author-analytics';
require __DIR__ . '/includes/header.php';
?>
<section class="container-lg py-5">
    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 align-items-md-end mb-4">
        <div>
            <h1 class="display-6 fw-bold">Analytics</h1>
            <p class="sw-muted mb-0">Your contribution summary, categories, and posting frequency.</p>
        </div>
        <a class="btn btn-outline-sw" href="<?= e(url_for('author-dashboard.php')) ?>"><i class="bi bi-arrow-left"></i> Back to My Space</a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4"><div class="sw-panel metric-card h-100"><span class="small text-uppercase sw-muted">Total contents</span><strong class="d-block"><?= e((string) $totalContents) ?></strong></div></div>
        <div class="col-md-4"><div class="sw-panel metric-card h-100"><span class="small text-uppercase sw-muted">Categories used</span><strong class="d-block"><?= e((string) $totalCategories) ?></strong></div></div>
        <div class="col-md-4"><div class="sw-panel metric-card h-100"><span class="small text-uppercase sw-muted">Latest post</span><strong class="d-block fs-4"><?= e($latestDate) ?></strong></div></div>
    </div>

    <?php if ($totalContents === 0): ?>
        <div class="sw-panel text-center py-5">
            <i class="bi bi-bar-chart fs-1 text-primary"></i>
            <h2 class="h4 mt-3">No analytics yet</h2>
            <p class="sw-muted mb-0">Create content in My Space to generate category and frequency charts.</p>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <div class="col-lg-5">
                <div class="sw-panel h-100">
                    <h2 class="h4 fw-bold mb-3">Categories Pie Chart</h2>
                    <canvas id="authorCategoryChart" height="260"></canvas>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="sw-panel h-100">
                    <h2 class="h4 fw-bold mb-3">Posting Frequency</h2>
                    <canvas id="authorFrequencyChart" height="260"></canvas>
                </div>
            </div>
        </div>
    <?php endif; ?>
</section>
<?php if ($totalContents > 0): ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script>
const swChartColors = ['#465f8a', '#b1cafb', '#665881', '#565f71', '#a3bcec', '#d0bfee'];
new Chart(document.getElementById('authorCategoryChart'), {
  type: 'pie',
  data: {
    labels: <?= json_encode(array_keys($categoryCounts)) ?>,
    datasets: [{ data: <?= json_encode(array_values($categoryCounts)) ?>, backgroundColor: swChartColors }]
  }
});
new Chart(document.getElementById('authorFrequencyChart'), {
  type: 'line',
  data: {
    labels: <?= json_encode(array_keys($dateCounts)) ?>,
    datasets: [{ label: 'Posts', data: <?= json_encode(array_values($dateCounts)) ?>, borderColor: '#465f8a', backgroundColor: 'rgba(70,95,138,.14)', tension: .35, fill: true }]
  },
  options: { scales: { y: { beginAtZero: true, ticks: { precision: 0 } } } }
});
</script>
<?php endif; ?>
<?php require __DIR__ . '/includes/footer.php'; ?>

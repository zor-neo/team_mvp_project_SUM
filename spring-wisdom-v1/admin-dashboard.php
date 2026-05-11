<?php
require_once __DIR__ . '/includes/auth.php';
require_role(['admin']);
$counts = dashboard_counts();
$reports = array_slice(all_reports(), 0, 2);
$requests = array_slice(array_filter(all_author_requests(), fn($r) => $r['status'] === 'pending'), 0, 3);
$messages = array_slice(all_messages(), 0, 2);
$allContents = all_contents(true);
$publishedContents = array_values(array_filter($allContents, fn($content) => ($content['status'] ?? '') === 'published'));
$hiddenContents = array_values(array_filter($allContents, fn($content) => ($content['status'] ?? '') === 'hidden'));
$siteCategoryCounts = content_count_by_category($allContents);
$siteDateCounts = content_count_by_date($allContents);
$siteAuthorsWithContent = count(array_unique(array_map(fn($content) => (int) $content['author_id'], $allContents)));
$siteLatestDate = latest_content_date($allContents);
$pageTitle = 'Admin Dashboard';
$active = 'admin';
require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/admin-sidebar.php';
?>
<section class="container-lg py-5">
    <div class="mb-4">
        <h1 class="display-6 fw-bold">Admin Landing Overview</h1>
        <p class="sw-muted">System health, moderation, author requests, messages, and analytics.</p>
    </div>
    <div class="row g-3 mb-5">
        <?php foreach ($counts as $label => $value): ?>
            <div class="col-md-6 col-xl">
                <div class="sw-panel metric-card h-100">
                    <span class="small text-uppercase sw-muted"><?= e(str_replace('_', ' ', $label)) ?></span>
                    <strong class="d-block"><?= e((string)$value) ?></strong>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="row g-4">
        <div class="col-xl-8">
            <div class="sw-panel mb-4">
                <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                    <div>
                        <h2 class="h4 fw-bold mb-1"><i class="bi bi-graph-up text-primary"></i> Whole Web Content Overview</h2>
                        <p class="small sw-muted mb-0">Site-wide publishing volume, categories, author coverage, and latest activity.</p>
                    </div>
                    <span class="badge sw-badge">Admin-wide</span>
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-md-4"><div class="border rounded p-3 h-100"><span class="small text-uppercase sw-muted">Total contents</span><strong class="d-block fs-4"><?= e((string) count($allContents)) ?></strong></div></div>
                    <div class="col-md-4"><div class="border rounded p-3 h-100"><span class="small text-uppercase sw-muted">Published</span><strong class="d-block fs-4"><?= e((string) count($publishedContents)) ?></strong></div></div>
                    <div class="col-md-4"><div class="border rounded p-3 h-100"><span class="small text-uppercase sw-muted">Hidden</span><strong class="d-block fs-4"><?= e((string) count($hiddenContents)) ?></strong></div></div>
                    <div class="col-md-4"><div class="border rounded p-3 h-100"><span class="small text-uppercase sw-muted">Categories</span><strong class="d-block fs-4"><?= e((string) count($siteCategoryCounts)) ?></strong></div></div>
                    <div class="col-md-4"><div class="border rounded p-3 h-100"><span class="small text-uppercase sw-muted">Authors with content</span><strong class="d-block fs-4"><?= e((string) $siteAuthorsWithContent) ?></strong></div></div>
                    <div class="col-md-4"><div class="border rounded p-3 h-100"><span class="small text-uppercase sw-muted">Latest content</span><strong class="d-block fs-5"><?= e($siteLatestDate) ?></strong></div></div>
                </div>
                <?php if (count($allContents) > 0): ?>
                    <div class="row g-4">
                        <div class="col-lg-5">
                            <h3 class="h6 fw-bold">Categories Pie Chart</h3>
                            <canvas id="siteCategoryChart" height="230"></canvas>
                        </div>
                        <div class="col-lg-7">
                            <h3 class="h6 fw-bold">Posting Frequency</h3>
                            <canvas id="siteFrequencyChart" height="230"></canvas>
                        </div>
                    </div>
                <?php else: ?>
                    <p class="sw-muted mb-0">No content has been contributed yet.</p>
                <?php endif; ?>
            </div>
            <div class="sw-panel mb-4">
                <h2 class="h4 fw-bold mb-3"><i class="bi bi-flag text-primary"></i> Reported Articles</h2>
                <?php foreach ($reports as $report): ?>
                    <div class="border rounded p-3 mb-3">
                        <strong><?= e($report['content_title']) ?></strong>
                        <p class="small sw-muted mb-2">Reported by <?= e($report['reporter_name']) ?> for <?= e($report['reason_category']) ?></p>
                        <a class="btn btn-sm btn-outline-sw" href="<?= e(url_for('admin-reports.php')) ?>">Review Report</a>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="sw-panel">
                <h2 class="h4 fw-bold mb-3"><i class="bi bi-bar-chart text-primary"></i> Analytics</h2>
                <p class="small sw-muted mb-2">Content coverage</p>
                <div class="progress mb-3"><div class="progress-bar" style="width: 72%"></div></div>
                <p class="small sw-muted mb-2">Author request resolution</p>
                <div class="progress"><div class="progress-bar" style="width: 48%"></div></div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="sw-panel mb-4">
                <h2 class="h4 fw-bold mb-3"><i class="bi bi-person-plus text-primary"></i> Author Requests</h2>
                <?php foreach ($requests as $request): ?>
                    <div class="border-bottom pb-3 mb-3">
                        <strong><?= e($request['user_name']) ?></strong>
                        <p class="small sw-muted mb-2"><?= e($request['reason_text']) ?></p>
                    </div>
                <?php endforeach; ?>
                <a href="<?= e(url_for('admin-author-requests.php')) ?>" class="fw-semibold">View all requests</a>
            </div>
            <div class="sw-panel">
                <h2 class="h4 fw-bold mb-3"><i class="bi bi-envelope text-primary"></i> Messages</h2>
                <?php foreach ($messages as $message): ?>
                    <div class="border-bottom pb-3 mb-3">
                        <strong><?= e($message['subject']) ?></strong>
                        <p class="small sw-muted mb-0">From <?= e($message['sender_name']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php if (count($allContents) > 0): ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script>
const siteChartColors = ['#465f8a', '#b1cafb', '#665881', '#565f71', '#a3bcec', '#d0bfee'];
new Chart(document.getElementById('siteCategoryChart'), {
  type: 'pie',
  data: {
    labels: <?= json_encode(array_keys($siteCategoryCounts)) ?>,
    datasets: [{ data: <?= json_encode(array_values($siteCategoryCounts)) ?>, backgroundColor: siteChartColors }]
  }
});
new Chart(document.getElementById('siteFrequencyChart'), {
  type: 'line',
  data: {
    labels: <?= json_encode(array_keys($siteDateCounts)) ?>,
    datasets: [{ label: 'Posts', data: <?= json_encode(array_values($siteDateCounts)) ?>, borderColor: '#465f8a', backgroundColor: 'rgba(70,95,138,.14)', tension: .35, fill: true }]
  },
  options: { scales: { y: { beginAtZero: true, ticks: { precision: 0 } } } }
});
</script>
<?php endif; ?>
<?php require __DIR__ . '/includes/admin-sidebar-end.php'; ?>
<?php require __DIR__ . '/includes/footer.php'; ?>

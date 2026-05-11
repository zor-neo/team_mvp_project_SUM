<?php
require_once __DIR__ . '/includes/auth.php';
$pageTitle = 'Report Policy';
$active = '';
require __DIR__ . '/includes/header.php';
?>
<section class="sw-section">
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="sw-panel">
                    <span class="badge sw-badge mb-3">Moderation</span>
                    <h1 class="h2 fw-bold">Report Policy</h1>
                    <p class="sw-muted">Readers can report content that appears inaccurate, incomplete, inappropriate, plagiarized, or broken.</p>
                    <div class="row g-3 mt-2">
                        <div class="col-md-6"><div class="border rounded-3 p-3 h-100"><h2 class="h5">Required Reason</h2><p class="sw-muted mb-0">Every report requires a category and a typed explanation so admin can review the issue fairly.</p></div></div>
                        <div class="col-md-6"><div class="border rounded-3 p-3 h-100"><h2 class="h5">Admin Review</h2><p class="sw-muted mb-0">Admins may dismiss the report, hide the content, or message the author for correction.</p></div></div>
                        <div class="col-md-6"><div class="border rounded-3 p-3 h-100"><h2 class="h5">Author Follow-up</h2><p class="sw-muted mb-0">Authors may update their work after receiving feedback from the admin team.</p></div></div>
                        <div class="col-md-6"><div class="border rounded-3 p-3 h-100"><h2 class="h5">Reader Safety</h2><p class="sw-muted mb-0">Reports are used to improve learning quality, not to remove content without review.</p></div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>

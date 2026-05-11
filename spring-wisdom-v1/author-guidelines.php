<?php
require_once __DIR__ . '/includes/auth.php';
$pageTitle = 'Author Guidelines';
$active = '';
require __DIR__ . '/includes/header.php';
?>
<section class="sw-section">
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="sw-panel">
                    <span class="badge sw-badge mb-3">Authors</span>
                    <h1 class="h2 fw-bold">Author Guidelines</h1>
                    <p class="sw-muted">Authors should publish clear, useful, and respectful learning content for readers.</p>
                    <ul class="list-group list-group-flush mt-3">
                        <li class="list-group-item bg-transparent px-0">Use a clear title, accurate category, short summary, and readable body text.</li>
                        <li class="list-group-item bg-transparent px-0">Attach only relevant learning files such as PDF, TXT, or DOCX sources.</li>
                        <li class="list-group-item bg-transparent px-0">Avoid copied work unless it is properly summarized, credited, and suitable for study use.</li>
                        <li class="list-group-item bg-transparent px-0">Respond to admin review messages when content is flagged or needs correction.</li>
                        <li class="list-group-item bg-transparent px-0">Keep tone academic, accessible, and appropriate for student readers.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>

<?php
require_once __DIR__ . '/includes/auth.php';
$pageTitle = 'Contact Us';
$active = '';
require __DIR__ . '/includes/header.php';
?>
<section class="sw-section">
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="sw-panel">
                    <span class="badge sw-badge mb-3">Support</span>
                    <h1 class="h2 fw-bold">Contact Us</h1>
                    <p class="sw-muted">Spring Wisdom is a student final project learning portal. Use this page as the standard contact reference for readers, authors, and administrators.</p>
                    <div class="row g-3 mt-2">
                        <div class="col-md-6">
                            <div class="border rounded-3 p-3 h-100">
                                <h2 class="h5 fw-bold">General Support</h2>
                                <p class="sw-muted mb-1">Email: <a href="mailto:contact@springwisdom.test">contact@springwisdom.test</a></p>
                                <p class="small sw-muted mb-0">For account questions, reading access, and general portal help.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border rounded-3 p-3 h-100">
                                <h2 class="h5 fw-bold">Content Review</h2>
                                <p class="sw-muted mb-1">Use the report button on any reading page.</p>
                                <p class="small sw-muted mb-0">Reports require a category and written reason before admin review.</p>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <p class="small sw-muted mb-0">Demo address: Spring Wisdom Learning Portal, Student Final Project Demo.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>

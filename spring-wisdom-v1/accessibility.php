<?php
require_once __DIR__ . '/includes/auth.php';
$pageTitle = 'Accessibility';
$active = '';
require __DIR__ . '/includes/header.php';
?>
<section class="sw-section">
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="sw-panel">
                    <span class="badge sw-badge mb-3">Accessibility</span>
                    <h1 class="h2 fw-bold">Accessibility</h1>
                    <p class="sw-muted">Spring Wisdom aims to keep the interface readable, responsive, and usable with standard Bootstrap components.</p>
                    <ul class="list-group list-group-flush mt-3">
                        <li class="list-group-item bg-transparent px-0">Responsive layouts are designed for desktop and mobile screens.</li>
                        <li class="list-group-item bg-transparent px-0">Forms use visible labels and standard browser validation where possible.</li>
                        <li class="list-group-item bg-transparent px-0">Buttons and links use recognizable text or icons with labels.</li>
                        <li class="list-group-item bg-transparent px-0">The warm paper theme keeps text contrast readable for long-form reading.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
